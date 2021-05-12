<?php
    namespace App\Http\Controllers\API;

    use App\Models\Chat;
    use App\Models\Friend;
    use App\Models\Lesson;
    use App\Models\User;
    use Auth;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class ChatController extends Controller {
        /**
         * * Get all the chats from an User.
         * @param Request $request
         * @return JSON
         */
        public function all (Request $request) {
            if (!$request->user()) {
                return response()->json([
                    'code' => 403,
                    'message' => 'Unauthenticated',
                ]);
            }

            foreach (Lesson::where('id_user_from', '=', $request->user()->id_user)->orwhere('id_user_to', '=', $request->user()->id_user)->get() as $lesson) {
                if (!Chat::exist($request->user()->id_user, ($request->user()->id_user === $lesson->id_user_from ? $lesson->id_user_to : $lesson->id_user_from))) {
                    Chat::create([
                        'id_chat' => null,
                        'id_user_from' => $lesson->id_user_from,
                        'id_user_to' => $lesson->id_user_to,
                        'messages' => "[]",
                    ]);
                }
            }

            if ($request->user()->id_role === 0) {
                foreach (Friend::where('id_user_from', '=', $request->user()->id_user)->orwhere('id_user_to', '=', $request->user()->id_user)->get() as $friend) {
                    if ($friend->accepted) {
                        if (!Chat::exist($request->user()->id_user, ($request->user()->id_user === $friend->id_user_from ? $friend->id_user_to : $friend->id_user_from))) {
                            Chat::create([
                                'id_chat' => null,
                                'id_user_from' => $friend->id_user_from,
                                'id_user_to' => $friend->id_user_to,
                                'messages' => "[]",
                            ]);
                        }
                    }
                }
            }

            $chats = Chat::where('id_user_from', '=', $request->user()->id_user)->orwhere('id_user_to', '=', $request->user()->id_user)->orderBy('updated_at')->get();

            foreach ($chats as $chat) {
                $chat->id_user_logged = $request->user()->id_user;
                $chat->users();
                $chat->type();
            }

            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'data' => [
                    'chats' => $chats,
                ],
            ]);
        }

        /**
         * * Get an specific Chat.
         * @param Request $request
         * @param int $id_user
         * @return JSON
         */
        public function get (Request $request, $id_user) {
            if (!$request->user()) {
                return response()->json([
                    'code' => 403,
                    'message' => 'Unauthenticated',
                ]);
            }

            $user = User::find($id_user);
            if (!$user) {
                return response()->json([
                    'code' => 404,
                    'message' => 'User does not exist',
                ]);
            }

            $chat = Chat::where('id_user_from', '=', $id_user)->orwhere('id_user_to', '=', $id_user)->limit(1);
            if (!$chat) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Chat does not exist',
                ]);
            }

            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'data' => [
                    'chat' => $chat,
                ],
            ]);
        }

        public function send (Request $request, $id_user) {
            if (!$request->user()) {
                return response()->json([
                    'code' => 403,
                    'message' => 'Unauthenticated',
                ]);
            }

            $user = User::find($id_user);
            if (!$user) {
                return response()->json([
                    'code' => 404,
                    'message' => 'User does not exist',
                ]);
            }

            $input = (object) $request->all();

            $validator = Validator::make($request->all(), Chat::$validation['send']['rules'], Chat::$validation['send']['messages']['es']);
            if ($validator->fails()) {
                return response()->json([
                    'code' => 401,
                    'message' => 'Validation error',
                    'data' => $validator
                ]);
            }

            $chat = Chat::where('id_user_from', '=', $id_user)->orwhere('id_user_to', '=', $id_user)->get()[0];

            $messages = collect([]);
            $id_message = 1;
            foreach (json_decode($chat->messages) as $message) {
                $id_message = intval($message->id_message) + 1;
                $messages->push($message);
                if (count($messages) === 20) {
                    $messages->shift();
                }
            }
            $messages->push([
                "id_message" => $id_message,
                "id_user" => $request->user()->id_user,
                "says" => $input->message,
            ]);

            $input->messages = json_encode($messages);

            $chat->update((array) $input);

            $chat->id_user_logged = $request->user()->id_user;
            $chat->users();
            $chat->messages();
            $chat->type();

            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'data' => [
                    'chat' => $chat,
                ],
            ]);
        }
    }