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
            $field = (!is_null($request->route()->parameter('id_user')) ? $request->route()->parameter('id_user') : $request->route()->parameter('slug'));
            if ((!is_null($request->route()->parameter('id_user')) ? !User::find($field) : !count(User::where('slug', '=', $field)->get()))) {
                $request->session()->put('error', [
                    'code' => 404,
                    'message' => "User \"$field\" does not exist",
                ]);
                return redirect()->back();
            }
            return $next($request);
        }
    }