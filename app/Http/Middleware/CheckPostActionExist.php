<?php
    namespace App\Http\Middleware;

    use App\Models\Post;
    use Closure;

    class CheckPostActionExist {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle ($request, Closure $next) {
            $action = $request->route()->parameter('action');

            switch (strtoupper($action)) {
                case 'UPDATE':
                case 'DELETE':
                    break;
                default:
                    return redirect()->back()->with('status', [
                        'code' => 404,
                        'message' => "Action \"$action\" does not exist",
                    ]);
            }
            
            return $next($request);
        }
    }
