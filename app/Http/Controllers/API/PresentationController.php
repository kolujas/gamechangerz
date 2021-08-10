<?php
    namespace App\Http\Controllers\API;

    use App\Http\Controllers\Controller;
    use App\Models\Ability;
    use App\Models\Assigment;
    use App\Models\Chat;
    use App\Models\Lesson;
    use App\Models\Mail;
    use App\Models\Presentation;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class PresentationController extends Controller {
        public function make (Request $request, int $id_chat, int $id_assigment) {
            if (!$request->user()) {
                return response()->json([
                    "code" => 403,
                    "message" => "Unauthenticated",
                ]);
            }

            $chat = Chat::find($id_chat);
            if (!$chat) {
                return response()->json([
                    "code" => 404,
                    "message" => "Chat does not exist",
                ]);
            }

            $assigment = Assigment::find($id_assigment);
            if (!$assigment) {
                return response()->json([
                    "code" => 404,
                    "message" => "Assigment does not exist",
                ]);
            }

            $input = (object) $request->all();

            $validator = Validator::make((array) $input, Presentation::$validation["make"]["rules"], Presentation::$validation["make"]["messages"]["es"]);
            if ($validator->fails()) {
                return response()->json([
                    "code" => 401,
                    "message" => "Validation error",
                    "data" => $validator->errors()->messages(),
                ]);
            }

            $input->id_assigment = $assigment->id_assigment;

            $presentation = Presentation::create((array) $input);

            $chat->id_user_logged = $request->user()->id_user;
            $chat->and(["users", "available", "messages"]);

            foreach ($chat->messages as $message) {
                $message->id_user_logged = $request->user()->id_user;
            }

            if ($request->user()->id_user === $chat->id_user_from) {
                $from = $chat->users->from;
                $to = $chat->users->to;
            }
            if ($request->user()->id_user !== $chat->id_user_from) {
                $from = $chat->users->to;
                $to = $chat->users->from;
            }

            new Mail([ "id_mail" => 4, ], [
                "email_to" => $to->email,
                "slug" => $from->slug,
            ]);

            return response()->json([
                "code" => 200,
                "message" => "Success",
                "data" => [
                    "chat" => $chat,
                ],
            ]);
        }
    }