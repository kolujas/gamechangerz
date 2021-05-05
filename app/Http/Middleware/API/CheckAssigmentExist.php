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
            $slug = $request->route()->parameter('slug');
            if (!count(Assigment::where('slug', '=', $slug)->get())) {
                return response()->json([
                    'code' => 404,
                    'message' => "Assigment \"$slug\" does not exist",
                ]);
            }
            return $next($request);
        }
    }