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
            // $notifications = Auth::check() ? Auth::user()->notifications : [];
            // foreach ($notifications as $notification) {
            //     $notification->delete();
            // }

            return view("web.apply", [
                // "notifications" => $notifications,
            ]);
        }

        /**
         * * Control the coming soon page.
         * @return \Illuminate\Http\Response
         */
        public function comingSoon (Request $request) {
            // $notifications = Auth::check() ? Auth::user()->notifications : [];
            // foreach ($notifications as $notification) {
            //     $notification->delete();
            // }

            return view("web.coming_soon", [
                // "notifications" => $notifications,
                "validation" => [],
            ]);
        }

        /**
         * * Controls the contact page.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function contact (Request $request) {
            // $notifications = Auth::check() ? Auth::user()->notifications : [];
            // foreach ($notifications as $notification) {
            //     $notification->delete();
            // }

            return view("web.contact", [
                // "notifications" => $notifications,
            ]);
        }

        /**
         * * Control the frequent ask questions page.
         * @return \Illuminate\Http\Response
         */
        public function faq (Request $request) {
            // $notifications = Auth::check() ? Auth::user()->notifications : [];
            // foreach ($notifications as $notification) {
            //     $notification->delete();
            // }

            return view("web.faq", [
                // "notifications" => $notifications,
            ]);
        }

        /**
         * * Control the index page.
         * @return \Illuminate\Http\Response
         */
        public function index (Request $request) {
            // $notifications = Auth::check() ? Auth::user()->notifications : [];
            // foreach ($notifications as $notification) {
            //     $notification->delete();
            // }

            $games = Game::all();
            foreach ($games as $game) {
                $game->and(["colors", "files"]);
            }

            return view("web.home", [
                "games" => $games,
                // "notifications" => $notifications,
            ]);
        }

        /**
         * * Control the landing page.
         * @param string $slug Game slug.
         * @return \Illuminate\Http\Response
         */
        public function landing (Request $request, $slug) {
            // $notifications = Auth::check() ? Auth::user()->notifications : [];
            // foreach ($notifications as $notification) {
            //     $notification->delete();
            // }

            $game = Game::bySlug($slug)->first();
            $game->and(["abilities", "users", "files", "colors"]);

            $posts = Post::byAdmin()->limit(10)->get();
            foreach ($posts as $post) {
                $post->and(["user"]);
                $post->date = $this->dateToHuman($post->updated_at);
            }

            return view("web.landing", [
                "game" => $game,
                // "notifications" => $notifications,
                "posts" => $posts,
            ]);
        }

        /**
         * * Control the home page.
         * @return \Illuminate\Http\Response
         */
        public function home (Request $request) {
            // $notifications = Auth::check() ? Auth::user()->notifications : [];
            // foreach ($notifications as $notification) {
            //     $notification->delete();
            // }

            $games = Game::all();
            foreach ($games as $game) {
                $game->and(["colors", "files"]);
            }

            return view("web.home", [
                "games" => $games,
                // "notifications" => $notifications,
            ]);
        }

        /**
         * * Control the privacy politics page.
         * @return \Illuminate\Http\Response
         */
        public function privacyPolitics (Request $request) {
            // $notifications = Auth::check() ? Auth::user()->notifications : [];
            // foreach ($notifications as $notification) {
            //     $notification->delete();
            // }

            return view("web.privacy_politics", [
                // "notifications" => $notifications,
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
            // $notifications = Auth::check() ? Auth::user()->notifications : [];
            // foreach ($notifications as $notification) {
            //     $notification->delete();
            // }

            return view("web.support", [
                // "notifications" => $notifications,
            ]);
        }

        /**
         * * Control the terms & contidions page.
         * @return \Illuminate\Http\Response
         */
        public function termsAndConditions (Request $request) {
            // $notifications = Auth::check() ? Auth::user()->notifications : [];
            // foreach ($notifications as $notification) {
            //     $notification->delete();
            // }

            return view("web.terms_&_conditions", [
                // "notifications" => $notifications,
            ]);
        }
    }