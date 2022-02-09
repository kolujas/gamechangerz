<?php
    namespace App\Http\Middleware;

    use App\Models\Game;
    use Closure;
    use Illuminate\Http\Request;

    class CheckGameExist {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle (Request $request, Closure $next) {
            $slug = $request->route()->parameter('slug');

            if (!Game::bySlug($slug)->first()) {
                return redirect()->back()->with('status', [
                    'code' => 404,
                    'message' => "Game \"$slug\" does not exist",
                ]);
            }

            return $next($request);
        }
    }