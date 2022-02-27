<?php
    namespace App\Http\Controllers\API;

    use App\Http\Controllers\Controller;
    use App\Models\Chat;
    use App\Models\Assignment;
    use App\Models\Mail;
    use App\Models\User;
    use App\Models\Presentation;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class PresentationController extends Controller {
        /**
         * * Get an specific Presentation.
         * @param  \Illuminate\Http\Request  $request
         * @param  int $id_presentation
         * @return \Illuminate\Http\Response
         */
        public function get (Request $request, int $id_presentation) {
            if (!$request->user()) {
                return response()->json([
                    'code' => 403,
                    'message' => 'Unauthenticated',
                ]);
            }

            $presentation = Presentation::find($id_presentation);

            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'data' => [
                    'presentation' => $presentation,
                ],
            ]);
        }

        /**
         * * Make a new Presentation.
         * @param  \Illuminate\Http\Request $request
         * @param  string $slug
         * @param  int $id_assignment
         * @return \Illuminate\Http\Response 
         */
        public function make (Request $request, string $slug, int $id_assignment) {
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

            $assignment = Assignment::find($id_assignment);
            if (!$assignment) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Assignment does not exist',
                ]);
            }

            $input = (object) $request->all();

            $input->id_assignment = $assignment->id_assignment;

            $validator = Validator::make((array) $input, Presentation::$validation['make']['rules'], Presentation::$validation['make']['messages']['es']);
            if ($validator->fails()) {
                return response()->json([
                    'code' => 401,
                    'message' => 'Validation error',
                    'data' => $validator->errors()->messages(),
                ]);
            }

            if ($assignment->presentation) {
                return response()->json([
                    'code' => 403,
                    'message' => 'The Assignment contains a Presentation',
                ]);
            }

            $presentation = Presentation::create((array) $input);

            new Mail([ 'id_mail' => 4, ], [
                'email_to' => $chat->notAuth->email,
                'slug' => $chat->auth->slug,
            ]);

            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'data' => [
                    'presentation' => $presentation,
                ],
            ]);
        }
    }