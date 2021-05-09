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
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }
            $user = User::where('slug', '=', $slug)->with('reviews', 'posts')->get()[0];
            $user->and(['achievements', 'games', 'role']);
            if ($user->id_role === 2) {
                if (!Auth::check()) {
                    $request->session()->put('error', [
                        'code' => 404,
                        'message' => "User \"$slug\" does not exist",
                    ]);
                    return redirect()->back();
                }
                return redirect('/panel');
            }
            if ($user->id_role === 1) {
                $user->and(['abilities', 'files', 'languages', 'prices', 'teampro', 'days']);
                $days = Day::allDates($user->days);
            }
            if ($user->id_role === 0) {
                $user->and(['friends', 'lessons', 'hours']);
                $days = [];
            }
            foreach ($user->reviews as $review) {
                $review->and(['abilities', 'lesson', 'users']);
                $review->users['from']->and(['teampro', 'files']);
                if ($user->id_role === 0) {
                    $review->and(['game']);
                }
                foreach ($review->abilities as $review_ability) {
                    $review->stars = (isset($review->stars) ? $review->stars : 0) + $review_ability->stars;
                    if ($user->id_role === 1) {
                        foreach ($user->abilities as $user_ability) {
                            if ($user_ability->id_ability === $review_ability->id_ability) {
                                $user_ability->stars = $user_ability->stars + $review_ability->stars;
                            }
                        }
                    }
                    if ($user->id_role === 0) {
                        foreach ($user->games as $game) {
                            foreach ($game->abilities as $ability) {
                                if ($ability->id_ability === $review_ability->id_ability) {
                                    $ability->stars = $ability->stars + $review_ability->stars;
                                }
                            }
                        }
                    }
                }
                if (count($review->abilities)) {
                    $review->stars = $review->stars / count($review->abilities);
                }
            }
            if ($user->id_role === 1) {
                if (count($user->reviews)) {
                    foreach ($user->abilities as $ability) {
                        $ability->stars = $ability->stars / count($user->reviews);
                    }
                }
            }
            if ($user->id_role === 0) {
                $user->friends_length = 0;
                foreach ($user->friends as $friend) {
                    $friend->and(['users']);
                    if ($friend->accepted) {
                        $user->friends_length++;
                    }
                }
                if (count($user->reviews)) {
                    foreach ($user->games as $game) {
                        foreach ($game->abilities as $ability) {
                            $ability->stars = $ability->stars / count($user->reviews);
                        }
                    }
                }
            }
            if (Auth::check()) {
                if (Auth::user()->slug !== $user->slug && $user->id_role === 0) {
                    $user->isFriend = 0;
                    foreach ($user->friends as $friend) {
                        if ($friend->id_user_from === Auth::user()->id_user || $friend->id_user_to === Auth::user()->id_user) {
                            if ($friend->accepted) {
                                $user->isFriend = 2;
                            }
                            if (!$friend->accepted) {
                                $user->isFriend = 1;
                                $user->id_user_request = $friend->id_user_from;
                            }
                        }
                    }
                }
            }
            foreach ($user->posts as $post) {
                $post->date = $this->dateToHuman($post->updated_at);
            }
            return view('user.profile', [
                'user' => $user,
                'days' => $days,
                'error' => $error,
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
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }
            if (\Request::is('users')) {
                $users = User::where('id_role', '=', 0)->limit(10)->get();
            }
            if (\Request::is('teachers')) {
                $users = User::where('id_role', '=', 1)->limit(10)->orderBy('important', 'DESC')->orderBy('updated_at', 'DESC')->get();
            }
            foreach ($users as $user) {
                $user->and(['games']);  
                if ($user->id_role === 1) {
                    $user->and(['abilities', 'days', 'files', 'languages', 'prices', 'teampro']);
                    $days = Day::allDates($user->days);
                }
                if ($user->id_role === 0) {
                    $user->and(['friends', 'lessons', 'hours']);
                    $days = [];
                }
            }
            return view('user.search', [
                'users' => $users,
                'error' => $error,
                'search' => (object)[
                    'username' => $request->username,
                ],
                'validation' => [],
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
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }
            $user = User::where('slug', '=', $slug)->get()[0];
            $user->and(['lessons', 'prices', 'days']);
            foreach ($user->lessons as $lesson) {
                $lesson->and(['days']);
            }
            foreach ($user->prices as $price) {
                if ($price->slug === $type) {
                    $type = $price;
                }
            }
            return view('user.checkout', [
                'user' => $user,
                'type' => $type,
                'error' => $error,
                'validation' => [
                    //
                ],
            ]);
        }
    }



// TODO teampro cargado por el profe, dificultad habilidad profe, opacidad habilidades nula (se da vuelta la card, packs profe = online), pack valor no automatico