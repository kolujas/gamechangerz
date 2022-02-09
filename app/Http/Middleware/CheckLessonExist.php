<?php
    namespace App\Http\Middleware;

    use App\Models\Lesson;
    use Closure;

    class CheckLessonExist {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle ($request, Closure $next) {
            $field = $request->route()->parameter('id_lesson');

            if (!Lesson::find($field)) {
                return redirect()->back()->with('status', [
                    'code' => 404,
                    'message' => "Lesson \"$field\" does not exist",
                ]);
            }
            
            return $next($request);
        }
    }
