<?php
    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Support\Facades\DB;

    class CheckTokenExist {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle($request, Closure $next) {
            $field = $request->route()->parameter('token');

            if (!DB::table('password_resets')->where('token', $field)->first()) {
                return redirect('/')->with('status', [
                    'code' => 403,
                    'message' => 'Algo salió mal',
                ]);
            }

            return $next($request);
        }
    }