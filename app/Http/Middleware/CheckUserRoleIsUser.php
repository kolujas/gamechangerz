<?php
    namespace App\Http\Middleware;

    use Auth;
    use Closure;

    class CheckUserRoleIsUser {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle ($request, Closure $next) {
            if (Auth::user()->id_role !== 0) {
                $request->session()->put('error', [
                    'code' => 403,
                    'message' => "Debes ser un usuario para realizar esta acción",
                ]);
                return redirect()->back();
            }
            return $next($request);
        }
    }