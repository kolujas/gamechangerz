<?php
    namespace App\Http\Middleware;

    use App\Models\Friend;
    use Closure;
    use Illuminate\Http\Request;

    class CheckFriendshipActionExist {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle (Request $request, Closure $next) {
            $action = $request->route()->parameter('action');

            if (!Friend::hasAction($action)) {
                return redirect()->back()->with('status', [
                    'code' => 404,
                    'message' => "Action \"$action\" does not exist",
                ]);
            }
            
            return $next($request);
        }
    }