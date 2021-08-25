<?php
    namespace App\Http\Controllers;

    use App\Http\Controllers\Panel\CouponController;
    use App\Http\Controllers\Panel\LessonController;
    use App\Http\Controllers\Panel\PlatformController;
    use App\Http\Controllers\Panel\UserController;
    use App\Models\Coupon;
    use App\Models\Day;
    use App\Models\Discord;
    use App\Models\Game;
    use App\Models\Hour;
    use App\Models\Language;
    use App\Models\Lesson;
    use App\Models\Method;
    use App\Models\Post;
    use App\Models\Platform;
    use App\Models\Price;
    use App\Models\Review;
    use App\Models\Teampro;
    use App\Models\User;
    use Carbon\Carbon;
    use Illuminate\Http\Request;

    class PanelController extends Controller {
        /**
         * * Control the platform custom banners panel page.
         * @return [type]
         */
        public function banner (Request $request) {
            $error = null;
            if ($request->session()->has("error")) {
                $error = (object) $request->session()->pull("error");
            }

            return view("panel.platform.banner", [
                "error" => $error,
                "validation" => []
            ]);
        }

        /**
         * * Control the posts list panel page.
         * @return [type]
         */
        public function blog (Request $request) {
            $error = null;
            if ($request->session()->has("error")) {
                $error = (object) $request->session()->pull("error");
            }

            $posts = Post::orderBy("updated_at", "DESC")->get();
            foreach ($posts as $post) {
                $post->and(["user"]);
            }
            
            return view("panel.blog.list", [
                "error" => $error,
                "validation" => [],
                "posts" => $posts
            ]);
        }

        /**
         * * Call the correct panel controller.
         * @param Request $request
         * @param string $section
         * @return [type]
         */
        public function call (Request $request, string $section) {
            $action = $request->route()->parameter("action");

            switch ($section) {
                case "bookings":
                    return LessonController::call($request, $section, $action);
                case "coupons":
                    return CouponController::call($request, $section, $action);
                case "banner":
                case "info":
                    return PlatformController::call($request, $section, $action);
                case "teachers":
                case "users":
                    return UserController::call($request, $section, $action);
                default:
                    dd("Call to an undefined section \"$section\"");
            }
        }

        /**
         * * Control the coupon details panel page.
         * @param string|false [$slug=false]
         * @return [type]
         */
        public function coupon (Request $request, $slug = false) {
            $error = null;
            if ($request->session()->has("error")) {
                $error = (object) $request->session()->pull("error");
            }

            $coupon = new Coupon();
            $coupon->type = (object) [
                "key" => null,
                "value" => null,
            ];
            if ($slug) {
                $coupon = Coupon::findBySlug($slug);
                $coupon->and(["type"]);
            }

            return view("panel.coupon.details", [
                "coupon" => $coupon,
                "error" => $error,
                "validation" => [
                    "coupon" => (object)[
                        "create" => (object)[
                            "rules" => Coupon::$validation["create"]["rules"],
                            "messages" => Coupon::$validation["create"]["messages"]["es"],
                        ], "update" => (object)[
                            "rules" => Coupon::$validation["update"]["rules"],
                            "messages" => Coupon::$validation["update"]["messages"]["es"],
                        ], "delete" => (object)[
                            "rules" => Coupon::$validation["delete"]["rules"],
                            "messages" => Coupon::$validation["delete"]["messages"]["es"],
            ],],],]);
        }

        /**
         * * Control the Coupons list panel page.
         * @return [type]
         */
        public function coupons (Request $request) {
            $error = null;
            if ($request->session()->has("error")) {
                $error = (object) $request->session()->pull("error");
            }

            $coupons = Coupon::orderBy("updated_at", "DESC")->get();
            foreach ($coupons as $coupon) {
                $coupon->and(["used", "type"]);
            }

            return view("panel.coupon.list", [
                "error" => $error,
                "validation" => [],
                "coupons" => $coupons
            ]);
        }

        /**
         * * Control the platform custom info panel page.
         * @return [type]
         */
        public function info (Request $request) {
            $error = null;
            if ($request->session()->has("error")) {
                $error = (object) $request->session()->pull("error");
            }

            return view("panel.platform.info", [
                "error" => $error,
                "dolar" => Platform::dolar(),
                "link" => Platform::link(),
                "validation" => []
            ]);
        }

        /**
         * * Control the posts list panel page.
         * @return [type]
         */
         public function lesson (Request $request, $id_lesson = false) {
            $error = null;
            if ($request->session()->has("error")) {
                $error = (object) $request->session()->pull("error");
            }

            $lesson = new Lesson();
            $lesson->assigments = 4;
            $lesson->users = (object)[
                "from" => new User(),
                "to" => new User(),
            ];
            $lesson->type = (object)[
                "id_type" => null
            ];
            $lesson->days = [];
            if ($id_lesson) {
                $lesson = Lesson::find($id_lesson);
                $lesson->and(["users", "type", "days", "method"]);
            }

            $hours = Hour::options();

            $teachers = collect();
            foreach (User::allTeachers() as $user) {
                if ($user->id_status === 2) {
                    $teachers->push($user);
                }
            }

            $types = Lesson::options();

            $methods = Method::options();

            $users = collect();
            foreach (User::allUsers() as $user) {
                if ($user->id_status === 2) {
                    $users->push($user);
                }
            }
            
            return view("panel.lesson.details", [
                "error" => $error,
                "hours" => $hours,
                "lesson" => $lesson,
                "methods" => $methods,
                "teachers" => $teachers,
                "types" => $types,
                "users" => $users,
                "validation" => [
                    "lesson" => (object)[
                        "create" => (object)[
                            "online" => (object)[
                                "rules" => Lesson::$validation["panel"]["create"]["online"]["rules"],
                                "messages" => Lesson::$validation["panel"]["create"]["online"]["messages"]["es"],
                            ], "offline" => (object)[
                                "rules" => Lesson::$validation["panel"]["create"]["offline"]["rules"],
                                "messages" => Lesson::$validation["panel"]["create"]["offline"]["messages"]["es"],
                            ], "packs" => (object)[
                                "rules" => Lesson::$validation["panel"]["create"]["packs"]["rules"],
                                "messages" => Lesson::$validation["panel"]["create"]["packs"]["messages"]["es"],
                        ],], "delete" => (object)[
                            "rules" => Lesson::$validation["panel"]["delete"]["rules"],
                            "messages" => Lesson::$validation["panel"]["delete"]["messages"]["es"],
            ],],],]);
        }

        /**
         * * Control the posts list panel page.
         * @return [type]
         */
        public function lessons (Request $request) {
            $error = null;
            if ($request->session()->has("error")) {
                $error = (object) $request->session()->pull("error");
            }

            $lessons = Lesson::orderBy("updated_at", "DESC")->get();
            foreach ($lessons as $lesson) {
                $lesson->and(["users", "type", "ended_at", "method"]);
            }
            
            return view("panel.lesson.list", [
                "error" => $error,
                "validation" => [],
                "lessons" => $lessons
            ]);
        }

        /**
         * * Control the teacher details panel page.
         * @param string|false [$slug=false]
         * @return [type]
         */
        public function teacher (Request $request, $slug = false) {
            $error = null;
            if ($request->session()->has("error")) {
                $error = (object) $request->session()->pull("error");
            }

            $user = new User();
            $teampro = new Teampro();
            if ($slug) {
                $user = User::findBySlug($slug);
                $user->and(["games", "languages", "lessons", "reviews", "days", "posts", "prices", "days", "achievements", "files", "teampro", "credentials"]);
                $teampro = $user->teampro;

                foreach ($user->posts as $post) {
                    $post->date = $this->dateToHuman($post->updated_at);
                }
            }

            $games = Game::all();
            foreach ($games as $game) {
                $game->and(["abilities"]);

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
                    if ($lesson->id_status >= 3) {
                        $lesson->and(["reviews", "abilities"]);

                        $found = false;
                        if (count($lesson->reviews)) {
                            foreach ($lesson->reviews as $review) {
                                if ($review->id_user_to === $user->id_user) {
                                    $review->and(["abilities"]);

                                    $found = true;
                                    break;
                                }
                            }
                        }

                        if ($found) {
                            $lesson->and(["ended_at"]);
        
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

            return view("panel.teachers.details", [
                "achievements" => $achievements,
                "days" => $days,
                "error" => $error,
                "games" => $games,
                "languages" => $languages,
                "lessons" => $lessons,
                "posts" => $posts,
                "prices" => $prices,
                "reviews" => $reviews,
                "teampro" => $teampro,
                "user" => $user,
                "validation" => [
                    "teacher" => (object)[
                        "create" => (object)[
                            "rules" => $this->replaceUnique(User::$validation["teacher"]["panel"]["create"]["rules"], PLatform::dolar() / 2),
                            "messages" => User::$validation["teacher"]["panel"]["create"]["messages"]["es"],
                        ], "update" => (object)[
                            "rules" => $this->replaceUnique(User::$validation["teacher"]["panel"]["update"]["rules"], PLatform::dolar() / 2),
                            "messages" => User::$validation["teacher"]["panel"]["update"]["messages"]["es"],
                        ], "delete" => (object)[
                            "rules" => User::$validation["teacher"]["panel"]["delete"]["rules"],
                            "messages" => User::$validation["teacher"]["panel"]["delete"]["messages"]["es"],
                    ],], "review" => (object)[
                        "rules" => Review::$validation["create"]["rules"],
                        "messages" => Review::$validation["create"]["messages"]["es"],
            ],],]);
        }

        /**
         * * Control the teachers list panel page.
         * @return [type]
         */
        public function teachers (Request $request) {
            $error = null;
            if ($request->session()->has("error")) {
                $error = (object) $request->session()->pull("error");
            }

            $users = User::allTeachers();

            return view("panel.teachers.list", [
                "error" => $error,
                "validation" => [],
                "users" => $users
            ]);
        }

        /**
         * * Control the user details panel page.
         * @param string|false [$slug=false]
         * @return [type]
         */
        public function user (Request $request, $slug = false) {
            $error = null;
            if ($request->session()->has("error")) {
                $error = (object) $request->session()->pull("error");
            }

            $user = new User();
            if ($slug) {
                $user = User::findBySlug($slug);
                $user->and(["games", "reviews", "achievements", "files", "languages"]);
            }

            $games = Game::all();
            foreach ($games as $game) {
                $game->and(["abilities"]);

                if ($slug) {
                    $game->active = false;
                    foreach ($user->games as $userGame) {
                        if ($userGame->id_game === $game->id_game) {
                            $game->active = true;
                        }
                    }
                }
            }

            $achievements = collect();
            $languages = Language::options();
            $lessons = collect();
            $reviews = collect();

            if ($slug) {
                foreach ($languages as $language) {
                    foreach ($user->languages as $userLanguage) {
                        if ($language->id_language === $userLanguage->id_language) {
                            $language->checked = true;
                        }
                    }
                }

                foreach (Lesson::allDoneFromUser($user->id_user) as $lesson) {
                    if ($lesson->id_status >= 3) {
                        $lesson->and(["reviews", "abilities"]);

                        $found = false;
                        if (count($lesson->reviews)) {
                            foreach ($lesson->reviews as $review) {
                                if ($review->id_user_to === $user->id_user) {
                                    $review->and(["abilities"]);

                                    $found = true;
                                    break;
                                }
                            }
                        }

                        if ($found) {
                            $lesson->and(["ended_at"]);
        
                            if (Carbon::now() > $lesson->ended_at) {
                                $lessons->push($lesson);
                            }
                        }
                    }
                }

                $achievements = $user->achievements;
                $reviews = $user->reviews;
            }

            return view("panel.users.details", [
                "achievements" => $achievements,
                "error" => $error,
                "games" => $games,
                "languages" => $languages,
                "lessons" => $lessons,
                "reviews" => $reviews,
                "user" => $user,
                "validation" => [
                    "user" => (object)[
                        "create" => (object)[
                            "rules" => User::$validation["user"]["panel"]["create"]["rules"],
                            "messages" => User::$validation["user"]["panel"]["create"]["messages"]["es"],
                        ], "update" => (object)[
                            "rules" => User::$validation["user"]["panel"]["update"]["rules"],
                            "messages" => User::$validation["user"]["panel"]["update"]["messages"]["es"],
                        ], "delete" => (object)[
                            "rules" => User::$validation["user"]["panel"]["delete"]["rules"],
                            "messages" => User::$validation["user"]["panel"]["delete"]["messages"]["es"],
                    ],], "review" => (object)[
                        "rules" => Review::$validation["create"]["rules"],
                        "messages" => Review::$validation["create"]["messages"]["es"],
            ],],]);
        }

        /**
         * * Control the users list panel page.
         * @return [type]
         */
        public function users (Request $request) {
            $error = null;
            if ($request->session()->has("error")) {
                $error = (object) $request->session()->pull("error");
            }

            $users = User::allUsers();

            return view("panel.users.list", [
                "error" => $error,
                "users" => $users,
                "validation" => [],
            ]);
        }
    }