<?php
    namespace App\Http\Middleware;

    use App\Models\User;
    use Closure;
    use Illuminate\Http\Request;

    class CheckUserExist {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle (Request $request, Closure $next) {
            if (!is_null($request->route()->parameter('id_user'))) {
                $field = 'id_user';
                $value = $request->route()->parameter('id_user');
            }
            if (!is_null($request->route()->parameter('slug'))) {
                $field = 'slug';
                $value = $request->route()->parameter('slug');
            }
            if (!is_null($request->route()->parameter('user'))) {
                $field = 'slug';
                $value = $request->route()->parameter('user');
            }

            if (!User::where($field, "=", $value)->first()) {
                return redirect()->back()->with('status', [
                    'code' => 404,
                    'message' => "User \"$value\" does not exist",
                ]);
            }

            return $next($request);
        }
    }