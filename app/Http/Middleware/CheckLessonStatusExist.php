<?php
    namespace App\Http\Middleware;

    use Closure;

    class CheckLessonStatusExist {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle ($request, Closure $next) {
            $status = $request->route()->parameter('status');

            if (intval($status) !== 0 && intval($status) !== 1 && intval($status) !== 2) {
                $request->session()->put('error', [
                    'code' => 404,
                    'message' => "Lesson status does not exist",
                ]);

                return redirect()->back();
            }
            
            return $next($request);
        }
    }
