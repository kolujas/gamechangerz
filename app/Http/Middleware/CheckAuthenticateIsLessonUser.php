<?php
    namespace App\Http\Middleware;

    use App\Models\Lesson;
    use Closure;

    class CheckAuthenticateIsLessonUser {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle($request, Closure $next) {
            $id_lesson = $request->route()->parameter('id_lesson');
            $lesson = Lesson::one($slug);
            if ($lesson->id_user_to !== $request->user()->id_user) {
                $request->session()->put('error', [
                    'code' => 403,
                    'message' => "You are not owner of this Lesson",
                ]);
                return redirect()->back();
            }
            return $next($request);
        }
    }
