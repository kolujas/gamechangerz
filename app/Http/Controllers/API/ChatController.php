<?php
    namespace App\Http\Controllers\API;

    use App\Http\Controllers\Controller;
    use App\Models\Chat;
    use App\Models\Friend;
    use App\Models\Hour;
    use App\Models\Lesson;
    use App\Models\Mail;
    use App\Models\User;
    use Auth;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class ChatController extends Controller {
        /**
         * * Get all the chats from an User.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function all (Request $request) {
            if (!$request->user()) {
                return response()->json([
                    'code' => 403,
                    'message' => 'Unauthenticated',
                ]);
            }

            foreach (Lesson::startedByUser($request->user()->id_user)->get() as $lesson) {
                $lesson->and(["ended_at", "started_at"]);

                if ($lesson->id_status == 3 && $lesson->id_type == 2) {
                    if (!$lesson->chat) {
                        $friend->generate();
                    }
                }
            }

            foreach ($request->user()->friends as $friend) {
                if ($friend->accepted) {
                    if (!$friend->chat) {
                        $friend->generate();
                    }
                }
            }

            foreach ($chats = Chat::byUser($request->user()->id_user)->orderBy('updated_at', 'DESC')->with('from', 'to')->get() as $chat) {
                $chat->api();
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
         * * Log a User in a Chat.
         * @param  \Illuminate\Http\Request  $request
         * @param string $slug
         * @return \Illuminate\Http\Response
         */
        public function login (Request $request, string $slug) {
            if (!$request->user()) {
                return response()->json([
                    'code' => 403,
                    'message' => 'Unauthenticated',
                ]);
            }

            $user = User::bySlug($slug)->first();
            if (!$user) {
                return response()->json([
                    'code' => 404,
                    'message' => 'User does not exist',
                ]);
            }

            $chat = Chat::byUsers($request->user()->id_user, $user->id_user)->first();

            if (!$chat) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Chat does not exist',
                ]);
            }

            $chat->login();

            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'data' => [
                    'logged_at' => $chat->logged_at,
                ],
            ]);
        }

        /**
         * * Add a new Message.
         * @param  \Illuminate\Http\Request  $request
         * @param int $id_user
         * @return \Illuminate\Http\Response
         */
        public function send (Request $request, int $id_user) {
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

            $chat = Chat::byUsers($request->user()->id_user, $user->id_user)->first();

            if (!$chat) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Chat does not exist',
                ]);
            }

            $input = (object) $request->all();

            switch ($input->id_type) {
                case 1:
                    $validator = Validator::make((array) $input, Chat::$validation['send']['says']['rules'], Chat::$validation['send']['says']['messages']['es']);
                    if ($validator->fails()) {
                        return response()->json([
                            'code' => 401,
                            'message' => 'Validation error',
                            'data' => $validator->errors()->messages(),
                        ]);
                    }

                    $chat->send([
                        'id_user' => $request->user()->id_user,
                        'says' => $input->message,
                    ]);

                    new Mail([ 'id_mail' => 2, ], [
                        'email_to' => $chat->notAuth->email,
                        'message' => $input->message,
                        'name' => $chat->auth->name,
                        'slug' => $chat->notAuth->slug,
                        'username' => $chat->auth->username,
                    ]);
                    break;
                case 2:
                    $validator = Validator::make((array) $input, Chat::$validation['send']['abilities']['rules'], Chat::$validation['send']['abilities']['messages']['es']);
                    if ($validator->fails()) {
                        return response()->json([
                            'code' => 401,
                            'message' => 'Validation error',
                            'data' => $validator->errors()->messages(),
                        ]);
                    }

                    $chat->to->and(['games']);

                    $abilities = collect();

                    $found = false;

                    foreach ($chat->to->games->last()->abilities as $ability) {
                        if (isset($input->{"ability[$ability->slug]"})){
                            if ($input->{"ability[$ability->slug]"} == 'on') {
                                $abilities->push((object) [
                                    'id_ability' => $ability->id_ability,
                                ]);

                                $found = true;
                            }
                        }
                    }

                    if (!$found) {
                        foreach ($chat->to->games->last()->abilities as $ability) {
                            $abilities->push((object) [
                                'id_ability' => $ability->id_ability,
                            ]);
                        }
                    }

                    $chat->send([
                        'abilities' => $abilities,
                        'id_user' => $request->user()->id_user,
                    ]);
                    break;
            }

            foreach ($chat->messages as $message) {
                $message->api();
            }

            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'data' => [
                    'messages' => $chat->messages,
                ],
            ]);
        }
    }