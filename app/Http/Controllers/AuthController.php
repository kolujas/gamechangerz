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
         * * Sends to the User an email to change the password.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function changePassword (Request $request) {
            return redirect('/');
        }

        /**
         * * Load the "reset password" page.
         * @param  \Illuminate\Http\Request  $request
         * @param string $token
         * @return \Illuminate\Http\Response
         */
        public function showResetPassword (Request $request, $token) {
            if (Auth::check()) {
                return redirect('/');
            }
            
            if (!DB::table('password_resets')->where('token', $token)->first()) {
                abort(403);
            }

            $password = DB::table('password_resets')->where('token', $token)->first();

            return view('auth.reset-password',[
                'password' => $password,
            ]);
        }

        /**
         * * Reset the User password.
         * @param  string $token
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function doResetPassword (Request $request, $token) {
            $input = (object) $request->input();

            $request->validate(Model::$validation['reset-password']['rules'], Model::$validation['reset-password']['messages']['es']);

            if (!DB::table('password_resets')->where('token', $token)->first()) {
                abort(403);
            }

            $password = DB::table('password_resets')->where('token', $token)->first();

            $user = User::byEmail($password->data)->first();
            if (!$user) {
                $user = User::byUsername($password->data)->first();
                if (!$user) {
                    abort(403);
                }
            }

            DB::table('password_resets')->where('token', $token)->delete();

            $user->update([
                'password' => \Hash::make($input->password),
            ]);

            return redirect('/#login');
        }

        /**
         * * Confirm the User email.
         * @param string $token User personal access token.
         * @return \Illuminate\Http\Response
         */
        public function confirm ($token) {
            if (!DB::table('password_resets')->where('token', $token)->first()) {
                return redirect('/')->with('status', [
                    'code' => 403,
                    'message' => 'Algo salió mal',
                ]);
            }

            $password = DB::table('password_resets')->where('token', $token)->first();

            $user = User::byEmail($password->data)->first();
            if (!$user) {
                $user = User::byUsername($password->data)->first();
                if (!$user) {
                    return redirect('/');
                }
            }

            DB::table('password_resets')->where('token', $token)->delete();

            $user->update([
                'id_status' => 2,
            ]);

            Auth::login($user);

            return redirect("/users/$user->slug/profile");
        }

        /**
         * * Log the User in the website.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function login (Request $request) {
            $input = (object) $request->all();
            
            if (isset($input->email)) {
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

            if (Auth::user()->id_status != 2) {
                if (Auth::user()->id_status == 0) {
                    $status = [
                        'code' => 403,
                        'message' => 'Usuario baneado',
                    ];
                }
                if (Auth::user()->id_status == 1) {
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
         * @return \Illuminate\Http\Response
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