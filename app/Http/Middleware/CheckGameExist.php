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
            $found = false;
            foreach (Game::$options as $game) {
                $game = (object) $game;
                if ($game->slug === $slug) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $request->session()->put('error', [
                    'code' => 404,
                    'message' => "Game \"$slug\" does not exist",
                ]);
                return redirect()->back();
            }
            return $next($request);
        }
    }