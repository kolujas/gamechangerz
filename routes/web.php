<?php
    use Illuminate\Support\Facades\Route;
    
// * DefaultController - Controls the web in general.
    Route::get('/', 'App\Http\Controllers\DefaultController@index')->name('web.index');
    Route::get('/checkout', 'App\Http\Controllers\DefaultController@checkout')->name('web.checkout');
    Route::get('/coming-soon', 'App\Http\Controllers\DefaultController@comingSoon')->name('web.coming_soon');
    Route::get('/game/{slug}', 'App\Http\Controllers\DefaultController@game')->name('web.game');
    Route::get('/home', 'App\Http\Controllers\DefaultController@home')->name('web.home');
    Route::get('/privacy-politics', 'App\Http\Controllers\DefaultController@privacyPolitics')->name('web.privacy_politics');
    Route::get('/terms-&-conditions', 'App\Http\Controllers\DefaultController@termsAndConditions')->name('web.terms_&_conditions');

// * BlogController - Controls the Blog pages.
    Route::get('/blog', 'App\Http\Controllers\BlogController@list')->name('blog.list');
    Route::get('/blog/{slug}', 'App\Http\Controllers\BlogController@details')->name('blog.details');

// * UserController - Controls the User pages.
    Route::get('/users/{slug}/profile', 'App\Http\Controllers\UserController@profile')->name('user.profile');
    Route::get('/search', 'App\Http\Controllers\UserController@search')->name('user.search');