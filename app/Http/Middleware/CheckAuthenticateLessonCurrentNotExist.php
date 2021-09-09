<?php
    namespace App\Http\Middleware;

    use App\Models\User;
    use Auth;
    use Carbon\Carbon;
    use Closure;

    class CheckAuthenticateLessonCurrentNotExist {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle ($request, Closure $next) {
            if ($request->route()->parameter("type") === "seguimiento-online") {
                $user = User::findBySlug($request->route()->parameter('slug'));
                $user->and(["lessons"]);
    
                foreach ($user->lessons as $lesson) {
                    if ($lesson->id_type === 2 && $lesson->id_status === 3 && $lesson->id_user_to === Auth::user()->id_user) {
                        $lesson->and(["started_at"]);
                        $now = Carbon::now();
                        if ($now > $lesson->started_at && $now < $lesson->ended_at) {
                            $request->session()->put('error', [
                                'code' => 403,
                                'message' => "Tienes una clase seguimiento online de $user->username en curso",
                            ]);
            
                            return redirect()->back();
                        }
                    }
                }
            }

            return $next($request);
        }
    }
