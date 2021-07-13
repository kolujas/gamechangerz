<?php
    namespace App\Http\Middleware;

    use Auth;
    use Carbon\Carbon;
    use Closure;

    class CheckAuthenticateLessonEnded {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle($request, Closure $next) {
            if (Auth::check()) {
                $user = Auth::user();
                $user->and(['lessons']);

                // foreach ($user->lessons as $lesson) {
                //     if ($lesson->status !== 3) {
                //         continue;
                //     }
                //     // TODO: No es updated_at es la clase
                //     $ended_at = Carbon::parse($lesson->updated_at);
                //     if ($ended_at < Carbon::now()) {
                //         return redirect("/lessons/$lesson->id_lesson/finish");
                //     }
                // }
            }
            return $next($request);
        }
    }