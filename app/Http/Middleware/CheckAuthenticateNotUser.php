<?php
    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Http\Request;

    class CheckAuthenticateNotUser {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle(Request $request, Closure $next) {
            $slug = $request->route()->parameter('slug');

            if ($request->user()->slug === $slug) {
                return redirect()->back()->with('status', [
                    'code' => 403,
                    'message' => "You can not access here",
                ]);
            }
            
            return $next($request);
        }
    }