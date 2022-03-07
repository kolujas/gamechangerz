<?php
    namespace App\Http\Controllers;

    use Carbon\Carbon;
    use App\Models\Game;
    use App\Models\Mail;
    use App\Models\Post;
    use Illuminate\Http\Request;
    use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    use Illuminate\Foundation\Bus\DispatchesJobs;
    use Illuminate\Foundation\Validation\ValidatesRequests;
    use Illuminate\Routing\Controller as BaseController;
    use Illuminate\Support\Facades\Validator;

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
         * * Replace the Rules unique field.
         * @param array [$rules]
         * @param mixed $text Text to insert.
         * @return string
         */
        static public function replaceUnique (array $rules = [], $text) {
            return preg_replace("({[a-z_]*})", $text, $rules);
        }

        
        /**
         * * Control the apply page.
         * @return \Illuminate\Http\Response
         */
        public function apply (Request $request) {
            return view('web.apply', [
                // ?
            ]);
        }

        /**
         * * Control the coming soon page.
         * @return \Illuminate\Http\Response
         */
        public function comingSoon (Request $request) {
            return view('web.coming_soon', [
                // ?
            ]);
        }

        /**
         * * Controls the contact page.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function contact (Request $request) {
            return view('web.contact', [
                // ?
            ]);
        }

        /**
         * * Control the frequent ask questions page.
         * @return \Illuminate\Http\Response
         */
        public function faq (Request $request) {
            return view('web.faq', [
                // ?
            ]);
        }

        /**
         * * Control the index page.
         * @return \Illuminate\Http\Response
         */
        public function index (Request $request) {
            $games = Game::all();
            foreach ($games as $game) {
                $game->and(['colors', 'files']);
            }

            return view('web.home', [
                'games' => $games,
            ]);
        }

        /**
         * * Control the landing page.
         * @param string $slug Game slug.
         * @return \Illuminate\Http\Response
         */
        public function landing (Request $request, $slug) {
            $game = Game::bySlug($slug)->first();
            $game->and(['abilities', 'users', 'files', 'colors']);

            $posts = Post::byAdmin()->limit(10)->get();
            foreach ($posts as $post) {
                $post->and(['user']);
                $post->date = $this->dateToHuman($post->updated_at);
            }

            return view('web.landing', [
                'game' => $game,
                'posts' => $posts,
            ]);
        }

        /**
         * * Control the home page.
         * @return \Illuminate\Http\Response
         */
        public function home (Request $request) {
            $games = Game::all();
            foreach ($games as $game) {
                $game->and(['colors', 'files']);
            }

            return view('web.home', [
                'games' => $games,
            ]);
        }

        /**
         * * Control the privacy politics page.
         * @return \Illuminate\Http\Response
         */
        public function privacyPolitics (Request $request) {
            return view('web.privacy_politics', [
                // ?
            ]);
        }

        /**
         * * Sends the Contact mail.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function sendContact (Request $request) {
            $input = (object) $request->all();

            $validator = Validator::make((array) $input, Mail::$validation['contact']['rules'], Mail::$validation['contact']['messages']['es']);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            new Mail([ 'id_mail' => 11, ], [
                'email_from' => $input->email,
                'email_to' => 'contacto@gamechangerz.gg',
                'name' => $input->name,
                'details' => $input->details,
            ]);

            return redirect('/')->with('status', [
                'code' => 200,
                'messages' => 'Su mensaje nos llego correctamente. Muchas gracias!',
            ]);
        }

        /**
         * * Sends the Support mail.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function sendSupport (Request $request) {
            $input = (object) $request->all();

            $validator = Validator::make((array) $input, Mail::$validation['support']['rules'], Mail::$validation['support']['messages']['es']);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            new Mail([ 'id_mail' => 12, ], [
                'email_from' => $input->email,
                'email_to' => 'soporte@gamechangerz.gg',
                'name' => $input->name,
                'details' => $input->details,
            ]);

            return redirect('/')->with('status', [
                'code' => 200,
                'messages' => 'Su mensaje nos llego correctamente. Muchas gracias!',
            ]);
        }

        /**
         * * Controls the support page.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function support (Request $request) {
            return view('web.support', [
                // ?
            ]);
        }

        /**
         * * Control the terms & contidions page.
         * @return \Illuminate\Http\Response
         */
        public function termsAndConditions (Request $request) {
            return view('web.terms_&_conditions', [
                // ?
            ]);
        }
    }