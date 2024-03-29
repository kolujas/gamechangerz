<?php
    use App\Http\Controllers\AchievementController;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\BlogController;
    use App\Http\Controllers\CheckoutController;
    use App\Http\Controllers\Controller;
    use App\Http\Controllers\PanelController;
    use App\Http\Controllers\FriendshipController;
    use App\Http\Controllers\GameController;
    use App\Http\Controllers\GoogleController;
    use App\Http\Controllers\LanguageController;
    use App\Http\Controllers\ReviewController;
    use App\Http\Controllers\UserController;
    use Illuminate\Support\Facades\Route;

// ! AuthController - Controls the authentication pages.
    Route::middleware("auth.status")->group(function () {
        Route::post("/login", [AuthController::class, "login"])->name("auth.login");
        Route::post("/signin", [AuthController::class, "signin"])->name("auth.signin");
        Route::post("/change-password", [AuthController::class, "changePassword"])->name("auth.changePassword");
        Route::get("/password/{token}/reset", [AuthController::class, "showResetPassword"])->name("auth.showResetPassword");
        Route::post("/password/{token}/reset", [AuthController::class, "doResetPassword"])->name("auth.doResetPassword");
        Route::middleware("token.exist")->group(function () {
            Route::get("/email/{token}/confirm", [AuthController::class, "confirm"])->name("auth.confirm");
        });
        Route::middleware("auth.custom")->group(function () {
            Route::get("/logout", [AuthController::class, "logout"])->name("auth.logout");
        });
        
// ! Controller - Controls the web in general.
        Route::get("/coming-soon", [Controller::class, "comingSoon"])->name("web.coming_soon");
        Route::get("/", [Controller::class, "index"])->name("web.index");
        Route::middleware(["game.exist", "game.is.active"])->group(function () {
            Route::get("/games/{slug}", [Controller::class, "landing"])->name("web.landing");
        });
        Route::get("/home", [Controller::class, "home"])->name("web.home");
        Route::get("/privacy-politics", [Controller::class, "privacyPolitics"])->name("web.privacy_politics");
        Route::get("/terms-&-conditions", [Controller::class, "termsAndConditions"])->name("web.terms_&_conditions");
        Route::get("/faq", [Controller::class, "faq"])->name("web.faq");
        Route::get("/contact", [Controller::class, "contact"])->name("web.contact");
        Route::post("/contact", [Controller::class, "sendContact"])->name("web.sendContact");
        Route::get("/support", [Controller::class, "support"])->name("web.support");
        Route::post("/support", [Controller::class, "sendSupport"])->name("web.sendSupport");
        Route::get("/apply", [Controller::class, "apply"])->name("web.apply");
            
// ! BlogController - Controls the Blog pages.
        Route::get("/blog", [BlogController::class, "list"])->name("blog.list");
        Route::middleware(["auth.custom", "auth.role.not.user", "user.exist", "auth.is.user"])->group(function () {
            Route::get("/blog/{user}/create", [BlogController::class, "details"])->name("blog.showCreate");
            Route::post("/blog/{user}/create", [BlogController::class, "do"])->name("blog.doCreate");
            Route::middleware(["post.exist", "post.action.exist"])->group(function () {
                Route::post("/blog/{user}/{post}/{action}", [BlogController::class, "do"])->name("blog.do");
            });
        });
        Route::middleware(["user.exist", "user.status"])->group(function () {
            Route::middleware("post.exist")->group(function () {
                Route::get("/blog/{user}/{post}", [BlogController::class, "details"])->name("blog.details");
            });

// ! FriendshipController - Controls the User Friends.
            Route::middleware("friendship.action.exist")->group(function () {
                Route::get("/users/{slug}/friendship/{action}", [FriendshipController::class, "call"])->name("friendship.call");
            });
        });
            
// ! CheckoutController - Controls the Checkout pages.
        Route::get("/mercadopago/authorization", [CheckoutController::class, "authorization"])->name("checkout.authorization");

        Route::middleware("auth.custom")->group(function () {
            Route::middleware("auth.not.user")->group(function () {
                Route::middleware("lesson.exist")->group(function () {
                    Route::post("/lessons/{id_lesson}/checkout/{type}", [CheckoutController::class, "complete"])->name("checkout.complete");
                });

                Route::middleware(["user.exist", "user.status", "auth.role.is.user", "user.is.coach", "lesson.type.exist", "auth.lesson.current.not.exist"])->group(function () {
                    Route::get("/users/{slug}/checkout/{type}", [CheckoutController::class, "show"])->name("checkout.show");
                });
            });
            Route::middleware(["lesson.exist", "lesson.status.exist", "auth.is.lesson.member"])->group(function () {
                Route::get("/lessons/{id_lesson}/checkout/{id_status}", [CheckoutController::class, "status"])->name("checkout.status");
            });
        });
        Route::post("/lessons/notifications/{id_lesson}/{type}", [CheckoutController::class, "notification"])->name("checkout.notification");
        
// ! ReviewController - Controls the Review pages.
        Route::middleware(["auth.custom"])->group(function () {
            Route::middleware("lesson.exist", "auth.is.lesson.member")->group(function () {
                Route::post("/lessons/{id_lesson}/review/create", [ReviewController::class, "create"])->name("review.create");
            });
            Route::middleware("review.exist")->group(function () {
                Route::put("/reviews/{id_review}/{id_user}/update", [ReviewController::class, "update"])->name("review.update");
            });
        });

// ! UserController - Controls the User pages.
        Route::post("/apply", [UserController::class, "apply"])->name("user.apply");
        
        Route::get("/users", [UserController::class, "search"])->name("user.searchUsers");
        Route::get("/coaches", [UserController::class, "search"])->name("user.searchCoaches");
        Route::middleware(["user.exist", "user.status"])->group(function () {
            Route::middleware("auth.lesson.end")->group(function () {
                Route::get("/users/{slug}/profile", [UserController::class, "profile"])->name("user.profile");
            });
        });
        Route::middleware(["auth.custom", "auth.is.user"])->group(function () {
            Route::post("/users/{slug}/update", [UserController::class, "update"])->name("user.update");

            Route::post("/users/{slug}/hours/update", [UserController::class, "hours"])->name("user.hours");

            Route::post("/users/{slug}/credentials/update", [UserController::class, "credentials"])->name("user.credentials");

// ! AchievementController - Controls the Achievement pages.
            Route::post("/users/{slug}/achievements/update", [AchievementController::class, "update"])->name("achievement.update");

// ! GameController - Controls the Game pages.
            Route::post("/users/{slug}/games/update", [GameController::class, "update"])->name("game.update");

// ! LanguageController - Controls the Language pages.
            Route::post("/users/{slug}/languages/update", [LanguageController::class, "update"])->name("language.update");
        });

// ! PanelController - Controls the panel in general.
        Route::middleware(["auth.custom", "auth.role.is.admin"])->group(function () {
            Route::get("/panel", [PanelController::class, "blog"])->name("panel.blog");
            Route::get("/panel/blog", [PanelController::class, "blog"])->name("panel.blog");
            Route::get("/panel/platform", [PanelController::class, "banner"])->name("panel.platform");
            Route::get("/panel/platform/banner", [PanelController::class, "banner"])->name("panel.banner");
            Route::get("/panel/platform/info", [PanelController::class, "info"])->name("panel.info");
            Route::get("/panel/coaches", [PanelController::class, "coaches"])->name("panel.coaches");
            Route::get("/panel/coaches/create", [PanelController::class, "coach"])->name("panel.showCreateCoach");
            Route::middleware("user.exist")->group(function () {
                Route::get("/panel/coaches/{slug}", [PanelController::class, "coach"])->name("panel.coach");
            });
            Route::get("/panel/users", [PanelController::class, "users"])->name("panel.users");
            Route::get("/panel/users/create", [PanelController::class, "user"])->name("panel.showCreateUser");
            Route::middleware("user.exist")->group(function () {
                Route::get("/panel/users/{slug}", [PanelController::class, "user"])->name("panel.user");
            });
            Route::get("/panel/coupons", [PanelController::class, "coupons"])->name("panel.coupons");
            Route::get("/panel/coupons/create", [PanelController::class, "coupon"])->name("panel.showCreateCoupon");
            // Route::middleware("coupon.exist")->group(function () {
                Route::get("/panel/coupons/{slug}", [PanelController::class, "coupon"])->name("panel.coupon");
            // });
            Route::get("/panel/bookings", [PanelController::class, "lessons"])->name("panel.lessons");
            Route::get("/panel/bookings/create", [PanelController::class, "lesson"])->name("panel.showCreate");
            // Route::middleware("lesson.exist")->group(function () {
                Route::get("/panel/bookings/{id_lesson}", [PanelController::class, "lesson"])->name("panel.lesson");
            // });

            // TODO: Middlewares
            Route::post("/panel/{section}/{action}", [PanelController::class, "call"])->name("panel.section.doCreate");
            Route::put("/panel/{section}/{slug}/{action}", [PanelController::class, "call"])->name("panel.section.doUpdate");
            Route::delete("/panel/{section}/{slug}/{action}", [PanelController::class, "call"])->name("panel.section.doDelete");
        });
    });