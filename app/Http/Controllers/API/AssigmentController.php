<?php
    namespace App\Http\Controllers\API;

    use App\Http\Controllers\Controller;
    use App\Models\Ability;
    use App\Models\Assigment;
    use App\Models\Chat;
    use App\Models\Lesson;
    use Cviebrock\EloquentSluggable\Services\SlugService;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class AssigmentController extends Controller {
        /**
         * * Get an specific Assigment.
         * @param Request $request
         * @param int $id_user
         * @return JSON
         */
        public function get (Request $request, $id_lesson, $slug) {
            // 
        }

        public function make (Request $request, $id_chat) {
            if (!$request->user()) {
                return response()->json([
                    'code' => 403,
                    'message' => 'Unauthenticated',
                ]);
            }

            $chat = Chat::find($id_chat);
            if (!$chat) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Chat does not exist',
                ]);
            }

            $input = (object) $request->all();
            $abilities = [];
            foreach ($input as $key => $value) {
                if (preg_match("/abilities/", $key)) {
                    $ability = explode("[", $key)[1];
                    $ability = explode("]", $ability)[0];
                    $abilities[$ability] = intval($ability);
                }
            }
            $input->abilities = $abilities;

            $validator = Validator::make((array) $input, Assigment::$validation['make']['rules'], Assigment::$validation['make']['messages']['es']);
            if ($validator->fails()) {
                return response()->json([
                    'code' => 401,
                    'message' => 'Validation error',
                    'data' => $validator->errors()->messages(),
                ]);
            }

            $lesson = Lesson::where([
                ['id_user_from', '=', $chat->id_user_from],
                ['id_user_to', '=', $chat->id_user_to],
            ])->orwhere([
                ['id_user_from', '=', $chat->id_user_to],
                ['id_user_to', '=', $chat->id_user_from],
            ])->get()[0];

            try {
                $input->abilities = Ability::stringify($input->abilities);
                $input->id_lesson = $lesson->id_lesson;
                $input->slug = SlugService::createSlug(Assigment::class, 'slug', $input->title);

                $assigment = Assigment::create((array) $input);
            } catch (\Throwable $th) {
                dd($th);
            }

            $input = (object)[];
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
                "id_assigment" => $assigment->id_assigment,
            ]);

            $input->messages = json_encode($messages);

            $chat->update((array) $input);

            $chat->id_user_logged = $request->user()->id_user;
            $chat->and(['users', 'available', 'type', 'messages']);
            foreach ($chat->users as $user) {
                $user->and(['files', 'games']);
                foreach ($user->games as $games) {
                    $games->and(['abilities']);
                }
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