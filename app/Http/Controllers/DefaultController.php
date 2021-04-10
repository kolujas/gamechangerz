<?php
    namespace App\Http\Controllers;

    use App\Models\Ability;
    use App\Models\Game;
    use Illuminate\Http\Request;

    class DefaultController extends Controller {
        /**
         * * Control the index page.
         * @return [type]
         */
        public function index () {
            return view('web.home', [
                'games' => Game::getOptions(),
            ]);
        }

        /**
         * * Control the coming soon page.
         * @return [type]
         */
        public function comingSoon () {
            return view('web.coming_soon', [
                // ? Data
            ]);
        }

        /**
         * * Control the game page.
         * @param string $slug Game slug.
         * @return [type]
         */
        public function game ($slug) {
            $game = Game::search($slug);
            $game->abilities = Ability::parse($game->abilities);
            return view('web.game', [
                'game' => $game,
            ]);
        }

        /**
         * * Control the home page.
         * @return [type]
         */
        public function home () {
            return view('web.home', [
                'games' => Game::getOptions(),
            ]);
        }

        /**
         * * Control the privacy politics page.
         * @return [type]
         */
        public function privacyPolitics () {
            return view('web.privacy_politics', [
                // ? Data
            ]);
        }

        /**
         * * Control the terms &contidions page.
         * @return [type]
         */
        public function termsAndContidions () {
            return view('web.terms_&_contidions', [
                // ? Data
            ]);
        }
    }