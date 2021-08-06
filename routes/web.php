<?php
    use App\Http\Controllers\AchievementController;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\BlogController;
    use App\Http\Controllers\CheckoutController;
    use App\Http\Controllers\DefaultController;
    use App\Http\Controllers\PanelController;
    use App\Http\Controllers\FriendshipController;
    use App\Http\Controllers\GameController;
    use App\Http\Controllers\GoogleController;
    use App\Http\Controllers\LanguageController;
    use App\Http\Controllers\ReviewController;
    use App\Http\Controllers\UserController;
    use Illuminate\Support\Facades\Route;

// ! AuthController - Controls the authentication pages.
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/signin', [AuthController::class, 'signin'])->name('auth.signin');
    Route::middleware('token.exist')->group(function () {
        Route::get('/email/{token}/confirm', [AuthController::class, 'confirm'])->name('auth.confirm');
    });
    Route::middleware('auth.custom')->group(function () {
        Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    });
    
// ! DefaultController - Controls the web in general.
    Route::get('/coming-soon', [DefaultController::class, 'comingSoon'])->name('web.coming_soon');
    Route::get('/', [DefaultController::class, 'index'])->name('web.index');
    Route::middleware(['game.exist', 'game.is.active'])->group(function () {
        Route::get('/games/{slug}', [DefaultController::class, 'landing'])->name('web.landing');
    });
    Route::get('/home', [DefaultController::class, 'home'])->name('web.home');
    Route::get('/privacy-politics', [DefaultController::class, 'privacyPolitics'])->name('web.privacy_politics');
    Route::get('/terms-&-conditions', [DefaultController::class, 'termsAndConditions'])->name('web.terms_&_conditions');
    Route::get('/faq', [DefaultController::class, 'faq'])->name('web.faq');
    Route::get('/apply', [DefaultController::class, 'apply'])->name('web.apply');
        
// ! BlogController - Controls the Blog pages.
    Route::get('/blog', [BlogController::class, 'list'])->name('blog.list');
    Route::middleware(['auth.custom', 'auth.role.not.user', 'user.exist', 'auth.is.user'])->group(function () {
        Route::get('/blog/{user}/create', [BlogController::class, 'details'])->name('blog.showCreate');
        Route::post('/blog/{user}/create', [BlogController::class, 'do'])->name('blog.doCreate');
        Route::middleware(['post.exist', 'post.action.exist'])->group(function () {
            Route::post('/blog/{user}/{post}/{action}', [BlogController::class, 'do'])->name('blog.do');
        });
    });
    Route::middleware(['user.exist', 'user.status'])->group(function () {
        Route::middleware('post.exist')->group(function () {
            Route::get('/blog/{user}/{post}', [BlogController::class, 'details'])->name('blog.details');
        });

// ! FriendshipController - Controls the User Friends.
        Route::middleware('friendship.action.exist')->group(function () {
            Route::get('/users/{slug}/friendship/{action}', [FriendshipController::class, 'call'])->name('friendship.call');
        });
    });

// ! GoogleController - Controls the Google pages.
    Route::middleware('auth.custom')->group(function () {
        Route::get('/google/oauth', [GoogleController::class, 'store'])->name('google.store');

// ! CheckoutController - Controls the Checkout pages.
        Route::middleware(['auth.not.user', 'lesson.exist'])->group(function () {
            Route::post('/lessons/{id_lesson}/checkout', [CheckoutController::class, 'complete'])->name('checkout.complete');
        });
        Route::middleware(['lesson.exist', 'lesson.status.exist', 'auth.is.lesson.user'])->group(function () {
            Route::get('/lessons/{id_lesson}/checkout/{id_status}', [CheckoutController::class, 'status'])->name('checkout.status');
        });
    });
    Route::middleware('notification.type.exist')->group(function () {
        Route::post('/lessons/{id_lesson}/notifications/{type}', [CheckoutController::class, 'notification'])->name('checkout.notification');
    });
    
// ! ReviewController - Controls the Review pages.
    Route::middleware(['auth.custom'])->group(function () {
        Route::middleware('lesson.exist', 'auth.is.lesson.user')->group(function () {
            Route::post('/lessons/{id_lesson}/review/create', [ReviewController::class, 'create'])->name('review.create');
        });
        Route::middleware('review.exist')->group(function () {
            Route::put('/reviews/{id_review}/{id_user}/update', [ReviewController::class, 'update'])->name('review.update');
        });
    });

