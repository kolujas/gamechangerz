<?php
    namespace App\Http\Middleware\API;

    use App\Models\Assignment;
    use Closure;
    use Illuminate\Http\Request;

    class CheckAssignmentExist {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle (Request $request, Closure $next) {
            $field = (!is_null($request->route()->parameter('id_assignment')) ? 'id_assignment' : 'slug');
            $value = (!is_null($request->route()->parameter('id_assignment')) ? $request->route()->parameter('id_assignment') : $request->route()->parameter('slug'));

            if (!Assignment::where($field, '=', $value)->first()) {
                return response()->json([
                    'code' => 404,
                    'message' => "Assignment \"$value\" does not exist",
                ]);
            }

            return $next($request);
        }
    }