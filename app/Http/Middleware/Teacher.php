<?php
    namespace App\Http\Middleware;

    use App\Models\User;
    use Closure;
    use Illuminate\Http\Request;

    class Teacher {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle (Request $request, Closure $next) {
            $user = User::where('slug', '=', $request->route()->parameter('slug'))->get();
            if ($user->id_user !== 1) {
                $request->session()->put('error', [
                    'code' => 403,
                    'message' => "$user->username is not a teacher",
                ]);
                return redirect()->back();
            }
            return $next($request);
        }
    }
