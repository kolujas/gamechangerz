<?php
    namespace App\Http\Controllers;

    use App\Models\User;
    use Illuminate\Http\Request;

    class UserController extends Controller {
        /**
         * * Control the User profile page.
         * @param string $slug User slug.
         * @return [type]
         */
        public function profile ($slug) {
            $user = User::where('slug', '=', $slug)->get()[0];
            $user->achievements();
            $user->games();
            dd($user);
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