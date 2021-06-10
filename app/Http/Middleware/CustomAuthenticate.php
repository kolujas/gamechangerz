<?php
    namespace App\Http\Middleware;

    use Auth;
    use Closure;

    class CustomAuthenticate {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle ($request, Closure $next) {
            if (!Auth::check()) {
                $request->session()->put('error', [
                    'code' => 403,
                    'message' => "Debes estar logueado para realizar esta acción",
                ]);
                return redirect()->to(url()->previous() . '#login');
            }
            return $next($request);
        }
    }
