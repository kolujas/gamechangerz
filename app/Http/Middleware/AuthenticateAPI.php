<?php
    namespace App\Http\Middleware;

    use Auth;
    use Closure;

    class AuthenticateAPI {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle ($request, Closure $next) {
            $token = $request->header('X-CSRF-TOKEN');
            if (!$token) {
                return response()->json([
                    'code' => 403,
                    'message' => 'Perro',
                ]);
            }
            return $next($request);
        }
    }