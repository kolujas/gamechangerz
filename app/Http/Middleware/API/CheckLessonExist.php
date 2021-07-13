<?php
    namespace App\Http\Middleware\API;

    use App\Models\Lesson;
    use Closure;
    use Illuminate\Http\Request;

    class CheckLessonExist {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle (Request $request, Closure $next) {
            $id_lesson = $request->route()->parameter('id_lesson');

            if (!Lesson::find($id_lesson)) {
                return response()->json([
                    'code' => 404,
                    'message' => "Lesson \"$id_lesson\" does not exist",
                ]);
            }
            
            return $next($request);
        }
    }