<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;

    class UserController extends Controller {
        /**
         * * Control the User profile page.
         * @param string $slug User slug.
         * @return [type]
         */
        public function profile ($slug) {
            return view('user.profile', [
                // ? Data
            ]);
        }

        /**
         * * Control the User search page.
         * @return [type]
         */
        public function search () {
            return view('user.search', [
                // ? Data
            ]);
        }
    }