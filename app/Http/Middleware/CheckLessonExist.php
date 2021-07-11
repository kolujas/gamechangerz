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
                $request->session()->put('error', [
                    'code' => 404,
                    'message' => "Lesson \"$field\" does not exist",
                ]);

                return redirect()->back();
            }
            
            return $next($request);
        }
    }
