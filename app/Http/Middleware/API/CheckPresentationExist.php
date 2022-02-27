<?php
    namespace App\Http\Middleware\API;

    use App\Models\Presentation;
    use Closure;
    use Illuminate\Http\Request;

    class CheckPresentationExist {
        /**
         * * Handle an incoming request.
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle (Request $request, Closure $next) {
            $field = (!is_null($request->route()->parameter('id_presentation')) ? 'id_presentation' : 'slug');
            $value = (!is_null($request->route()->parameter('id_presentation')) ? $request->route()->parameter('id_presentation') : $request->route()->parameter('slug'));

            if (!Presentation::where($field, $value)->first()) {
                return response()->json([
                    'code' => 404,
                    'message' => "Presentation \"$value\" does not exist",
                ]);
            }

            return $next($request);
        }
    }