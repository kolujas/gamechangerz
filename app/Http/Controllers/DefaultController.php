<?php
    namespace App\Http\Controllers;

    use App\Models\Assignment;
    use App\Models\Auth as AuthModel;
    use App\Models\Game;
    use App\Models\Google;
    use App\Models\Mail;
    use App\Models\Post;
    use App\Models\Presentation;
    use App\Models\User;
    use Auth;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class DefaultController extends Controller {
        /**
         * * Control the apply page.
         * @return \Illuminate\Http\Response
         */
        public function apply (Request $request) {
            return view("web.apply", [
                // ?
            ]);
        }

        /**
         * * Control the coming soon page.
         * @return \Illuminate\Http\Response
         */
        public function comingSoon (Request $request) {
            return view("web.coming_soon", [
                // ?
            ]);
        }

        /**
         * * Controls the contact page.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function contact (Request $request) {
            return view("web.contact", [
                // ?
            ]);
        }

        /**
         * * Control the frequent ask questions page.
         * @return \Illuminate\Http\Response
         */
        public function faq (Request $request) {
            return view("web.faq", [
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
                $game->and(["colors", "files"]);
            }

            return view("web.home", [
                "games" => $games,
            ]);
        }

        /**
         * * Control the landing page.
         * @param string $slug Game slug.
         * @return \Illuminate\Http\Response
         */
        public function landing (Request $request, $slug) {
            $game = Game::bySlug($slug)->first();
            $game->and(["abilities", "users", "files", "colors"]);

            $posts = Post::byAdmin()->limit(10)->get();
            foreach ($posts as $post) {
                $post->and(["user"]);
                $post->date = $this->dateToHuman($post->updated_at);
            }

            return view("web.landing", [
                "game" => $game,
                "posts" => $posts,
            ]);
        }

        /**
         * * Control the home page.
         * @return \Illuminate\Http\Response
         */
        public function home (Request $request) {
            $games = Game::all();
            foreach ($games as $game) {
                $game->and(["colors", "files"]);
            }

            return view("web.home", [
                "games" => $games,
            ]);
        }

        /**
         * * Control the privacy politics page.
         * @return \Illuminate\Http\Response
         */
        public function privacyPolitics (Request $request) {
            return view("web.privacy_politics", [
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

            $validator = Validator::make((array) $input, Mail::$validation["contact"]["rules"], Mail::$validation["contact"]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            new Mail([ "id_mail" => 11, ], [
                "email_from" => $input->email,
                "email_to" => 'contacto@gamechangerz.gg',
                "name" => $input->name,
                "details" => $input->details,
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

            $validator = Validator::make((array) $input, Mail::$validation["support"]["rules"], Mail::$validation["support"]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            new Mail([ "id_mail" => 12, ], [
                "email_from" => $input->email,
                "email_to" => 'soporte@gamechangerz.gg',
                "name" => $input->name,
                "details" => $input->details,
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
            return view("web.support", [
                // ?
            ]);
        }

        /**
         * * Control the terms & contidions page.
         * @return \Illuminate\Http\Response
         */
        public function termsAndConditions (Request $request) {
            return view("web.terms_&_conditions", [
                // ?
            ]);
        }
    }