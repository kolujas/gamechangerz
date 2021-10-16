<?php
    namespace App\Http\Middleware;

    use App\Models\Lesson;
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
                $lessons = collect();
                dd(Lesson::allStartedFromUser(Auth::user()->id_user));
                foreach (Lesson::allStartedFromUser(Auth::user()->id_user) as $lesson) {
                    $lesson->and(['reviews']);

                    if (count($lesson->reviews)) {
                        foreach ($lesson->reviews as $review) {
                            if ($review->id_user_from === Auth::user()->id_user) {
                                continue 2;
                            }
                        }
                    }

                    $lesson->and(['ended_at']);

                    if (Carbon::now() > $lesson->ended_at) {
                        $lessons->push($lesson);
                    }
                }

                $request->session()->put('lessons', $lessons);
            }

            return $next($request);
        }
    }