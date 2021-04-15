<?php
    namespace App\Http\Middleware;

    use Auth;
    use Closure;
    use Illuminate\Http\Request;

    class Own {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle(Request $request, Closure $next) {
            if ($request->user()) {
                if ($request->user()->slug === $request->route()->parameter('slug')) {
                    $request->session()->put('error', [
                        'code' => 403,
                        'message' => 'You can not access your own checkout',
                    ]);
                    return redirect()->back();
                }
            }
            return $next($request);
        }
    }