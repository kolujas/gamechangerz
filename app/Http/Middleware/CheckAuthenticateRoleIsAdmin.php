<?php
    namespace App\Http\Middleware;

    use Closure;

    class CheckAuthenticateRoleIsAdmin {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle($request, Closure $next) {
            if ($request->user()->id_role !== 2) {
                $request->session()->put('error', [
                    'code' => 403,
                    'message' => "You must be an Admin to perform this action",
                ]);

                return redirect()->back();
            }
            
            return $next($request);
        }
    }