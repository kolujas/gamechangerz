<?php
    namespace App\Http\Controllers;

    use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    use Illuminate\Foundation\Bus\DispatchesJobs;
    use Illuminate\Foundation\Validation\ValidatesRequests;
    use Illuminate\Routing\Controller as BaseController;

    class Controller extends BaseController {
        use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
        
        /**
         * * Control the index page.
         * @return [type]
         */
        public function index(){
            return view('web.coming_soon', [
                // ? Data
            ]);
        }
    }