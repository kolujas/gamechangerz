<?php
    namespace App\Http\Middleware;

    use Closure;

    class CheckAuthenticateRoleIsUser {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle ($request, Closure $next) {
            if ($request->user()->id_role !== 0) {
                return redirect()->back()->with('status', [
                    'code' => 403,
                    'message' => "Debes ser un usuario para realizar esta acción",
                ]);
            }

            return $next($request);
        }
    }