<?php
    namespace App\Http\Controllers\API;

    use App\Http\Controllers\Controller;
    use App\Models\Auth as Model;
    use App\Models\User;
    use Auth;
    use Carbon\Carbon;
    use Cviebrock\EloquentSluggable\Services\SlugService;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class AuthController extends Controller {
        /**
         * * Log the User in the website.
         * @param Request $request
         * @return [type]
         */
        public function login (Request $request) {
            $input = (object) $this->decodeInput($request->all(), 'login_');

            $validator = Validator::make((array) $input, Model::$validation['login']['rules'], Model::$validation['login']['messages']['es']);
            if ($validator->fails()) {
                return response()->json([
                    'code' => 401,
                    'message' => 'Validation error',
                    'data' => [
                        'errors' => $validator->errors()->messages()
                    ],
                ]);
            }

            if (!Auth::attempt(['password' => $input->password, 'email' => $input->data], isset($input->remember))) {
                if (!Auth::attempt(['password' => $input->password, 'username' => $input->data], isset($input->remember))) {
                    return response()->json([
                        'code' => 404,
                        'message' => 'Correo, nombre de usuario, y/o contraseña incorrectos.',
                    ]);
                }
            }

            $user = Auth::user();
            $token = $user->createToken('Personal Access Token')->accessToken;
            
            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'data' => [
                    'token' => $token,
                ],
            ]);
        }

        /**
         * * Sign the User in the website.
         * @param Request $request
         * @return [type]
         */
        public function signin (Request $request) {
            $input = (object) $this->decodeInput($request->all(), 'signin_');

            $validator = Validator::make((array) $input, Model::$validation['signin']['rules'], Model::$validation['signin']['messages']['es']);
            if ($validator->fails()) {
                return response()->json([
                    'code' => 401,
                    'message' => 'Validation error',
                    'data' => [
                        'errors' => $validator->errors()->messages(),
                    ],
                ]);
            }

            $input->id_role = 0;
            $input->slug = SlugService::createSlug(User::class, 'slug', $input->username);
            $input->languages = json_encode([[
                'id_language' => $input->language,
            ]]);

            try {
                $user = User::create((array) $input);
                $user->update([
                    'folder' => "users/$user->id_user",
                ]);
            } catch (\Throwable $th) {
                dd($th);
            }

            if (!Auth::attempt(['password' => $input->password, 'email' => $input->email], isset($input->remember))) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Correo, nombre de usuario, y/o contraseña incorrectos.',
                ]);
            }

            $user = Auth::user();
            $token = $user->createToken('Personal Access Token')->accessToken;
            
            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'data' => [
                    'token' => $token,
                ],
            ]);
        }
    }