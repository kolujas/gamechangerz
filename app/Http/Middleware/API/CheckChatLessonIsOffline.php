<?php
    namespace App\Http\Middleware\API;

    use App\Models\Chat;
    use Closure;

    class CheckChatLessonIsOffline {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle ($request, Closure $next) {
            $id_user = $request->route()->parameter('id_user');

            $chat = Chat::findByUsers($request->user()->id_user, $id_user);
            $chat->and(['users']);

            if ($chat->users->from->id_role === 1) {
                $chat->and(['lessons']);

                foreach ($chat->lessons as $lesson) {
                    if ($lesson->id_type !== 2) {
                        return response()->json([
                            'code' => 403,
                            'message' => "Chat Lesson type is not seguimiento online",
                        ]);
                    }
                }
            }

            return $next($request);
        }
    }