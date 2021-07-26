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
            if (!is_null($request->route()->parameter('id_user'))) {
                $field = $request->route()->parameter('id_user');
            }
            if (!is_null($request->route()->parameter('slug'))) {
                $field = $request->route()->parameter('slug');
            }
            if (!is_null($request->route()->parameter('user'))) {
                $field = $request->route()->parameter('user');
            }
            
            if ((!is_null($request->route()->parameter('id_user')) ? intval($field) !== $request->user()->id_user : $field !== $request->user()->slug)) {
                if ($request->user()->id_role !== 2) {
                    $request->session()->put('error', [
                        'code' => 403,
                        'message' => "You are not this User",
                    ]);
    
                    return redirect()->back();
                }
            }
            
            return $next($request);
        }
    }