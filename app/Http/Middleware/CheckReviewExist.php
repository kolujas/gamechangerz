<?php
    namespace App\Http\Middleware;

    use App\Models\Review;
    use Closure;

    class CheckReviewExist {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle ($request, Closure $next) {
            $field = $request->route()->parameter('id_review');

            if (!Review::find($field)) {
                return redirect()->back()->with('status', [
                    'code' => 404,
                    'message' => "Review \"$field\" does not exist",
                ]);
            }
            
            return $next($request);
        }
    }
