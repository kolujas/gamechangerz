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
            foreach (Game::$options as $game) {
                $game = (object) $game;
                if ($game->slug === $slug) {
                    break;
                }
            }
            if (!$game->active) {
                $request->session()->put('error', [
                    'code' => 403,
                    'message' => "Game \"$game->name\" is not active",
                ]);
                return redirect()->back();
            }
            return $next($request);
        }
    }