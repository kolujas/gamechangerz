<?php
    namespace App\Http\Middleware\API;

    use App\Models\Chat;
    use Closure;
    use Illuminate\Http\Request;

    class CheckChatExist {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle (Request $request, Closure $next) {
            $id_chat = $request->route()->parameter('id_chat');
            if (!Chat::find($id_chat)) {
                return response()->json([
                    'code' => 404,
                    'message' => "Chat \"$id_chat\" does not exist",
                ]);
            }
            return $next($request);
        }
    }