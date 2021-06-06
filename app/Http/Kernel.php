<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        // 'api.auth' => \App\Http\Middleware\API\Authenticate::class,
        'api.user.exist' => \App\Http\Middleware\API\CheckUserExist::class,
        'api.chat.exist' => \App\Http\Middleware\API\CheckChatExist::class,
        'api.lesson.exist' => \App\Http\Middleware\API\CheckLessonExist::class,

        'game.exist' => \App\Http\Middleware\CheckGameExist::class,
        'game.is.active' => \App\Http\Middleware\CheckGameIsActive::class,

        'lesson.exist' => \App\Http\Middleware\CheckLessonExist::class,
        'lesson.status.exist' => \App\Http\Middleware\CheckLessonStatusExist::class,
        'lesson.type.exist' => \App\Http\Middleware\CheckLessonTypeExist::class,

        'chat.exist' => \App\Http\Middleware\CheckChatExist::class,

        'friendship.action.exist' => \App\Http\Middleware\CheckFriendshipActionExist::class,
        
        'post.exist' => \App\Http\Middleware\CheckPostExist::class,

        'user.not.checkout' => \App\Http\Middleware\CheckUserDoesNotOwnCheckout::class,
        'user.exist' => \App\Http\Middleware\CheckUserExist::class,
        'user.is.teacher' => \App\Http\Middleware\CheckUserIsTeacher::class,
        'user.role.is.user' => \App\Http\Middleware\CheckUserRoleIsUser::class,
    ];
}
