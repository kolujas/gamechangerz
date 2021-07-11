<?php
    namespace App\Http\Controllers;

    use App\Models\Auth as Model;
    use App\Models\User;
    use Auth;
    use Carbon\Carbon;
    use Cviebrock\EloquentSluggable\Services\SlugService;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Validator;

    class AuthController extends Controller {
        /**
         * * Confirm the User email.
         * @param string $token User personal access token.
         * @return [type]
         */
        public function confirm ($token) {
            if (!DB::table('password_resets')->where('token', $token)->first()) {
                return redirect('/')->with('status', [
                    'code' => 403,
                    'message' => 'Algo salió mal',
                ]);
            }

            $password = DB::table('password_resets')->where('token', $token)->first();
            $user = User::findByEmail($password->email);
            DB::table('password_resets')->where('token', $token)->delete();

            $user->update([
                'status' => 2,
            ]);

            Auth::attempt(['password' => $user->password, 'email' => $user->email], true);

            // if (config('app.env') === 'local') {
                return redirect("/users/$user->slug/profile");
            // }

            // $google = new Google();
            // return redirect($google->createAuthUrl());
        }

        /**
         * * Log the User in the website.
         * @param Request $request
         * @return [type]
         */
        public function login (Request $request) {
            foreach ($request->all() as $key => $value) {
                if (preg_match("/login_/", $key)) {
                    $string = "login_";
                }
                if (preg_match("/signin_/", $key)) {
                    $string = "signin_";
                }
            }

            $input = (object) $this->decodeInput($request->all(), $string);
            if ($string === "signin_") {
                $input->data = $input->email;
            }

            $validator = Validator::make((array) $input, Model::$validation['login']['rules'], Model::$validation['login']['messages']['es']);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if (!Auth::attempt(['password' => $input->password, 'email' => $input->data], isset($input->remember))) {
                if (!Auth::attempt(['password' => $input->password, 'username' => $input->data], isset($input->remember))) {
                    return redirect()->back()->withInput()->with('status', [
                        'code' => 401,
                        'message' => 'Correo, apodo, y/o contraseña incorrectos.',
                    ]);
                }
            }

            if (Auth::user()->status !== 2) {
                if (Auth::user()->status === 0) {
                    $status = [
                        'code' => 403,
                        'message' => 'Usuario baneado',
                    ];
                }
                if (Auth::user()->status === 1) {
                    $status = [
                        'code' => 403,
                        'message' => 'Correo pendiente de aprobación',
                    ];
                }

                foreach (Auth::user()->tokens as $token) {
                    $token->delete();
                }

                Auth::logout();

                return redirect('/')->with('status', $status);
            }

            $user = Auth::user();
            
            return redirect("/users/$user->slug/profile");
        }

        /**
         * * Log the User out the website.
         * @return [type]
         */
        public function logout () {
            foreach (Auth::user()->tokens as $token) {
                $token->delete();
            }

            Auth::logout();
            
            return redirect('/')->with('status', [
                'code' => 200,
                'message' => 'Sesión Cerrada.',
            ]);
        }
    }