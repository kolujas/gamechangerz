<?php
    namespace App\Http\Middleware;

    use Closure;

    class CheckNotificationTypeExist {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle ($request, Closure $next) {
            $type = $request->route()->parameter('type');
            if ($status !== 'mercadopago' && $status !== 'paypal') {
                $request->session()->put('error', [
                    'code' => 404,
                    'message' => "Notification \"$type\" does not exist",
                ]);
                return redirect()->back();
            }
            return $next($request);
        }
    }