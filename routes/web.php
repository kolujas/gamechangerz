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
    Route::get('/email/{token}/confirm', [AuthController::class, 'confirm'])->name('auth.confirm');
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
    Route::middleware('auth.custom')->group(function () {
        Route::get('/panel', [DefaultController::class, 'panel'])->name('web.panel');
    });
    Route::get('/privacy-politics', [DefaultController::class, 'privacyPolitics'])->name('web.privacy_politics');
    Route::get('/terms-&-conditions', [DefaultController::class, 'termsAndConditions'])->name('web.terms_&_conditions');

// ! BlogController - Controls the Blog pages.
    Route::get('/blog', [BlogController::class, 'list'])->name('blog.list');
    Route::middleware('auth.custom')->group(function () {
        Route::get('/blog/post/create', [BlogController::class, 'showCreate'])->name('blog.showCreate');
        Route::post('/blog/post/create', [BlogController::class, 'doCreate'])->name('blog.doCreate');
        Route::middleware(['post.exist'])->group(function () {
            Route::put('/blog/{slug}/update', [BlogController::class, 'doUpdate'])->name('blog.doUpdate');
            Route::delete('/blog/{slug}/delete', [BlogController::class, 'doDelete'])->name('blog.doDelete');
        });
    });
    Route::middleware(['user.exist', 'user.status', 'post.exist'])->group(function () {
        Route::get('/blog/{id_user}/{slug}', [BlogController::class, 'details'])->name('blog.details');
    });

// ! FriendshipController - Controls the User Friends.
    Route::middleware(['user.exist', 'user.status', 'friendship.action.exist'])->group(function () {
        Route::get('/users/{slug}/friendship/{action}', [FriendshipController::class, 'call'])->name('friendship.call');
    });

// ! GoogleController - Controls the Google pages.
    Route::middleware('auth.custom')->group(function () {
        Route::get('/google/oauth', [GoogleController::class, 'store'])->name('google.store');
    });

// ! LessonController - Controls the Lessom pages.
    Route::middleware(['auth.custom', 'user.exist', 'user.status', 'user.not.checkout', 'user.is.teacher', 'lesson.type.exist'])->group(function () {
        Route::post('/users/{slug}/checkout/{type}', [LessonController::class, 'doCheckout'])->name('lesson.doCheckout');
    });
    Route::middleware(['auth.custom', 'lesson.exist', 'lesson.status.exist'])->group(function () {
        Route::get('/lessons/{id_lesson}/checkout/{status}', [LessonController::class, 'showStatus'])->name('lesson.checkout.status');
    });
    // TODO Change to POST
    Route::get('/lessons/notification', [LessonController::class, 'checkNotification'])->name('lesson.notification.check');

// ! UserController - Controls the User pages.
    Route::get('/users', [UserController::class, 'search'])->name('user.searchUsers');
    Route::get('/teachers', [UserController::class, 'search'])->name('user.searchTeachers');
    Route::middleware(['user.exist', 'user.status'])->group(function () {
        Route::middleware(['auth.custom', 'auth.is.user'])->group(function () {
            Route::post('/users/{slug}/update', [UserController::class, 'update'])->name('user.update');
        });
        Route::get('/users/{slug}/profile', [UserController::class, 'profile'])->name('user.profile');
        Route::middleware(['auth.custom', 'user.not.checkout', 'user.is.teacher', 'user.role.is.user', 'lesson.type.exist'])->group(function () {
            Route::get('/users/{slug}/checkout/{type}', [UserController::class, 'checkout'])->name('user.checkout');
        });
    });

// ! GameController - Controls the Game pages.
    Route::middleware(['user.exist', 'user.status'])->group(function () {
        Route::middleware('auth.custom')->group(function () {
            Route::post('/users/{slug}/games/update', [GameController::class, 'user'])->name('game.user');
        });

// ! LanguageController - Controls the Language pages.
        Route::middleware('auth.custom')->group(function () {
            Route::post('/users/{slug}/languages/update', [LanguageController::class, 'user'])->name('language.user');
        });
    });