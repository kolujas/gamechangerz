<?php
    namespace App\Http\Middleware\API;

    use App\Models\Chat;
    use Carbon\Carbon;
    use Closure;

    class CheckChatIsAvailable {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle ($request, Closure $next) {
            $field = (!is_null($request->route()->parameter('id_user')) ? $request->route()->parameter('id_user') : $request->route()->parameter('id_chat'));

            $chat = (!is_null($request->route()->parameter('id_user')) ? Chat::findByUsers($field, $request->user()->id_user) : Chat::find($field));
            $chat->and(['users', ["available", $request->user()->id_user]]);

            if (!$chat->available) {
                return response()->json([
                    'code' => 403,
                    'message' => "Chat is not available",
                ]);
            }

            return $next($request);
        }
    }
