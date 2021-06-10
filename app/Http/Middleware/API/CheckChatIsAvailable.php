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

            $chat = (!is_null($request->route()->parameter('id_user')) ? Chat::where([
                ['id_user_from', '=', $field],
                ['id_user_to', '=', $request->user()->id_user]
            ])->orwhere([
                ['id_user_from', '=', $request->user()->id_user],
                ['id_user_to', '=', $field]
            ])->get()[0] : Chat::find($field));
            $chat->and(['users', 'available']);

            if (!$chat->available) {
                return response()->json([
                    'code' => 403,
                    'message' => "Chat is not available",
                ]);
            }

            return $next($request);
        }
    }
