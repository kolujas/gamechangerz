<?php
    use App\Http\Controllers\API\AuthController;
    use App\Http\Controllers\API\AssigmentController;
    use App\Http\Controllers\API\ChatController;
    use App\Http\Controllers\API\FriendController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;

    Route::middleware('api')->group(function () {
// ! AuthController - Controls the authentication api.
        Route::post('/login', [AuthController::class, 'login'])->name('api.auth.login');

        Route::middleware('auth:api')->group(function () {
            Route::middleware(['api.lesson.exist'])->group(function () {
// ! AssigmentController - Controls the assigments api.
                Route::middleware(['api.assigment.exist'])->group(function () {
                    Route::get('/lessons/{id_lesson}/assigments/{slug}', [AssigmentController::class, 'get'])->name('api.assigment.get');
                });
                Route::post('/lessons/{id_lesson}/assigments/make', [AssigmentController::class, 'make'])->name('api.assigment.set');
            });

// ! ChatController - Controls the chats api.
            Route::get('/chats', [ChatController::class, 'all'])->name('api.chat.all');
            Route::middleware('api.user.exist')->group(function () {
                Route::get('/chats/{id_user}', [ChatController::class, 'get'])->name('api.chat.get');
            });
            Route::middleware('api.chat.exist')->group(function () {
                Route::post('/chats/{id_chat}', [ChatController::class, 'send'])->name('api.chat.send');
            });

// ! FriendController - Controls the friends api. 
            Route::middleware(['api.user.exist'])->group(function () {
                Route::post('/users/{slug}/friends/request', [FriendController::class, 'request'])->name('api.friend.request');
            });
        });
    });
