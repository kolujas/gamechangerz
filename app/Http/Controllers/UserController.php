<?php
    namespace App\Http\Controllers;

    use App\Models\Ability;
    use App\Models\Day;
    use App\Models\Game;
    use App\Models\Lesson;
    use App\Models\Post;
    use App\Models\User;
    use Auth;
    use Illuminate\Http\Request;

    class UserController extends Controller {
        /**
         * * Control the User profile page.
         * @param string $slug User slug.
         * @return [type]
         */
        public function profile ($slug) {
            $user = User::where('slug', '=', $slug)->with('reviews', 'posts')->get()[0];
            $user->abilities();
            $user->achievements();
            $user->files();
            $user->games();
            $user->idioms();
            if ($user->id_role >= 1) {
                $user->days();
                $user->prices();
            }
            $user->role();
            $user->teampro();
            $user->game_abilities = collect([]);
            foreach ($user->games as $game) {
                $abilities = Ability::parse($game->abilities);
                foreach ($abilities as $ability) {
                    $user->game_abilities->push($ability);
                }
            }
            foreach ($user->posts as $post) {
                $post->date = $this->dateToHuman($post->updated_at);
            }
            $days = Day::allDates($user->days);
            return view('user.profile', [
                'user' => $user,
                'days' => $days,
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