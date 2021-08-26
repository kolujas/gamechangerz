<?php
    namespace App\Http\Middleware;

    use Auth;
    use Closure;

    class CheckAuthenticateStatus {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle ($request, Closure $next) {
            if (Auth::check() && Auth::user()->id_status <= 0) {
                Auth::logout();
            }

            return $next($request);
        }
    }