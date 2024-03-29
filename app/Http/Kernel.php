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
        "web" => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        "api" => [
            "throttle:60,1",
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
        "auth" => \App\Http\Middleware\Authenticate::class,
        "auth.basic" => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        "bindings" => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        "cache.headers" => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        "can" => \Illuminate\Auth\Middleware\Authorize::class,
        "guest" => \App\Http\Middleware\RedirectIfAuthenticated::class,
        "password.confirm" => \Illuminate\Auth\Middleware\RequirePassword::class,
        "signed" => \Illuminate\Routing\Middleware\ValidateSignature::class,
        "throttle" => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        "verified" => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        // "api.auth" => \App\Http\Middleware\API\Authenticate::class,
        
        "api.assignment.exist" => \App\Http\Middleware\API\CheckAssignmentExist::class,

        "api.chat.exist" => \App\Http\Middleware\API\CheckChatExist::class,
        "api.chat.is.available" => \App\Http\Middleware\API\CheckChatIsAvailable::class,
        "api.chat.lesson.is.offline" => \App\Http\Middleware\API\CheckChatLessonIsOffline::class,

        "api.lesson.exist" => \App\Http\Middleware\API\CheckLessonExist::class,

        "api.presentation.exist" => \App\Http\Middleware\API\CheckPresentationExist::class,

        "api.user.exist" => \App\Http\Middleware\API\CheckUserExist::class,
        
        "auth.status" => \App\Http\Middleware\CheckAuthenticateStatus::class,
        "auth.custom" => \App\Http\Middleware\CustomAuthenticate::class,
        "auth.is.user" => \App\Http\Middleware\CheckAuthenticateIsUser::class,
        "auth.not.user" => \App\Http\Middleware\CheckAuthenticateNotUser::class,
        "auth.is.lesson.member" => \App\Http\Middleware\CheckAuthenticateIsLessonUser::class,
        "auth.lesson.end" => \App\Http\Middleware\CheckAuthenticateLessonEnded::class,
        "auth.lesson.current.not.exist" => \App\Http\Middleware\CheckAuthenticateLessonCurrentNotExist::class,
        "auth.role.is.admin" => \App\Http\Middleware\CheckAuthenticateRoleIsAdmin::class,
        "auth.role.is.user" => \App\Http\Middleware\CheckAuthenticateRoleIsUser::class,
        "auth.role.not.user" => \App\Http\Middleware\CheckAuthenticateRoleNotUser::class,

        "coupon.exist" => \App\Http\Middleware\CheckCouponExist::class,

        "friendship.action.exist" => \App\Http\Middleware\CheckFriendshipActionExist::class,

        "game.exist" => \App\Http\Middleware\CheckGameExist::class,
        "game.is.active" => \App\Http\Middleware\CheckGameIsActive::class,

        "lesson.exist" => \App\Http\Middleware\CheckLessonExist::class,
        "lesson.status.exist" => \App\Http\Middleware\CheckLessonStatusExist::class,
        "lesson.status.1" => \App\Http\Middleware\CheckLessonStatusIs1::class,
        "lesson.type.exist" => \App\Http\Middleware\CheckLessonTypeExist::class,

        "notification.type.exist" => \App\Http\Middleware\CheckNotificationTypeExist::class,
        
        "post.exist" => \App\Http\Middleware\CheckPostExist::class,
        "post.action.exist" => \App\Http\Middleware\CheckPostActionExist::class,

        "review.exist" => \App\Http\Middleware\CheckReviewExist::class,

        "token.exist" => \App\Http\Middleware\CheckTokenExist::class,

        "user.exist" => \App\Http\Middleware\CheckUserExist::class,
        "user.is.coach" => \App\Http\Middleware\CheckUserIsCoach::class,
        "user.status" => \App\Http\Middleware\CheckUserStatus::class,
    ];
}
