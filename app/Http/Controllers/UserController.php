<?php
    namespace App\Http\Controllers;

    use App\Models\Ability;
    use App\Models\Auth as AuthModel;
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
        public function profile (Request $request, $slug) {
            $error = null;
            if($request->session()->has('error')){
                $error = (object) $request->session()->pull('error');
                dd($error);
            }
            $user = User::where('slug', '=', $slug)->with('reviews', 'posts')->get()[0];
            $user->abilities();
            foreach ($user->reviews as $review) {
                $review->abilities();
                foreach ($review->abilities as $review_ability) {
                    $review->stars = (isset($review->stars) ? $review->stars : 0) + $review_ability->stars;
                    foreach ($user->abilities as $user_ability) {
                        if ($user_ability->id_ability === $review_ability->id_ability) {
                            $user_ability->stars = $user_ability->stars + $review_ability->stars;
                        }
                    }
                }
                if (count($review->abilities)) {
                    $review->stars = $review->stars / count($review->abilities);
                }
            }
            if (count($user->reviews)) {
                foreach ($user->abilities as $ability) {
                    $ability->stars = $ability->stars / count($user->reviews);
                }
            }
            $user->achievements();
            $user->files();
            $user->games();
            $user->idioms();
            $days = [];
            if ($user->id_role >= 1) {
                $user->days();
                $user->prices();
                $days = Day::allDates($user->days);
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
            return view('user.profile', [
                'user' => $user,
                'days' => $days,
                'validation' => [
                    'login' => (object)[
                        'rules' => AuthModel::$validation['login']['rules'],
                        'messages' => AuthModel::$validation['login']['messages']['es'],
                ]],
            ]);
        }

        /**
         * * Control the User search page.
         * @return [type]
         */
        public function search (Request $request) {
            $error = null;
            if($request->session()->has('error')){
                $error = (object) $request->session()->pull('error');
                dd($error);
            }
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
        public function checkout (Request $request, $slug, $type) {
            $error = null;
            if($request->session()->has('error')){
                $error = (object) $request->session()->pull('error');
                dd($error);
            }
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
                'validation' => [
                    //
                ],
            ]);
        }
    }