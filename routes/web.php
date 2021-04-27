<?php
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\DefaultController;
    use App\Http\Controllers\BlogController;
    use App\Http\Controllers\LessonController;
    use App\Http\Controllers\UserController;
    use Illuminate\Support\Facades\Route;

// ! AuthController - Controls the authentication pages.
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/signin', [AuthController::class, 'signin'])->name('auth.signin');
    Route::middleware('auth')->group(function () {
        Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    });
    
// ! DefaultController - Controls the web in general.
    Route::get('/', [DefaultController::class, 'index'])->name('web.index');
    Route::get('/coming-soon', [DefaultController::class, 'comingSoon'])->name('web.coming_soon');
    Route::middleware(['game.exist', 'game.is.active'])->group(function () {
        Route::get('/games/{slug}', [DefaultController::class, 'game'])->name('web.game');
    });
    Route::get('/home', [DefaultController::class, 'home'])->name('web.home');
    Route::get('/privacy-politics', [DefaultController::class, 'privacyPolitics'])->name('web.privacy_politics');
    Route::get('/terms-&-conditions', [DefaultController::class, 'termsAndConditions'])->name('web.terms_&_conditions');

// ! BlogController - Controls the Blog pages.
    Route::get('/blog', [BlogController::class, 'list'])->name('blog.list');
    Route::middleware(['user.exist', 'post.exist'])->group(function () {
        Route::get('/blog/{id_user}/{slug}', [BlogController::class, 'details'])->name('blog.details');
    });
    Route::middleware('auth')->group(function () {
        Route::post('/blog/create', [BlogController::class, 'doCreate'])->name('blog.doCreate');
        Route::middleware(['post.exist'])->group(function () {
            Route::put('/blog/{slug}/update', [BlogController::class, 'doUpdate'])->name('blog.doUpdate');
            Route::delete('/blog/{slug}/delete', [BlogController::class, 'doDelete'])->name('blog.doDelete');
        });
    });

// ! LessonController - Controls the Lessom pages.
    Route::middleware(['auth', 'user.exist', 'user.not.checkout', 'user.is.teacher', 'lesson.type.exist'])->group(function () {
        Route::post('/users/{slug}/checkout/{type}', [LessonController::class, 'doCheckout'])->name('lesson.doCheckout');
    });

// ! UserController - Controls the User pages.
    Route::get('/users', [UserController::class, 'search'])->name('user.searchUsers');
    Route::get('/teachers', [UserController::class, 'search'])->name('user.searchTeachers');
    Route::middleware(['user.exist'])->group(function () {
        Route::get('/users/{slug}/profile', [UserController::class, 'profile'])->name('user.profile');
        Route::middleware(['auth', 'user.not.checkout', 'user.is.teacher', 'lesson.type.exist'])->group(function () {
            Route::get('/users/{slug}/checkout/{type}', [UserController::class, 'checkout'])->name('user.checkout');
        });
    });