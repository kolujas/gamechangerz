<?php
    use Illuminate\Support\Facades\Route;
    
// * DefaultController - Controls the web in general.
    Route::get('/', 'Controller@index')->name('web.index');
    Route::get('/checkout', 'DefaultController@checkout')->name('web.checkout');
    Route::get('/coming-soon', 'DefaultController@comingSoon')->name('web.coming_soon');
    Route::get('/game/{slug}', 'DefaultController@game')->name('web.game');
    Route::get('/home', 'DefaultController@home')->name('web.home');
    Route::get('/privacy-politics', 'DefaultController@privacyPolitics')->name('web.privacy_politics');
    Route::get('/terms-&-conditions', 'DefaultController@termsAndConditions')->name('web.terms_&_conditions');

// * BlogController - Controls the Blog pages.
    Route::get('/blog', 'BlogController@list')->name('blog.list');
    Route::get('/blog/{slug}', 'BlogController@details')->name('blog.details');

// * UserController - Controls the User pages.
    Route::get('/{slug}/profile', 'UserController@profile')->name('user.profile');
    Route::get('/search', 'UserController@search')->name('user.search');