// ! UserController - Controls the User pages.
    Route::post('/apply', [UserController::class, 'apply'])->name('user.apply');
    
    Route::get('/users', [UserController::class, 'search'])->name('user.searchUsers');
    Route::get('/teachers', [UserController::class, 'search'])->name('user.searchTeachers');
    Route::middleware(['user.exist', 'user.status'])->group(function () {
        Route::middleware('auth.lesson.end')->group(function () {
            Route::get('/users/{slug}/profile', [UserController::class, 'profile'])->name('user.profile');
        });
        Route::middleware(['auth.custom', 'auth.not.user', 'auth.role.is.user', 'user.is.teacher', 'lesson.type.exist'])->group(function () {
            Route::get('/users/{slug}/checkout/{type}', [UserController::class, 'checkout'])->name('user.checkout');
        });
    });
    Route::middleware(['auth.custom', 'auth.is.user'])->group(function () {
        Route::post('/users/{slug}/update', [UserController::class, 'update'])->name('user.update');

// ! AchievementController - Controls the Achievement pages.
        Route::post('/users/{slug}/achievements/update', [AchievementController::class, 'update'])->name('achievement.update');

// ! GameController - Controls the Game pages.
        Route::post('/users/{slug}/games/update', [GameController::class, 'update'])->name('game.update');

// ! LanguageController - Controls the Language pages.
        Route::post('/users/{slug}/languages/update', [LanguageController::class, 'update'])->name('language.update');
    });

// ! PanelController - Controls the panel in general.
    Route::middleware(['auth.custom', 'auth.role.is.admin'])->group(function () {
        Route::get('/panel', [PanelController::class, 'blog'])->name('panel.blog');
        Route::get('/panel/blog', [PanelController::class, 'blog'])->name('panel.blog');
        Route::get('/panel/platform', [PanelController::class, 'banner'])->name('panel.platform');
        Route::get('/panel/platform/banner', [PanelController::class, 'banner'])->name('panel.banner');
        Route::get('/panel/platform/dolar', [PanelController::class, 'dolar'])->name('panel.dolar');
        Route::get('/panel/teachers', [PanelController::class, 'teachers'])->name('panel.teachers');
        Route::get('/panel/teachers/create', [PanelController::class, 'teacher'])->name('panel.showCreateTeacher');
        Route::middleware('user.exist')->group(function () {
            Route::get('/panel/teachers/{slug}', [PanelController::class, 'teacher'])->name('panel.teacher');
        });
        Route::get('/panel/users', [PanelController::class, 'users'])->name('panel.users');
        Route::get('/panel/users/create', [PanelController::class, 'user'])->name('panel.showCreateUser');
        Route::middleware('user.exist')->group(function () {
            Route::get('/panel/users/{slug}', [PanelController::class, 'user'])->name('panel.user');
        });
        Route::get('/panel/coupons', [PanelController::class, 'coupons'])->name('panel.coupons');
        Route::get('/panel/coupons/create', [PanelController::class, 'coupon'])->name('panel.showCreateCoupon');
        // Route::middleware('coupon.exist')->group(function () {
            Route::get('/panel/coupons/{slug}', [PanelController::class, 'coupon'])->name('panel.coupon');
        // });
        Route::get('/panel/bookings', [PanelController::class, 'lessons'])->name('panel.lessons');
        Route::get('/panel/bookings/create', [PanelController::class, 'lesson'])->name('panel.showCreate');
        // Route::middleware('lesson.exist')->group(function () {
            Route::get('/panel/bookings/{id_lesson}', [PanelController::class, 'lesson'])->name('panel.lesson');
        // });

        // TODO: Middlewares
        Route::post('/panel/{section}/{action}', [PanelController::class, 'call'])->name('panel.section.doCreate');
        Route::put('/panel/{section}/{slug}/{action}', [PanelController::class, 'call'])->name('panel.section.doUpdate');
        Route::delete('/panel/{section}/{slug}/{action}', [PanelController::class, 'call'])->name('panel.section.doDelete');
    });
