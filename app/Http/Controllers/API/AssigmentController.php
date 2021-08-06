<?php
    namespace App\Http\Controllers\API;

    use App\Http\Controllers\Controller;
    use App\Models\Ability;
    use App\Models\Assigment;
    use App\Models\Chat;
    use App\Models\Lesson;
    use App\Models\Mail;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class AssigmentController extends Controller {
        public function make (Request $request, int $id_chat) {
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

            $assigments = Assigment::allFromLesson(Lesson::findByUsers($chat->id_user_from, $chat->id_user_to)->id_lesson);
            if (count($assigments) === 4) {
                return response()->json([
                    "code" => 403,
                    "message" => "There are not more Assigments to create.",
                ]);
            }

            $input = (object) $request->all();
            
            $abilities = collect();
            foreach ($input as $key => $id_ability) {
                if (preg_match("/abilities/", $key)) {
                    $abilities->push([
                        "id_ability" => intval($id_ability),
                    ]);
                }
            }
            $input->abilities = $abilities;

            $validator = Validator::make((array) $input, Assigment::$validation["make"]["rules"], Assigment::$validation["make"]["messages"]["es"]);
            if ($validator->fails()) {
                return response()->json([
                    "code" => 401,
                    "message" => "Validation error",
                    "data" => $validator->errors()->messages(),
                ]);
            }

            $lesson = Lesson::findByUsers($chat->id_user_from, $chat->id_user_to);

            $input->abilities = Ability::stringify($input->abilities->toArray());
            $input->id_lesson = $lesson->id_lesson;

            $assigment = Assigment::create((array) $input);

            $chat->addMessage([
                "id_user" => $request->user()->id_user,
                "id_assigment" => $assigment->id_assigment,
            ]);

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

            new Mail([ "id_mail" => 3, ], [
                'email_to' => $to->email,
                'name' => $from->name,
                'slug' => $from->slug,
                'username' => $from->username,
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