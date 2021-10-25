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
            $slug = (!is_null($request->route()->parameter('slug')) ? $request->route()->parameter('slug') : $request->route()->parameter('post'));

            if (!Post::bySlug($slug)->first()) {
                $request->session()->put('error', [
                    'code' => 404,
                    'message' => "Post \"$slug\" does not exist",
                ]);

                return redirect()->back();
            }
            
            return $next($request);
        }
    }