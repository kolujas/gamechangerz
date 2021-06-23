<?php
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\BlogController;
    use App\Http\Controllers\DefaultController;
    use App\Http\Controllers\FriendshipController;
    use App\Http\Controllers\GameController;
    use App\Http\Controllers\GoogleController;
    use App\Http\Controllers\LanguageController;
    use App\Http\Controllers\LessonController;
    use App\Http\Controllers\UserController;
    use Illuminate\Support\Facades\Route;

// ! AuthController - Controls the authentication pages.
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/signin', [AuthController::class, 'signin'])->name('auth.signin');
    // TODO Route::middleware('token.exist')->group(function () {
        Route::get('/email/{token}/confirm', [AuthController::class, 'confirm'])->name('auth.confirm');
    // });
    Route::middleware('auth.custom')->group(function () {
        Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    });
    
// ! DefaultController - Controls the web in general.
    Route::get('/', [DefaultController::class, 'index'])->name('web.index');
    Route::get('/coming-soon', [DefaultController::class, 'comingSoon'])->name('web.coming_soon');
    Route::middleware(['game.exist', 'game.is.active'])->group(function () {
        Route::get('/games/{slug}', [DefaultController::class, 'game'])->name('web.game');
    });
    Route::get('/home', [DefaultController::class, 'home'])->name('web.home');
    Route::middleware(['auth.custom', 'auth.role.is.admin'])->group(function () {
        Route::get('/panel', [DefaultController::class, 'panel'])->name('web.panel');
    });
    Route::get('/privacy-politics', [DefaultController::class, 'privacyPolitics'])->name('web.privacy_politics');
    Route::get('/terms-&-conditions', [DefaultController::class, 'termsAndConditions'])->name('web.terms_&_conditions');

// ! BlogController - Controls the Blog pages.
    Route::get('/blog', [BlogController::class, 'list'])->name('blog.list');
    Route::middleware(['auth.custom', 'auth.role.not.user'])->group(function () {
        Route::get('/blog/post/create', [BlogController::class, 'details'])->name('blog.showCreate');
        Route::post('/blog/post/create', [BlogController::class, 'do'])->name('blog.doCreate');
        Route::middleware(['auth.custom', 'auth.is.user', 'post.exist', 'post.action.exist'])->group(function () {
            Route::post('/blog/{id_user}/{slug}/{action}', [BlogController::class, 'do'])->name('blog.do');
        });
    });
    Route::middleware(['user.exist', 'user.status'])->group(function () {
        Route::middleware('post.exist')->group(function () {
            Route::get('/blog/{id_user}/{slug}', [BlogController::class, 'details'])->name('blog.details');
        });

// ! FriendshipController - Controls the User Friends.
        Route::middleware('friendship.action.exist')->group(function () {
            Route::get('/users/{slug}/friendship/{action}', [FriendshipController::class, 'call'])->name('friendship.call');
        });
    });

// ! GoogleController - Controls the Google pages.
    Route::middleware('auth.custom')->group(function () {
        Route::get('/google/oauth', [GoogleController::class, 'store'])->name('google.store');

// ! LessonController - Controls the Lessom pages.
        Route::middleware(['auth.not.user', 'user.exist', 'user.status', 'user.is.teacher', 'lesson.type.exist'])->group(function () {
            Route::post('/users/{slug}/checkout/{type}', [LessonController::class, 'doCheckout'])->name('lesson.doCheckout');
        });
        Route::middleware(['lesson.exist', 'lesson.status.exist', 'auth.is.lesson.user'])->group(function () {
            Route::get('/lessons/{id_lesson}/checkout/{status}', [LessonController::class, 'showStatus'])->name('lesson.checkout.status');
        });
    });
    Route::middleware('notification.type.exist')->group(function () {
        Route::post('/lessons/notification/{type}', [LessonController::class, 'checkNotification'])->name('lesson.notification.check');
    });

// ! UserController - Controls the User pages.
    Route::get('/users', [UserController::class, 'search'])->name('user.searchUsers');
    Route::get('/teachers', [UserController::class, 'search'])->name('user.searchTeachers');
    Route::middleware(['user.exist', 'user.status'])->group(function () {
        Route::get('/users/{slug}/profile', [UserController::class, 'profile'])->name('user.profile');
        Route::middleware(['auth.custom', 'auth.not.user', 'auth.role.is.user', 'user.is.teacher', 'lesson.type.exist'])->group(function () {
            Route::get('/users/{slug}/checkout/{type}', [UserController::class, 'checkout'])->name('user.checkout');
        });
    });
    Route::middleware(['auth.custom', 'auth.is.user'])->group(function () {
        Route::post('/users/{slug}/update', [UserController::class, 'update'])->name('user.update');

// ! GameController - Controls the Game pages.
        Route::post('/users/{slug}/games/update', [GameController::class, 'user'])->name('game.user');

// ! LanguageController - Controls the Language pages.
        Route::post('/users/{slug}/languages/update', [LanguageController::class, 'user'])->name('language.user');
    });