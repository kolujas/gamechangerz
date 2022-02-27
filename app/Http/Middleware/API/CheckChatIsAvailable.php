<?php
    namespace App\Http\Middleware\API;

    use App\Models\Chat;
    use Auth;
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
            if (!is_null($request->route()->parameter('id_chat'))) {
                $chat = Chat::find($request->route()->parameter('id_chat'));
            }
            if (!is_null($request->route()->parameter('id_user'))) {
                $chat = Chat::byUsers($request->route()->parameter('id_user'), Auth::user()->id_user)->first();
            }

            if (!$chat->available) {
                return response()->json([
                    'code' => 403,
                    'message' => "Chat is not available",
                ]);
            }

            return $next($request);
        }
    }
