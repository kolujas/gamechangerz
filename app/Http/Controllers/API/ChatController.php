<?php
    namespace App\Http\Controllers\API;

    use App\Models\Chat;
    use App\Models\User;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    class ChatController extends Controller {
        public function all (Request $request) {
            if (!$request->user()) {
                return response()->json([
                    'code' => 403,
                    'message' => 'Unauthenticated',
                ]);
            }

            $chats = Chat::where([
                ['id_user_from', '=', $request->user()->id_user],
                ['id_user_to', '=', $request->user()->id_user]
                ])->get();

            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'data' => [
                    'chats' => $chats,
                ],
            ]);
        }

        public function get (Request $request, $id_user) {
            if (!$request->user()) {
                return response()->json([
                    'code' => 403,
                    'message' => 'Unauthenticated',
                ]);
            }

            $user_to = User::find($id_user);

            if (!$user) {
                return response()->json([
                    'code' => 404,
                    'message' => 'User does not exist',
                ]);
            }

            $chat = Chat::find($id_chat);

            if (!$chat) {
                $chat = Chat::create([
                    'id_user_from' => $request->user()->id_user,
                    'id_user_to' => $user_to->id_user,
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

            $user_to = User::find($id_user);

            if (!$user) {
                return response()->json([
                    'code' => 404,
                    'message' => 'User does not exist',
                ]);
            }

            $validator = Validator::make($request->all(), Chat::$validation['send']['rules'], Chat::$validation['send']['messages']['es']);
            if ($validator->fails()) {
                return response()->json([
                    'code' => 401,
                    'message' => 'Validation error',
                    'data' => $validator
                ]);
            }

            $chat = Chat::where(['id_user_from', '=', $request->user()->id_user], ['id_user_to', '=', $user_to->id_user])->get();
            $messages = [];
            foreach (json_decode($chat->messages) as $message) {
                # code...
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