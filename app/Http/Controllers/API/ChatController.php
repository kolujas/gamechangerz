<?php
    namespace App\Http\Controllers\API;

    use App\Http\Controllers\Controller;
    use App\Models\Chat;
    use App\Models\Friend;
    use App\Models\Lesson;
    use App\Models\User;
    use Auth;
    use Carbon\Carbon;
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

            $lessons = collect();
            foreach (Lesson::where([
                ['id_user_from', '=', $request->user()->id_user],
                ['status', '>', 0],
            ])->get() as $lesson) {
                $lessons->push($lesson);
            }

            foreach (Lesson::where([
                ['id_user_to', '=', $request->user()->id_user],
                ['status', '>', 0],
            ])->get() as $lesson) {
                $lessons->push($lesson);
            }

            foreach ($lessons as $lesson) {
                if ($lesson->status === 2) {
                    if (!Chat::exist($request->user()->id_user, ($request->user()->id_user === $lesson->id_user_from ? $lesson->id_user_to : $lesson->id_user_from))) {
                        Chat::create([
                            'id_chat' => null,
                            'id_user_from' => $lesson->id_user_from,
                            'id_user_to' => $lesson->id_user_to,
                            'messages' => "[]",
                        ]);
                    }
                }
            }

            $friends = collect();
            foreach (Friend::where('id_user_from', '=', $request->user()->id_user)->get() as $friend) {
                $friends->push($friend);
            }

            foreach (Friend::where('id_user_to', '=', $request->user()->id_user)->get() as $friend) {
                $friends->push($friend);
            }

            if ($request->user()->id_role === 0) {
                foreach ($friends as $friend) {
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

            if ($request->user()->id_role === 2) {
                foreach (User::where('id_role', '=', 2)->get() as $user) {
                    if ($user->id_user !== $request->user()->id_user) {
                        if (!Chat::exist($request->user()->id_user, $user->id_user)) {
                            Chat::create([
                                'id_chat' => null,
                                'id_user_from' => $request->user()->id_user,
                                'id_user_to' => $user->id_user,
                                'messages' => "[]",
                            ]);
                        }
                    }
                }
            }

            $chats = collect();
            foreach (Chat::where('id_user_from', '=', $request->user()->id_user)->orderBy('updated_at', 'DESC')->get() as $chat) {
                $chats->push($chat);
            }

            foreach (Chat::where('id_user_to', '=', $request->user()->id_user)->orderBy('updated_at', 'DESC')->get() as $chat) {
                $chats->push($chat);
            }

            foreach ($chats as $chat) {
                $chat->id_user_logged = $request->user()->id_user;
                $chat->and(['users', 'available', 'type']);
                if ($chat->users['from']->id_role === 1) {
                    $chat->and(['end_at']);
                }
                foreach ($chat->users as $user) {
                    $user->and(['files', 'games']);
                    foreach ($user->games as $games) {
                        $games->and(['abilities']);
                    }
                }

                foreach ($chat->messages as $message) {
                    $message->id_user_logged = $request->user()->id_user;
                }
            }

            $sorted = collect();
            foreach ($chats->sortByDesc('updated_at') as $chat) {
                $sorted->push($chat);
            };

            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'data' => [
                    'chats' => $sorted,
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

            $chats = collect();
            foreach (Chat::where('id_user_from', '=', $request->user()->id_user)->get() as $chat) {
                $chats->push($chat);
            }

            foreach (Chat::where('id_user_to', '=', $request->user()->id_user)->get() as $chat) {
                $chats->push($chat);
            }
            
            $found = false;
            foreach ($chats as $chat) {
                if ($chat->id_user_from === $request->user()->id_user) {
                    if ($chat->id_user_to === intval($id_user)) {
                        $found = true;
                        break;
                    }
                }
                if ($chat->id_user_to === $request->user()->id_user) {
                    if ($chat->id_user_from === intval($id_user)) {
                        $found = true;
                        break;
                    }
                }
            }

            if (!$found) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Chat does not exist',
                ]);
            }

            $chat->and(['users', 'available', 'type', 'messages']);
            foreach ($chat->messages as $message) {
                $message->id_user_logged = $request->user()->id_user;
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
            $request->user()->and(['chats']);

            $user = User::find($id_user);
            if (!$user) {
                return response()->json([
                    'code' => 404,
                    'message' => 'User does not exist',
                ]);
            }

            $input = (object) $request->all();

            $validator = Validator::make((array) $input, Chat::$validation['send']['rules'], Chat::$validation['send']['messages']['es']);
            if ($validator->fails()) {
                return response()->json([
                    'code' => 401,
                    'message' => 'Validation error',
                    'data' => $validator->errors()->messages(),
                ]);
            }

            $chats = collect();
            foreach (Chat::where('id_user_from', '=', $request->user()->id_user)->get() as $chat) {
                $chats->push($chat);
            }

            foreach (Chat::where('id_user_to', '=', $request->user()->id_user)->get() as $chat) {
                $chats->push($chat);
            }
            
            $found = false;
            foreach ($chats as $chat) {
                if ($chat->id_user_from === $request->user()->id_user) {
                    if ($chat->id_user_to === intval($id_user)) {
                        $found = true;
                        break;
                    }
                }
                if ($chat->id_user_to === $request->user()->id_user) {
                    if ($chat->id_user_from === intval($id_user)) {
                        $found = true;
                        break;
                    }
                }
            }

            if (!$found) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Chat does not exist',
                ]);
            }

            $messages = collect();
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
            $chat->and(['users', 'available', 'type']);
            foreach ($chat->users as $user) {
                $user->and(['files', 'games']);
                foreach ($user->games as $games) {
                    $games->and(['abilities']);
                }
            }

            foreach ($chat->messages as $message) {
                $message->id_user_logged = $request->user()->id_user;
            }

            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'data' => [
                    'chat' => $chat,
                ],
            ]);
        }
    }