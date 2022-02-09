<?php
    namespace App\Http\Middleware;

    use App\Models\game;
    use Closure;
    use Illuminate\Http\Request;

    class CheckGameIsActive {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle (Request $request, Closure $next) {
            $slug = $request->route()->parameter('slug');
            $game = Game::bySlug($slug)->first();

            if (!$game->active) {
                return redirect()->back()->with('status', [
                    'code' => 403,
                    'message' => "Game \"$game->name\" is not active",
                ]);
            }

            return $next($request);
        }
    }