<?php
    use App\Http\Controllers\API\AssigmentController;
    use App\Http\Controllers\API\AuthController;
    use App\Http\Controllers\API\CouponController;
    use App\Http\Controllers\API\ChatController;
    use App\Http\Controllers\API\DefaultController;
    use App\Http\Controllers\API\FriendController;
    use App\Http\Controllers\API\LessonController;
    use App\Http\Controllers\API\PresentationController;
    use App\Http\Controllers\API\RoleController;
    use App\Http\Controllers\API\UserController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;

    Route::middleware("api")->group(function () {
// ! DefaultController - Controls the web api in general.
        Route::get("/dolar", [DefaultController::class, "dolar"])->name("api.web.dolar");

// ! CouponController - Controls the coupon api.
        Route::post("/coupons/validate", [CouponController::class, "check"])->name("api.coupon.check");
        
// ! LessonController - Controls the lessons api. 
        Route::middleware("auth:api")->group(function () {
            Route::middleware("api.lesson.exist")->group(function () {
                Route::put("/lessons/{id_lesson}/update", [LessonController::class, "update"])->name("api.lesson.update");
                
                Route::get("/lessons/{id_lesson}/assigments", [LessonController::class, "getAssigments"])->name("api.lesson.assigments");

// ! AssigmentController - Controls the assigments api.
                Route::middleware("api.assigment.exist")->group(function () {
                    Route::get("/lessons/{id_lesson}/assigments/{slug}", [AssigmentController::class, "get"])->name("api.assigment.get");
                });
            });
            Route::middleware(["api.chat.exist", "api.chat.is.available"])->group(function () {
                Route::post("/lessons/chats/{id_chat}/assigments/make", [AssigmentController::class, "make"])->name("api.assigment.set");

                Route::middleware("api.assigment.exist")->group(function () {
                    Route::post("/lessons/chats/{id_chat}/assigments/{id_assigment}/complete", [PresentationController::class, "make"])->name("api.presentation.set");
                });
            });
        });

// ! AuthController - Controls the authentication api.
        Route::post("/login", [AuthController::class, "login"])->name("api.auth.login");
        Route::post("/signin", [AuthController::class, "signin"])->name("api.auth.signin");

// ! ChatController - Controls the chats api.
        Route::middleware("auth:api")->group(function () {
            Route::get("/chats", [ChatController::class, "all"])->name("api.chat.all");
            Route::middleware("api.user.exist")->group(function () {
                Route::get("/chats/{id_user}", [ChatController::class, "get"])->name("api.chat.get");
                Route::middleware(["api.chat.is.available", "api.chat.lesson.is.offline"])->group(function () {
                    Route::post("/chats/{id_user}", [ChatController::class, "send"])->name("api.chat.send");
                });
            });

// ! FriendController - Controls the friends api. 
            Route::middleware("api.user.exist")->group(function () {
                Route::post("/users/{slug}/friends/request", [FriendController::class, "request"])->name("api.friend.request");
            });
            
// ! RoleController - Controls the Role api.
            Route::get("/role", [RoleController::class, "get"])->name("api.role.get");
        });

// ! UserController - Controls the user api.
        Route::get("/users", [UserController::class, "users"])->name("api.user.users");
        Route::get("/teachers", [UserController::class, "teachers"])->name("api.user.teachers");
        Route::middleware("api.user.exist")->group(function () {
            Route::get("/users/{slug}/lessons", [UserController::class, "lessons"])->name("api.user.lessons");
            Route::middleware("auth:api")->group(function () {
                Route::post("/users/{slug}/lessons", [UserController::class, "checkLesson"])->name("api.user.checkLesson");
            });
        });
    });
