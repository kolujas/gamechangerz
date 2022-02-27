<?php
    namespace App\Http\Controllers\API;

    use App\Http\Controllers\Controller;
    use App\Models\Assignment;
    use App\Models\Chat;
    use App\Models\Lesson;
    use App\Models\Mail;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class AssignmentController extends Controller {
        /**
         * * Get an specific Assignment.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function get (Request $request, int $id_assignment) {
            if (!$request->user()) {
                return response()->json([
                    'code' => 403,
                    'message' => 'Unauthenticated',
                ]);
            }

            $assignment = Assignment::with(['presentation'])->find($id_assignment);

            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'data' => [
                    'assignment' => $assignment,
                ],
            ]);
        }

        /**
         * * Make a new Assignment.
         * @param  \Illuminate\Http\Request $request
         * @param  string $slug
         * @return \Illuminate\Http\Response 
         */
        public function make (Request $request, string $slug) {
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

            if (!$chat->available) {
                return response()->json([
                    'code' => 403,
                    'message' => 'The chat is not available',
                ]);
            }

            $chat->lessons->last()->and(['assignments']);
            if (count($chat->lessons->last()->assignments) == $chat->lessons->last()->{'quantity-of-assignments'}) {
                return response()->json([
                    'code' => 403,
                    'message' => 'There are not more Assignments to create.',
                ]);
            }

            $input = (object) $request->all();
            
            $input->id_lesson = $chat->lessons->last()->id_lesson;

            $validator = Validator::make((array) $input, Assignment::$validation['make']['rules'], Assignment::$validation['make']['messages']['es']);
            if ($validator->fails()) {
                return response()->json([
                    'code' => 401,
                    'message' => 'Validation error',
                    'data' => $validator->errors()->messages(),
                ]);
            }

            $assignment = Assignment::create((array) $input);

            $chat->send([
                'id_assignment' => $assignment->id_assignment,
                'id_lesson' => $chat->lessons->last()->id_lesson,
                'id_user' => $request->user()->id_user,
            ]);

            new Mail([ 'id_mail' => 3, ], [
                'email_to' => $chat->notAuth->email,
                'slug' => $chat->auth->slug,
                'username' => $chat->auth->username,
            ]);

            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'data' => [
                    'assignment' => $assignment,
                ],
            ]);
        }
    }