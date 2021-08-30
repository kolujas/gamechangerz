<?php
    namespace App\Http\Middleware;

    use Closure;
    use App\Models\Lesson;

    class CheckLessonStatusIs1 {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle($request, Closure $next) {
            $lesson = Lesson::find($request->route()->parameter("id_lesson"));

            if ($lesson->id_status != 1) {
                $request->session()->put("error", [
                    "code" => 403,
                    "message" => "Lesson was paid",
                ]);
                
                return redirect("/");
            }

            return $next($request);
        }
    }