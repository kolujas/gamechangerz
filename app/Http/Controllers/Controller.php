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
         * * Transforms a date to humans format text.
         * @param Date $date
         */
        public function justMonth($date){
            $months = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            Carbon::setLocale('es');
            $date = new Carbon($date);
            $month = $months[intval($date->format('m')) - 1];
            $day = $date->format('d') ;
            $year = $date->format('Y') ;
            return "$month $day, $year";
        }

        public function encodeInput ($array = [], $string = '') {
            foreach ($array as $key => $value) {
                $array["$string$key"] = $value;
            }
            foreach ($array as $key => $value) {
                if (!preg_match("/$string/", $key)) {
                    unset($array[$key]);
                }
            }
            return $array;
        }

        public function decodeInput ($array = [], $string = '') {
            foreach ($array as $key => $value) {
                if (preg_match("/$string/", $key)) {
                    $array[explode($string, $key)[1]] = $value;
                }
            }
            foreach ($array as $key => $value) {
                if (preg_match("/$string/", $key)) {
                    unset($array[$key]);
                }
            }
            return $array;
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

        /**
         * * Replace the Rules unique field.
         * @param array [$rules]
         * @param mixed $text Text to insert.
         * @return string
         */
        public function replaceUnique (array $rules = [], $text) {
            return preg_replace("({[a-z_]*})", $text, $rules);
        }
    }