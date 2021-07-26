<?php
    namespace App\Http\Controllers;

    use App\Http\Controllers\Panel\UserController;
    use App\Models\Coupon;
    use App\Models\Day;
    use App\Models\Game;
    use App\Models\Hour;
    use App\Models\Language;
    use App\Models\Lesson;
    use App\Models\Post;
    use App\Models\Price;
    use App\Models\Review;
    use App\Models\Teampro;
    use App\Models\User;
    use Carbon\Carbon;
    use Illuminate\Http\Request;

    class PanelController extends Controller {
        /**
         * * Control the platform details panel page.
         * @return [type]
         */
        public function banner (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            return view('panel.platform.banner', [
                'error' => $error,
                'validation' => []
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
            foreach ($posts as $post) {
                $post->and(['user']);
            }
            
            return view('panel.blog.list', [
                'error' => $error,
                'validation' => [],
                'posts' => $posts
            ]);
        }

        public function call (Request $request, string $section) {
            $action = $request->route()->parameter("action");

            switch ($section) {
                case 'teachers':
                    return UserController::call($request, $section, $action);
            }
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

            // $coupon = Coupon::findBySlug($slug);
            $coupon = false;

            return view('panel.coupon.details', [
                'error' => $error,
                'coupon' => $coupon,
                'validation' => [
                    'coupon' => (object)[
                        'create' => (object)[
                            'rules' => Coupon::$validation['create']['rules'],
                            'messages' => Coupon::$validation['create']['messages']['es'],
                        ],
                        'update' => (object)[
                            'rules' => Coupon::$validation['update']['rules'],
                            'messages' => Coupon::$validation['update']['messages']['es'],
                        ],
                        'delete' => (object)[
                            'rules' => Coupon::$validation['delete']['rules'],
                            'messages' => Coupon::$validation['update']['messages']['es'],
                        ],
                    ],
                ],
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

            $coupons = Coupon::all();

            return view('panel.coupon.list', [
                'error' => $error,
                'validation' => [],
                'coupons' => $coupons
            ]);
        }

        public function dolar (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            return view('panel.platform.dolar', [
                'error' => $error,
                'validation' => []
            ]);
        }

        /**
         * * Control the posts list panel page.
         * @return [type]
         */
        public function lesson (Request $request, $slug = false) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            $lesson = Lesson::all();
            
            return view('panel.lesson.list', [
                'error' => $error,
                'lesson' => $lesson,
                'validation' => [
                    'lesson' => (object)[
                        'create' => (object)[
                            'rules' => Lesson::$validation['create']['rules'],
                            'messages' => Lesson::$validation['create']['messages']['es'],
                        ],
                        'update' => (object)[
                            'rules' => Lesson::$validation['update']['rules'],
                            'messages' => Lesson::$validation['update']['messages']['es'],
                        ],
                        'delete' => (object)[
                            'rules' => Lesson::$validation['delete']['rules'],
                            'messages' => Lesson::$validation['update']['messages']['es'],
                        ],
                    ],
                ],
            ]);
        }

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
            $teampro = new Teampro();
            if ($slug) {
                $user = User::findBySlug($slug);
                $user->and(['games', 'languages', 'lessons', 'reviews', 'days', 'posts', 'prices', 'days', 'achievements', 'files', 'teampro']);
                $teampro = $user->teampro;

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
            $lessons = collect();
            $posts = collect();
            $prices = Price::options();
            $reviews = collect();

            if ($slug) {
                foreach ($languages as $language) {
                    foreach ($user->languages as $userLanguage) {
                        if ($language->id_language === $userLanguage->id_language) {
                            $language->checked = true;
                        }
                    }
                }

                foreach (Lesson::allFromTeacher($user->id_user) as $lesson) {
                    if ($lesson->status >= 3) {
                        $lesson->and(['reviews', 'abilities']);

                        $found = false;
                        if (count($lesson->reviews)) {
                            foreach ($lesson->reviews as $review) {
                                if ($review->id_user_to === $user->id_user) {
                                    $review->and(['abilities']);

                                    $found = true;
                                    break;
                                }
                            }
                        }

                        if ($found) {
                            $lesson->and(['ended_at']);
        
                            if (Carbon::now() > $lesson->ended_at) {
                                $lessons->push($lesson);
                            }
                        }
                    }
                }

                $achievements = $user->achievements;
                $posts = $user->posts;
                $prices = $user->prices;
                $reviews = $user->reviews;
            }

            return view('panel.teachers.details', [
                'error' => $error,
                'achievements' => $achievements,
                'days' => $days,
                'games' => $games,
                'languages' => $languages,
                'lessons' => $lessons,
                'posts' => $posts,
                'prices' => $prices,
                'reviews' => $reviews,
                'teampro' => $teampro,
                'user' => $user,
                'validation' => [
                    'teacher' => (object)[
                        'create' => (object)[
                            'rules' => User::$validation['teacher']['panel']['create']['rules'],
                            'messages' => User::$validation['teacher']['panel']['create']['messages']['es'],
                        ],
                        'update' => (object)[
                            'rules' => User::$validation['teacher']['panel']['update']['rules'],
                            'messages' => User::$validation['teacher']['panel']['update']['messages']['es'],
                        ],
                        'delete' => (object)[
                            'rules' => User::$validation['teacher']['panel']['delete']['rules'],
                            'messages' => User::$validation['teacher']['panel']['delete']['messages']['es'],
                        ],
                    ],
                    'review' => (object)[
                        'rules' => Review::$validation['create']['rules'],
                        'messages' => Review::$validation['create']['messages']['es'],
                    ],
                ],
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
            $user->and(['games', 'reviews', 'achievements','files']);

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

            $achievements = collect();

            if ($slug) {  
                $achievements = $user->achievements;
            }

            return view('panel.users.details', [
                'error' => $error,
                'user' => $user,
                'games' => $games,
                'achievements' => $achievements,
                'validation' => [
                    'user' => (object)[
                        'create' => (object)[
                            'rules' => User::$validation['user']['panel']['create']['rules'],
                            'messages' => User::$validation['create']['panel']['messages']['es'],
                        ],
                        'update' => (object)[
                            'rules' => User::$validation['user']['panel']['update']['rules'],
                            'messages' => User::$validation['user']['panel']['update']['messages']['es'],
                        ],
                        'delete' => (object)[
                            'rules' => User::$validation['user']['panel']['delete']['rules'],
                            'messages' => User::$validation['user']['panel']['update']['messages']['es'],
                        ],
                    ],
                ],
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
                'users' => $users,
                'validation' => [],
            ]);
        }
    }