<?php
    namespace App\Http\Middleware\API;

    use Auth;
    use Closure;

    class Authenticate {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle ($request, Closure $next) {
            if (!$request->user()) {
                return response()->json([
                    'code' => 403,
                    'message' => 'Unaunthenticated',
                ]);
            }

            return $next($request);
        }
    }