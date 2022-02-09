<?php
    namespace App\Http\Middleware;

    use App\Models\Lesson;
    use Closure;
    use Illuminate\Http\Request;

    class CheckLessonTypeExist {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle (Request $request, Closure $next) {
            $slug = $request->route()->parameter('type');

            if (!Lesson::has($slug)) {
                return redirect()->back()->with('status', [
                    'code' => 404,
                    'message' => "Lesson \"$slug\" type does not exist",
                ]);
            }
            
            return $next($request);
        }
    }