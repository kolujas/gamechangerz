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
            $id_status = $request->route()->parameter('id_status');

            if (intval($id_status) !== 0 && intval($id_status) !== 1 && intval($id_status) !== 2 && intval($id_status) !== 3) {
                return redirect()->back()->with('status', [
                    'code' => 404,
                    'message' => "Lesson status does not exist",
                ]);
            }
            
            return $next($request);
        }
    }
