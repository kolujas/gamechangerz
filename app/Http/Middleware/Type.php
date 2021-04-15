<?php
    namespace App\Http\Middleware;

    use App\Models\Lesson;
    use Closure;
    use Illuminate\Http\Request;

    class Type {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle (Request $request, Closure $next) {
            $found = false;
            foreach (Lesson::$options as $lesson) {
                $lesson = (object) $lesson;
                if ($lesson->slug === $request->route()->parameter('type')) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $request->session()->put('error', [
                    'code' => 403,
                    'message' => "This is not a lesson type",
                ]);
                return redirect()->back();
            }
            return $next($request);
        }
    }