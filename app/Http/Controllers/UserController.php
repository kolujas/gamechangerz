<?php
    namespace App\Http\Controllers;

    use App\Models\Lesson;
    use App\Models\User;
    use App\Models\Game;
    use Illuminate\Http\Request;

    class UserController extends Controller {
        /**
         * * Control the User profile page.
         * @param string $slug User slug.
         * @return [type]
         */
        public function profile ($slug) {
            // $user = User::where('slug', '=', $slug)->get()[0];
            // $user->achievements();
            // $user->files();
            // $user->games();
            // $user->idioms();
            // if ($user->id_role === 1) {
            //     $user->days();
            //     $user->prices();
            // }
            // $user->role();
            return view('user.profile', [
                // 'user' => $user,
                'games' => Game::getOptions(),
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

        /**
         * * Control the checkout page.
         * @param string $slug User slug.
         * @param string $type User type of Lesson.
         * @return [type]
         */
        public function checkout ($slug, $type) {
            $user = User::where('slug', '=', $slug)->with('lessons')->get()[0];
            $user->prices();
            foreach ($user->lessons as $lesson) {
                $lesson->days();
            }
            $user->days();
            foreach ($user->prices as $price) {
                if ($price->slug === $type) {
                    $type = $price;
                }
            }
            return view('user.checkout', [
                'user' => $user,
                'type' => $type,
            ]);
        }
    }