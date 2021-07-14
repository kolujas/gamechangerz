<?php
    namespace App\Http\Controllers;

    use App\Models\Coupon;
    use App\Models\Day;
    use App\Models\Game;
    use App\Models\Hour;
    use App\Models\Language;
    use App\Models\Lesson;
    use App\Models\Post;
    use App\Models\Price;
    use App\Models\User;
    use Illuminate\Http\Request;

    class PanelController extends Controller {
        /**
         * * Control the posts list panel page.
         * @return [type]
         */
        public function lessons (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            $lessons = Lesson::all();
            
            return view('panel.lesson.list', [
                'error' => $error,
                'validation' => [],
                'lessons' => $lessons
            ]);
        }

        /**
         * * Control the posts list panel page.
         * @return [type]
         */
        public function blog (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            $posts = Post::all();
            
            return view('panel.blog.list', [
                'error' => $error,
                'validation' => [],
                'posts' => $posts
            ]);
        }

        /**
         * * Control the Coupons list panel page.
         * @return [type]
         */
        public function coupons (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            $coupons = Coupons::all();

            return view('panel.coupon.list', [
                'error' => $error,
                'validation' => [],
                'coupons' => $coupons
            ]);
        }

        /**
         * * Control the coupon details panel page.
         * @param string|false [$slug=false]
         * @return [type]
         */
        public function coupon (Request $request, $slug = false) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            $coupon = Coupon::findBySlug($slug);

            return view('panel.coupon.details', [
                'error' => $error,
                'validation' => [],
                'coupons' => $coupons
            ]);
        }

        /**
         * * Control the platform details panel page.
         * @return [type]
         */
        public function platform (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            return view('panel.platform.list', [
                'error' => $error,
                'validation' => []
            ]);
        }

        /**
         * * Control the post details panel page.
         * @param string|false [$slug=false]
         * @return [type]
         */
        public function post (Request $request, $slug = false) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            $post = Post::findBySlug($slug);

            return view('panel.blog.details', [
                'error' => $error,
                'validation' => [],
                'post' => $post
            ]);
        }

        /**
         * * Control the teachers list panel page.
         * @return [type]
         */
        public function teachers (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            $users = User::allTeachers();

            return view('panel.teachers.list', [
                'error' => $error,
                'validation' => [],
                'users' => $users
            ]);
        }

        /**
         * * Control the teacher details panel page.
         * @param string|false [$slug=false]
         * @return [type]
         */
        public function teacher (Request $request, $slug = false) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            $user = new User();
            if ($slug) {
                $user = User::findBySlug($slug);
                $user->and(['games', 'languages', 'reviews', 'days', 'posts', 'prices', 'days', 'achievements']);

                foreach ($user->posts as $post) {
                    $post->date = $this->dateToHuman($post->updated_at);
                }
            }

            $games = Game::all();
            foreach ($games as $game) {
                $game->and(['abilities']);

                if ($slug) {
                    foreach ($user->games as $userGame) {
                        foreach ($userGame->abilities as $userAbility) {
                            foreach ($game->abilities as $ability) {
                                if ($ability->id_ability === $userAbility->id_ability) {
                                    $ability->checked = true;
                                }
                            }
                        }
                    }
                }
            }

            $days = Day::options();
            foreach ($days as $day) {
                $day->hours = Hour::options();

                if ($slug) {
                    foreach ($user->days as $userDay) {
                        if ($day->id_day === $userDay->id_day) {
                            $day->hours = Hour::options($userDay->hours->toArray());
                            continue 2;
                        }
                    }
                }
            }

            $achievements = collect();
            $languages = Language::options();
            $posts = collect();
            $prices = Price::options();

            if ($slug) {
                foreach ($languages as $language) {
                    foreach ($user->languages as $userLanguage) {
                        if ($language->id_language === $userLanguage->id_language) {
                            $language->checked = true;
                        }
                    }
                }

                $achievements = $user->achievements;
                $posts = $user->posts;
                $prices = $user->prices;
            }

            return view('panel.teachers.details', [
                'error' => $error,
                'validation' => [],
                'achievements' => $achievements,
                'days' => $days,
                'games' => $games,
                'languages' => $languages,
                'posts' => $posts,
                'prices' => $prices,
                'user' => $user
            ]);
        }

        /**
         * * Control the users list panel page.
         * @return [type]
         */
        public function users (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            $users = User::allUsers();

            return view('panel.users.list', [
                'error' => $error,
                'validation' => [],
                'users' => $users
            ]);
        }

        /**
         * * Control the user details panel page.
         * @param string|false [$slug=false]
         * @return [type]
         */
        public function user (Request $request, $slug = false) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            $user = User::findBySlug($slug);

            return view('panel.users.details', [
                'error' => $error,
                'validation' => [],
                'user' => $user
            ]);
        }
    }