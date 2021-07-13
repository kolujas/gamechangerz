<?php
    namespace App\Http\Middleware;

    use App\Models\User;
    use Closure;

    class CheckAuthenticateIsUser {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle ($request, Closure $next) {
            $field = (!is_null($request->route()->parameter('id_user')) ? $request->route()->parameter('id_user') : $request->route()->parameter('slug'));
            
            if ((!is_null($request->route()->parameter('id_user')) ? intval($field) !== $request->user()->id_user : $field !== $request->user()->slug)) {
                $request->session()->put('error', [
                    'code' => 403,
                    'message' => "You are not this User",
                ]);

                return redirect()->back();
            }
            
            return $next($request);
        }
    }