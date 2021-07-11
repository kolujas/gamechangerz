<?php
    namespace App\Http\Middleware;

    use App\Models\User;
    use Closure;
    use Illuminate\Http\Request;

    class CheckUserIsTeacher {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle (Request $request, Closure $next) {
            $user = User::findBySlug($request->route()->parameter('slug'));

            if ($user->id_role !== 1) {
                $request->session()->put('error', [
                    'code' => 403,
                    'message' => "$user->username is not a teacher",
                ]);

                return redirect()->back();
            }
            
            return $next($request);
        }
    }
