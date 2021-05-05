<?php
    namespace App\Http\Middleware;

    use App\Models\Post;
    use Closure;
    use Illuminate\Http\Request;

    class CheckPostExist {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle (Request $request, Closure $next) {
            $slug = $request->route()->parameter('slug');
            if (!count(Post::where('slug', '=', $slug)->get())) {
                $request->session()->put('error', [
                    'code' => 404,
                    'message' => "Post \"$slug\" does not exist",
                ]);
                return redirect()->back();
            }
            return $next($request);
        }
    }