<?php
    namespace App\Http\Controllers;

    use Carbon\Carbon;
    use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    use Illuminate\Foundation\Bus\DispatchesJobs;
    use Illuminate\Foundation\Validation\ValidatesRequests;
    use Illuminate\Http\Request;
    use Illuminate\Routing\Controller as BaseController;

    class Controller extends BaseController {
        use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

        /**
         * * Transforms a date to humans format text.
         * @param Date $date
         */
        public function dateToHuman($date){
            Carbon::setLocale('es');
            $date = new Carbon($date);
            $date = $date->diffForHumans();
            return $date;
        }
        
        /**
         * * Control the index page.
         * @return [type]
         */
        public function index (Request $request) {
            return view('web.home', [
                // ? Data
            ]);
        }
    }