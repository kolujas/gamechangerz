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
         * @return \Illuminate\Http\Response
         */
        public function banner (Request $request) {
            return view("panel.platform.banner", [
                // ?
            ]);
        }

        /**
         * * Control the posts list panel page.
         * @return \Illuminate\Http\Response
         */
        public function blog (Request $request) {
            $posts = Post::orderBy("updated_at", "DESC")->get();
            foreach ($posts as $post) {
                $post->and(["user"]);
            }
            
            return view("panel.blog.list", [
                "posts" => $posts
            ]);
        }

        /**
         * * Call the correct panel controller.
         * @param  \Illuminate\Http\Request  $request
         * @param string $section
         * @return \Illuminate\Http\Response
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
                case "coaches":
                case "users":
                    return UserController::call($request, $section, $action);
                default:
                    dd("Call to an undefined section \"$section\"");
            }
        }

        /**
         * * Control the coupon details panel page.
         * @param string|false [$slug=false]
         * @return \Illuminate\Http\Response
         */
        public function coupon (Request $request, $slug = false) {
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
            ]);
        }

        /**
         * * Control the Coupons list panel page.
         * @return \Illuminate\Http\Response
         */
        public function coupons (Request $request) {
            $coupons = Coupon::orderBy("updated_at", "DESC")->get();
            foreach ($coupons as $coupon) {
                $coupon->and(["used", "type"]);
            }

            return view("panel.coupon.list", [
                "coupons" => $coupons
            ]);
        }

        /**
         * * Control the platform custom info panel page.
         * @return \Illuminate\Http\Response
         */
        public function info (Request $request) {
            return view("panel.platform.info", [
                "dolar" => Platform::dolar(),
                "link" => Platform::link(),
            ]);
        }

        /**
         * * Control the posts list panel page.
         * @return \Illuminate\Http\Response
         */
         public function lesson (Request $request, $id_lesson = false) {
            $lesson = new Lesson();
            $lesson->assignments = 4;
            $lesson->users = (object)[
                "from" => new User(),
                "to" => new User(),
            ];
            $lesson->type = (object)[
                "id_type" => null
            ];
            $lesson->days = [];
            $price = null;
            if ($id_lesson) {
                $lesson = Lesson::find($id_lesson);
                $lesson->and(["users", "type", "days", "method", "price"]);
                $price = $lesson->price;
            }

            $hours = Hour::options();

            $coaches = collect();
            foreach (User::coaches()->orderBy('updated_at', 'DESC')->get() as $user) {
                if ($user->id_status === 2) {
                    $coaches->push($user);
                }
            }

            $types = Lesson::options();

            $methods = Method::options();

            $users = collect();
            foreach (User::users()->orderBy('updated_at', 'DESC')->get() as $user) {
                if ($user->id_status === 2) {
                    $users->push($user);
                }
            }
            
            return view("panel.lesson.details", [
                "price" => $price,
                "hours" => $hours,
                "lesson" => $lesson,
                "methods" => $methods,
                "coaches" => $coaches,
                "types" => $types,
                "users" => $users,
            ]);
        }

        /**
         * * Control the posts list panel page.
         * @return \Illuminate\Http\Response
         */
        public function lessons (Request $request) {
            $lessons = Lesson::orderBy("updated_at", "DESC")->get();
            foreach ($lessons as $lesson) {
                $lesson->and(["users", "type", "ended_at", "method"]);
            }
            
            return view("panel.lesson.list", [
                "lessons" => $lessons
            ]);
        }

        /**
         * * Control the coach details panel page.
         * @param string|false [$slug=false]
         * @return \Illuminate\Http\Response
         */
        public function coach (Request $request, $slug = false) {
            $user = new User();
            $teampro = new Teampro();
            if ($slug) {
                $user = User::bySlug($slug)->first();
                $user->and(["games", "languages", "lessons", "reviews", "days", "posts", "prices", "days", "achievements", "teampro", "credentials"]);
                $user->files = $user->files;
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

                foreach (Lesson::byCoach($user->id_user)->get() as $lesson) {
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

            return view("panel.coaches.details", [
                "achievements" => $achievements,
                "days" => $days,
                "games" => $games,
                "languages" => $languages,
                "lessons" => $lessons,
                "posts" => $posts,
                "prices" => $prices,
                "reviews" => $reviews,
                "teampro" => $teampro,
                "user" => $user,
                "minPrice" => floatval(Platform::dolar() / 2),
            ]);
        }

        /**
         * * Control the coaches list panel page.
         * @return \Illuminate\Http\Response
         */
        public function coaches (Request $request) {
            $users = User::coaches()->orderBy('updated_at', 'DESC')->get();

            return view("panel.coaches.list", [
                "users" => $users
            ]);
        }

        /**
         * * Control the user details panel page.
         * @param string|false [$slug=false]
         * @return \Illuminate\Http\Response
         */
        public function user (Request $request, $slug = false) {
            $user = new User();
            if ($slug) {
                $user = User::bySlug($slug)->first();
                $user->and(["games", "reviews", "achievements", "languages"]);
                $user->files = $user->files;
            }

            $games = Game::all();
            foreach ($games as $game) {
                $game->and(["abilities"]);

                if ($slug) {
                    $game->active = false;
                    if (is_array($user->games) && count($user->games)) {
                        foreach ($user->games as $userGame) {
                            if ($userGame->id_game === $game->id_game) {
                                $game->active = true;
                            }
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

                foreach (Lesson::doneByUser($user->id_user)->get() as $lesson) {
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
                "games" => $games,
                "languages" => $languages,
                "lessons" => $lessons,
                "reviews" => $reviews,
                "user" => $user,
            ]);
        }

        /**
         * * Control the users list panel page.
         * @return \Illuminate\Http\Response
         */
        public function users (Request $request) {
            $users = User::users()->orderBy('updated_at', 'DESC')->get();

            return view("panel.users.list", [
                "users" => $users,
            ]);
        }
    }