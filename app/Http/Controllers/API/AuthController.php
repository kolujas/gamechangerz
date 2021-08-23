<?php
    namespace App\Http\Controllers\API;

    use App\Http\Controllers\Controller;
    use App\Models\Auth as Model;
    use App\Models\Discord;
    use App\Models\Mail;
    use App\Models\User;
    use Auth;
    use Carbon\Carbon;
    use Cviebrock\EloquentSluggable\Services\SlugService;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Str;

    class AuthController extends Controller {
        /**
         * * Log the User in the website.
         * @param Request $request
         * @return [type]
         */
        public function login (Request $request) {
            $input = (object) $this->decodeInput($request->all(), "login_");

            $validator = Validator::make((array) $input, Model::$validation["login"]["rules"], Model::$validation["login"]["messages"]["es"]);
            if ($validator->fails()) {
                return response()->json([
                    "code" => 401,
                    "message" => "Error de validación",
                    "data" => [
                        "errors" => $validator->errors()->messages()
                    ],
                ]);
            }

            if (!Auth::attempt(["password" => $input->password, "email" => $input->data], isset($input->remember))) {
                if (!Auth::attempt(["password" => $input->password, "username" => $input->data], isset($input->remember))) {
                    return response()->json([
                        "code" => 404,
                        "message" => "Correo, apodo, y/o contraseña incorrectos.",
                    ]);
                }
            }
            
            if (Auth::user()->id_status !== 2) {
                if (Auth::user()->id_status === 0) {
                    $status = [
                        "code" => 403,
                        "message" => "Usuario baneado",
                    ];
                }
                if (Auth::user()->id_status === 1) {
                    $status = [
                        "code" => 403,
                        "message" => "Correo pendiente de aprobación",
                    ];
                }

                foreach (Auth::user()->tokens as $token) {
                    $token->delete();
                }

                Auth::logout();
            
                return response()->json($status);
            }
            if (Auth::user()->id_status === 2) {
                $user = Auth::user();
                $token = $user->createToken("Personal Access Token")->accessToken;

                $status = [
                    "code" => 200,
                    "message" => "Success",
                    "data" => [
                        "token" => $token,
                    ],
                ];
            }
            
            return response()->json($status);
        }

        /**
         * * Sign the User in the website.
         * @param Request $request
         * @return [type]
         */
        public function signin (Request $request) {
            $input = (object) $this->decodeInput($request->all(), "signin_");

            $validator = Validator::make((array) $input, Model::$validation["signin"]["rules"], Model::$validation["signin"]["messages"]["es"]);
            if ($validator->fails()) {
                return response()->json([
                    "code" => 401,
                    "message" => "Error de validación",
                    "data" => [
                        "errors" => $validator->errors()->messages(),
                    ],
                ]);
            }

            $input->id_role = 0;
            $input->slug = SlugService::createSlug(User::class, "slug", $input->username);
            $input->languages = json_encode([[
                "id_language" => $input->language,
            ]]);
            $password = $input->password;
            $input->password = Hash::make($password);
            $input->id_status = 1;

            DB::table("password_resets")->insert([
                "email" => $input->email,
                "token" => Str::random(60),
                "created_at" => Carbon::now(),
            ]);

            try {
                $user = User::create((array) $input);
                $user->update([
                    "folder" => "users/$user->id_user",
                ]);
                
                $mail = new Mail([ "id_mail" => 1, ], [
                    "email_to" => $input->email,
                    "token" => DB::table("password_resets")->where("email", $input->email)->first()->token,
                ]);
            } catch (\Throwable $th) {
                dd($th);
            }

            if (!Auth::attempt(["password" => $password, "email" => $input->email], isset($input->remember))) {
                return response()->json([
                    "code" => 404,
                    "message" => "Correo, apodo, y/o contraseña incorrectos.",
                ]);
            }

            $user = Auth::user();
            $token = $user->createToken("Personal Access Token")->accessToken;
            
            return response()->json([
                "code" => 200,
                "message" => "Success",
                "data" => [
                    "token" => $token,
                ],
            ]);
        }
    }