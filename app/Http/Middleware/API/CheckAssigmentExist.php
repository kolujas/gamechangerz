<?php
    namespace App\Http\Middleware\API;

    use App\Models\Assigment;
    use Closure;
    use Illuminate\Http\Request;

    class CheckAssigmentExist {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle (Request $request, Closure $next) {
            $field = (!is_null($request->route()->parameter('id_assigment')) ? 'id_assigment' : 'slug');
            $value = (!is_null($request->route()->parameter('id_assigment')) ? $request->route()->parameter('id_assigment') : $request->route()->parameter('slug'));

            if (!Assigment::where($field, '=', $value)->first()) {
                return response()->json([
                    'code' => 404,
                    'message' => "Assigment \"$value\" does not exist",
                ]);
            }

            return $next($request);
        }
    }