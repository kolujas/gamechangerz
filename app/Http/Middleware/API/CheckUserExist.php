<?php
    namespace App\Http\Middleware\API;

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
            $name = (!is_null($request->route()->parameter('id_user')) ? $request->route()->parameter('id_user') : $request->route()->parameter('slug'));
            if ((!is_null($request->route()->parameter('id_user')) ? !User::find($name) : !count(User::where('slug', '=', $name)->get()))) {
                return response()->json([
                    'code' => 404,
                    'message' => "User \"$name\" does not exist",
                ]);
            }
            return $next($request);
        }
    }