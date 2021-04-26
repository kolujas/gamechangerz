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
            $name = (!is_null($request->route()->parameter('id_user')) ? $request->route()->parameter('id_user') : $request->route()->parameter('slug'));
            if ((!is_null($request->route()->parameter('id_user')) ? !User::find($name) : !User::where('slug', '=', $name)->get()[0])) {
                $request->session()->put('error', [
                    'code' => 404,
                    'message' => "User \"$name\" does not exist",
                ]);
                return redirect()->back();
            }
            return $next($request);
        }
    }