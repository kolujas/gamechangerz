<?php
    namespace App\Http\Middleware;

    use App\Models\User;
    use Closure;

    class CheckUserStatus {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle ($request, Closure $next) {
            $field = (!is_null($request->route()->parameter('id_user')) ? $request->route()->parameter('id_user') : $request->route()->parameter('slug'));
            $user = (!is_null($request->route()->parameter('id_user')) ? User::find($field) : User::where('slug', '=', $field)->first());
            if ($user->status !== 2) {
                if ($user->status === 0) {
                    $request->session()->put('error', [
                        'code' => 403,
                        'message' => "Usuario \"$field\" baneado",
                    ]);
                }
                if ($user->status === 1) {
                    $request->session()->put('error', [
                        'code' => 403,
                        'message' => "Correo pendiente de aprobación",
                    ]);
                }
                return redirect()->back();
            }
            return $next($request);
        }
    }
