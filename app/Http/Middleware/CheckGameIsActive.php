<?php
    namespace App\Http\Middleware;

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
            foreach (Game::$options as $game) {
                $game = (object) $game;
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