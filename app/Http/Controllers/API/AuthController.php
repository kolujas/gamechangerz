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
            $input = (object) $request->all();

            $validator = Validator::make($request->all(), Model::$validation['login']['rules'], Model::$validation['login']['messages']['es']);
            if ($validator->fails()) {
                return response()->json([
                    'code' => 401,
                    'message' => 'Validation error',
                    'data' => [
                        'errors' => $validator->errors()->messages()
                    ],
                ]);
            }

            if (!Auth::attempt(['password' => $input->login_password, 'email' => $input->login_data], isset($input->login_remember))) {
                if (!Auth::attempt(['password' => $input->login_password, 'username' => $input->login_data], isset($input->login_remember))) {
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
    }