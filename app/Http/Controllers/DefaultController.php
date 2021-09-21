<?php
    namespace App\Http\Controllers;

    use App\Models\Ability;
    use App\Models\Assigment;
    use App\Models\Auth as AuthModel;
    use App\Models\Game;
    use App\Models\Google;
    use App\Models\Post;
    use App\Models\Presentation;
    use App\Models\User;
    use Illuminate\Http\Request;

    class DefaultController extends Controller {
        /**
         * * Control the index page.
         * @return [type]
         */
        public function index (Request $request) {
            $error = null;
            if ($request->session()->has("error")) {
                $error = (object) $request->session()->pull("error");
            }

            $games = Game::all();
            foreach ($games as $game) {
                $game->and(["colors", "files"]);
            }

            return view("web.home", [
                "games" => $games,
                "error" => $error,
                "validation" => [
                    "login" => (object)[
                        "rules" => $this->encodeInput(AuthModel::$validation["login"]["rules"], "login_"),
                        "messages" => $this->encodeInput(AuthModel::$validation["login"]["messages"]["es"], "login_"),
                ], "signin" => (object)[
                        "rules" => $this->encodeInput(AuthModel::$validation["signin"]["rules"], "signin_"),
                        "messages" => $this->encodeInput(AuthModel::$validation["signin"]["messages"]["es"], "signin_"),
                ], "assigment" => (object)[
                        "rules" => Assigment::$validation["make"]["rules"],
                        "messages" => Assigment::$validation["make"]["messages"]["es"],
                ], "advanced" => (object)[
                        "rules" => User::$validation["advanced"]["rules"],
                        "messages" => User::$validation["advanced"]["messages"]["es"],
                ], "presentation" => (object)[
                        "rules" => Presentation::$validation["make"]["rules"],
                        "messages" => Presentation::$validation["make"]["messages"]["es"],
                ]],
            ]);
        }

        /**
         * * Control the coming soon page.
         * @return [type]
         */
        public function comingSoon (Request $request) {
            $error = null;
            if ($request->session()->has("error")) {
                $error = (object) $request->session()->pull("error");
            }

            return view("web.coming_soon", [
                "error" => $error,
                "validation" => [],
            ]);
        }

        /**
         * * Control the landing page.
         * @param string $slug Game slug.
         * @return [type]
         */
        public function landing (Request $request, $slug) {
            $error = null;
            if ($request->session()->has("error")) {
                $error = (object) $request->session()->pull("error");
            }

            $game = Game::findBySlug($slug);
            $game->and(["abilities", "users", "files", "colors"]);

            $posts = Post::fromAdmin();
            foreach ($posts as $post) {
                $post->and(["user"]);
                $post->date = $this->dateToHuman($post->updated_at);
            }

            return view("web.landing", [
                "game" => $game,
                "posts" => $posts,
                "error" => $error,
                "validation" => [
                    "login" => (object)[
                        "rules" => $this->encodeInput(AuthModel::$validation["login"]["rules"], "login_"),
                        "messages" => $this->encodeInput(AuthModel::$validation["login"]["messages"]["es"], "login_"),
                ], "signin" => (object)[
                        "rules" => $this->encodeInput(AuthModel::$validation["signin"]["rules"], "signin_"),
                        "messages" => $this->encodeInput(AuthModel::$validation["signin"]["messages"]["es"], "signin_"),
                ], "assigment" => (object)[
                        "rules" => Assigment::$validation["make"]["rules"],
                        "messages" => Assigment::$validation["make"]["messages"]["es"],
                ], "advanced" => (object)[
                        "rules" => User::$validation["advanced"]["rules"],
                        "messages" => User::$validation["advanced"]["messages"]["es"],
                ], "presentation" => (object)[
                        "rules" => Presentation::$validation["make"]["rules"],
                        "messages" => Presentation::$validation["make"]["messages"]["es"],
                ]],
            ]);
        }

        /**
         * * Control the home page.
         * @return [type]
         */
        public function home (Request $request) {
            $error = null;
            if ($request->session()->has("error")) {
                $error = (object) $request->session()->pull("error");
            }

            $games = Game::all();
            foreach ($games as $game) {
                $game->and(["colors", "files"]);
            }

            return view("web.home", [
                "games" => $games,
                "error" => $error,
                "validation" => [
                    "login" => (object)[
                        "rules" => $this->encodeInput(AuthModel::$validation["login"]["rules"], "login_"),
                        "messages" => $this->encodeInput(AuthModel::$validation["login"]["messages"]["es"], "login_"),
                ], "signin" => (object)[
                        "rules" => $this->encodeInput(AuthModel::$validation["signin"]["rules"], "signin_"),
                        "messages" => $this->encodeInput(AuthModel::$validation["signin"]["messages"]["es"], "signin_"),
                ], "assigment" => (object)[
                        "rules" => Assigment::$validation["make"]["rules"],
                        "messages" => Assigment::$validation["make"]["messages"]["es"],
                ], "advanced" => (object)[
                        "rules" => User::$validation["advanced"]["rules"],
                        "messages" => User::$validation["advanced"]["messages"]["es"],
                ], "presentation" => (object)[
                        "rules" => Presentation::$validation["make"]["rules"],
                        "messages" => Presentation::$validation["make"]["messages"]["es"],
                ]],
            ]);
        }

        /**
         * * Control the privacy politics page.
         * @return [type]
         */
        public function privacyPolitics (Request $request) {
            $error = null;
            if ($request->session()->has("error")) {
                $error = (object) $request->session()->pull("error");
            }

            return view("web.privacy_politics", [
                "error" => $error,
                "validation" => [
                    "login" => (object)[
                        "rules" => $this->encodeInput(AuthModel::$validation["login"]["rules"], "login_"),
                        "messages" => $this->encodeInput(AuthModel::$validation["login"]["messages"]["es"], "login_"),
                ], "signin" => (object)[
                        "rules" => $this->encodeInput(AuthModel::$validation["signin"]["rules"], "signin_"),
                        "messages" => $this->encodeInput(AuthModel::$validation["signin"]["messages"]["es"], "signin_"),
                ], "assigment" => (object)[
                        "rules" => Assigment::$validation["make"]["rules"],
                        "messages" => Assigment::$validation["make"]["messages"]["es"],
                ], "advanced" => (object)[
                        "rules" => User::$validation["advanced"]["rules"],
                        "messages" => User::$validation["advanced"]["messages"]["es"],
                ], "presentation" => (object)[
                        "rules" => Presentation::$validation["make"]["rules"],
                        "messages" => Presentation::$validation["make"]["messages"]["es"],
                ]],
            ]);
        }

        /**
         * * Control the terms & contidions page.
         * @return [type]
         */
        public function termsAndConditions (Request $request) {
            $error = null;
            if ($request->session()->has("error")) {
                $error = (object) $request->session()->pull("error");
            }

            return view("web.terms_&_conditions", [
                "error" => $error,
                "validation" => [
                    "login" => (object)[
                        "rules" => $this->encodeInput(AuthModel::$validation["login"]["rules"], "login_"),
                        "messages" => $this->encodeInput(AuthModel::$validation["login"]["messages"]["es"], "login_"),
                ], "signin" => (object)[
                        "rules" => $this->encodeInput(AuthModel::$validation["signin"]["rules"], "signin_"),
                        "messages" => $this->encodeInput(AuthModel::$validation["signin"]["messages"]["es"], "signin_"),
                ], "assigment" => (object)[
                        "rules" => Assigment::$validation["make"]["rules"],
                        "messages" => Assigment::$validation["make"]["messages"]["es"],
                ], "advanced" => (object)[
                        "rules" => User::$validation["advanced"]["rules"],
                        "messages" => User::$validation["advanced"]["messages"]["es"],
                ], "presentation" => (object)[
                        "rules" => Presentation::$validation["make"]["rules"],
                        "messages" => Presentation::$validation["make"]["messages"]["es"],
                ]],
            ]);
        }

        /**
         * * Control the frequent ask questions page.
         * @return [type]
         */
        public function faq (Request $request) {
            $error = null;
            if ($request->session()->has("error")) {
                $error = (object) $request->session()->pull("error");
            }

            return view("web.faq", [
                "error" => $error,
                "validation" => [
                    "login" => (object)[
                        "rules" => $this->encodeInput(AuthModel::$validation["login"]["rules"], "login_"),
                        "messages" => $this->encodeInput(AuthModel::$validation["login"]["messages"]["es"], "login_"),
                ], "signin" => (object)[
                        "rules" => $this->encodeInput(AuthModel::$validation["signin"]["rules"], "signin_"),
                        "messages" => $this->encodeInput(AuthModel::$validation["signin"]["messages"]["es"], "signin_"),
                ], "assigment" => (object)[
                        "rules" => Assigment::$validation["make"]["rules"],
                        "messages" => Assigment::$validation["make"]["messages"]["es"],
                ], "advanced" => (object)[
                        "rules" => User::$validation["advanced"]["rules"],
                        "messages" => User::$validation["advanced"]["messages"]["es"],
                ], "presentation" => (object)[
                        "rules" => Presentation::$validation["make"]["rules"],
                        "messages" => Presentation::$validation["make"]["messages"]["es"],
                ]],
            ]);
        }

        public function contact (Request $request) {
            $error = null;
            if ($request->session()->has("error")) {
                $error = (object) $request->session()->pull("error");
            }

            return view("web.contact", [
                "error" => $error,
                "validation" => [
                    "login" => (object)[
                        "rules" => $this->encodeInput(AuthModel::$validation["login"]["rules"], "login_"),
                        "messages" => $this->encodeInput(AuthModel::$validation["login"]["messages"]["es"], "login_"),
                ], "signin" => (object)[
                        "rules" => $this->encodeInput(AuthModel::$validation["signin"]["rules"], "signin_"),
                        "messages" => $this->encodeInput(AuthModel::$validation["signin"]["messages"]["es"], "signin_"),
                ], "assigment" => (object)[
                        "rules" => Assigment::$validation["make"]["rules"],
                        "messages" => Assigment::$validation["make"]["messages"]["es"],
                ], "advanced" => (object)[
                        "rules" => User::$validation["advanced"]["rules"],
                        "messages" => User::$validation["advanced"]["messages"]["es"],
                ], "presentation" => (object)[
                        "rules" => Presentation::$validation["make"]["rules"],
                        "messages" => Presentation::$validation["make"]["messages"]["es"],
                ]],
            ]);
        }

        public function support (Request $request) {
            $error = null;
            if ($request->session()->has("error")) {
                $error = (object) $request->session()->pull("error");
            }

            return view("web.support", [
                "error" => $error,
                "validation" => [
                    "login" => (object)[
                        "rules" => $this->encodeInput(AuthModel::$validation["login"]["rules"], "login_"),
                        "messages" => $this->encodeInput(AuthModel::$validation["login"]["messages"]["es"], "login_"),
                ], "signin" => (object)[
                        "rules" => $this->encodeInput(AuthModel::$validation["signin"]["rules"], "signin_"),
                        "messages" => $this->encodeInput(AuthModel::$validation["signin"]["messages"]["es"], "signin_"),
                ], "assigment" => (object)[
                        "rules" => Assigment::$validation["make"]["rules"],
                        "messages" => Assigment::$validation["make"]["messages"]["es"],
                ], "advanced" => (object)[
                        "rules" => User::$validation["advanced"]["rules"],
                        "messages" => User::$validation["advanced"]["messages"]["es"],
                ], "presentation" => (object)[
                        "rules" => Presentation::$validation["make"]["rules"],
                        "messages" => Presentation::$validation["make"]["messages"]["es"],
                ]],
            ]);
        }

        /**
         * * Control the apply page.
         * @return [type]
         */
        public function apply (Request $request) {
            $error = null;
            if ($request->session()->has("error")) {
                $error = (object) $request->session()->pull("error");
            }

            return view("web.apply", [
                "error" => $error,
                "validation" => [
                    "login" => (object)[
                        "rules" => $this->encodeInput(AuthModel::$validation["login"]["rules"], "login_"),
                        "messages" => $this->encodeInput(AuthModel::$validation["login"]["messages"]["es"], "login_"),
                ], "signin" => (object)[
                        "rules" => $this->encodeInput(AuthModel::$validation["signin"]["rules"], "signin_"),
                        "messages" => $this->encodeInput(AuthModel::$validation["signin"]["messages"]["es"], "signin_"),
                ], "assigment" => (object)[
                        "rules" => Assigment::$validation["make"]["rules"],
                        "messages" => Assigment::$validation["make"]["messages"]["es"],
                ], "advanced" => (object)[
                        "rules" => User::$validation["advanced"]["rules"],
                        "messages" => User::$validation["advanced"]["messages"]["es"],
                ], "presentation" => (object)[
                        "rules" => Presentation::$validation["make"]["rules"],
                        "messages" => Presentation::$validation["make"]["messages"]["es"],
                ], "apply" => (object)[
                        "rules" => User::$validation["apply"]["rules"],
                        "messages" => User::$validation["apply"]["messages"]["es"],
                ]],
            ]);
        }
    }