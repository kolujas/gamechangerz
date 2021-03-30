<?php
    namespace App\Http\Controllers;

    use App\Models\Auth as Model;
    use App\Models\User;
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
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if(!Auth::attempt(['password' => $input->password, 'email' => $input->data], isset($input->remember))){
                if(!Auth::attempt(['password' => $input->password, 'username' => $input->data], isset($input->remember))){
                    return redirect()->back()->withInput()->with('status', [
                        'code' => 401,
                        'message' => 'Correo, nombre de usuario, y/o contraseña incorrectos.',
                    ]);
                }
            }

            $user = Auth::user();
            return redirect("/user/$user->slug/profile");
        }

        /**
         * * Sign the User in the website.
         * @param Request $request
         * @return [type]
         */
        public function signin (Request $request) {
            $input = (object) $request->all();

            $validator = Validator::make($request->all(), Model::$validation['signin']['rules'], Model::$validation['signin']['messages']['es']);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $input->slug = SlugService::createSlug(User::class, 'slug', $input->username);
            $user = User::create((array) $input);
            $user->update(['folder' => "user/$user->id_user"]);

            return redirect("/user/$user->slug/profile");
        }

        /**
         * * Log the User out the website.
         * @return [type]
         */
        public function logout () {
            Auth::logout();
            return redirect('/')->with('status', [
                'code' => 200,
                'message' => 'Sesión Cerrada.',
            ]);
        }
    }