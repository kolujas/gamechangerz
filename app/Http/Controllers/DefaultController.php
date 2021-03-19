<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;

    class DefaultController extends Controller {        
        /**
         * * Control the checkout page.
         * @return [type]
         */
        public function checkout(){
            return view('web.checkout', [
                // ? Data
            ]);
        }

        /**
         * * Control the coming soon page.
         * @return [type]
         */
        public function comingSoon(){
            return view('web.coming_soon', [
                // ? Data
            ]);
        }

        /**
         * * Control the game page.
         * @param string $slug Game slug.
         * @return [type]
         */
        public function game($slug){
            return view('web.game', [
                // ? Data
            ]);
        }

        /**
         * * Control the home page.
         * @return [type]
         */
        public function home(){
            return view('web.home', [
                // ? Data
            ]);
        }

        /**
         * * Control the privacy politics page.
         * @return [type]
         */
        public function privacyPolitics(){
            return view('web.privacy_politics', [
                // ? Data
            ]);
        }

        /**
         * * Control the terms &contidions page.
         * @return [type]
         */
        public function termsAndContidions(){
            return view('web.terms_&_contidions', [
                // ? Data
            ]);
        }
    }