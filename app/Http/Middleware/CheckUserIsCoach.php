<?php
    namespace App\Http\Middleware;

    use App\Models\User;
    use Closure;
    use Illuminate\Http\Request;

    class CheckUserIsCoach {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle (Request $request, Closure $next) {
            $user = User::bySlug($request->route()->parameter('slug'))->first();

            if ($user->id_role !== 1) {
                $request->session()->put('error', [
                    'code' => 403,
                    'message' => "$user->username is not a coach",
                ]);

                return redirect()->back();
            }
            
            return $next($request);
        }
    }
