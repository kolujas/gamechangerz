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
            foreach (Lesson::allReadyFromUser($request->user()->id_user) as $lesson) {
                // TODO: Remove in production
                $date = Carbon::now()->format("Y-m-d");
                if ($lesson->id_lesson === 3 || $lesson->id_lesson === 6 || $lesson->id_lesson === 9) {
                    $lesson->update([
                        "days" => json_encode([
                            ["date" => $date]
                        ]),
                        "id_status" => 3,
                    ]);
                }
                if ($lesson->id_type === 2) {
                    $lessons->push($lesson);
                }
            }

            foreach ($lessons as $lesson) {
                $lesson->and(['ended_at', 'started_at']);
                if ($lesson->id_status === 3 && $lesson->id_type === 2) {
                    $now = Carbon::now();
                    if ($now > $lesson->started_at && $now < $lesson->ended_at) {
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
            }

            $friends = collect();
            foreach (Friend::allFromUser($request->user()->id_user) as $friend) {
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
                foreach (User::allAdmins() as $user) {
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
            foreach (Chat::allFromUser($request->user()->id_user) as $chat) {
                $chats->push($chat);
            }

            foreach ($chats as $chat) {
                $chat->id_user_logged = $request->user()->id_user;
                $chat->and(['users', 'available', 'messages']);
                
                if ($chat->users->from->id_role === 1) {
                    $chat->and(['assigments']);
                }

                foreach ($chat->messages as $message) {
                    $message->id_user_logged = $request->user()->id_user;
                    $message->id_role = $request->user()->id_role;
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
            foreach (Chat::allFromUser($request->user()->id_user) as $chat) {
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

            $chat->and(['users', 'available', 'messages']);

            if ($chat->users->from->id_role === 1) {
                $chat->and(['lesson']);
            }

            foreach ($chat->messages as $message) {
                $message->id_user_logged = $request->user()->id_user;
                $message->id_role = $request->user()->id_role;
            }

            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'data' => [
                    'chat' => $chat,
                ],
            ]);
        }

        /**
         * * Add a new Message.
         * @param Request $request
         * @param string $id_user
         * @return JSON
         */
        public function send (Request $request, string $id_user) {
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

            $validator = Validator::make((array) $input, Chat::$validation['send']['rules'], Chat::$validation['send']['messages']['es']);
            if ($validator->fails()) {
                return response()->json([
                    'code' => 401,
                    'message' => 'Validation error',
                    'data' => $validator->errors()->messages(),
                ]);
            }

            $chat = Chat::findByUsers($request->user()->id_user, $id_user);

            if (!$chat) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Chat does not exist',
                ]);
            }

            $chat->addMessage([
                "id_user" => $request->user()->id_user,
                "says" => $input->message,
            ]);

            $chat->id_user_logged = $request->user()->id_user;
            $chat->and(['users', 'available', 'messages']);

            if ($chat->users->from->id_role === 1) {
                $chat->and(['lesson']);
            }

            foreach ($chat->messages as $message) {
                $message->id_user_logged = $request->user()->id_user;
                $message->id_role = $request->user()->id_role;
            }

            if ($request->user()->id_user === $chat->id_user_from) {
                $from = $chat->users->from;
                $to = $chat->users->to;
            }
            if ($request->user()->id_user !== $chat->id_user_from) {
                $from = $chat->users->to;
                $to = $chat->users->from;
            }

            new Mail([ "id_mail" => 2, ], [
                'email_to' => $to->email,
                'message' => $input->message,
                'name' => $from->name,
                'slug' => $to->slug,
                'username' => $from->username,
            ]);

            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'data' => [
                    'chat' => $chat,
                ],
            ]);
        }
    }