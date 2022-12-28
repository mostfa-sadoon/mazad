<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| site Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {


Route::group(['namespace' => 'Site'], function () {
    Route::get('auction/create', 'AuctionController@create')->name('auction.create');
    Route::post('dynamic_dependent_countries/fetch', 'AuctionController@fetch')->name('dynamic_dependent_countries.fetch');

    Route::get('/', 'HomeController@index')->name('client.home');

    Route::get('/about-us', 'AboutUsController@index')->name('about_us');
    Route::get('/Term&Condation', 'TermController@index')->name('site.terms');

    Route::get('/Privacy', 'PrivacyController@index')->name('site.Privacy');

    Route::get('/faq','Qutioncontroller@index')->name('faq');

    Route::get('/notifications', 'NotificationsController@index')->name('notifications');

    Route::get('/categories', 'CategoryController@getCategories')->name('client.categories');

    Route::get('/auctions', 'AuctionsController@index')->name('client.auctions');
    Route::post('sub_category/fetch', 'AuctionsController@fetch')->name('sub_category.fetch');
    Route::get('/auction/{slug}', 'AuctionsController@show')->name('client.auction.show');

    Route::post('/search','HomeController@search')->name('site.search');


    #
    Route::prefix('pages')->group(function () {
        // Route::get('contact-us', 'RoutingController@getContactUs')->name('pages.contact_us');
    });
    #



});







    Route::group(['namespace' => 'Site', 'middleware' => ['auth:client']], function () { // Must be Authenticated Client
        Route::post('auction/insert', 'AuctionController@insert')->name('auction.insert');
        Route::post('auction/bid/{id}', 'AuctionController@bid')->name('auction.bid');
        Route::post('auction/accept-bid/{id}', 'AuctionController@acceptBid')->name('auction.accept_bid');
        Route::post('auction/delete/{id}', 'AuctionController@deleteAuction')->name('auction.delete');
        Route::get('auction/recognition/{slug}', 'AuctionController@auctionRecognitionPage')->name('auction.recognition.page');
        Route::post('auction/recognition/{id}', 'AuctionController@auctionRecognition')->name('auction.recognition');
        Route::get('favourits', 'FavouriteController@index')->name('favourits.index');
        Route::get('favourits/add/{id}', 'FavouriteController@addToFavourite')->name('favourits.add');
        Route::get('logout', 'ClientLoginController@logout')->name('client.logout');
        Route::get('profile', 'ProfileController@getProfile')->name('client.profile');
        Route::post('profile', 'ProfileController@updateProfile')->name('client.profile.update');
        Route::get('password/edit', 'ProfileController@editPassword')->name('client.password.edit');
        Route::post('password/update', 'ProfileController@updatePassword')->name('client.password.update');
        Route::get('my-auctions', 'ProfileController@getMyAuctions')->name('client.my_auctions');
        Route::get('my-bids', 'ProfileController@getMyBids')->name('client.my_bids');
        Route::get('delete-account', 'ProfileController@deleteAccount')->name('client.delete_account');
    });








    Route::group(['namespace' => 'Site', 'middleware' => 'guest:client'], function () {   // Guest Client
        Route::get('login', 'ClientLoginController@showLoginForm')->name('client.login');
        Route::post('login', 'ClientLoginController@login')->name('client.login.submit');
        Route::get('register', 'ClientLoginController@showRegisterForm')->name('client.register');
        Route::post('register', 'ClientLoginController@register')->name('client.register.submit');
        // this route return page to write phone number
        Route::get('otp', 'ClientLoginController@otp')->name('client.otp');
        Route::post('check-client', 'ClientLoginController@checkClient')->name('check.client');
        // start reset password
        Route::get('reset-password/{country_code}/{phone}/{reset_password_token}', 'ClientLoginController@resetPassword')->name('client.reset_password');
        Route::get('new-password/{country_code}/{phone}/{reset_password_token}', 'ClientLoginController@newPassword')->name('client.new_password');
        Route::post('new-password/{country_code}/{phone}/{reset_password_token}', 'ClientLoginController@updateNewPassword')->name('client.new_password.update');
        // end resite password
        //start verify phone
        Route::get('send-phone/', 'ClientLoginController@sendphonepage')->name('client.phone.page');
        Route::post('send/phone','ClientLoginController@sendphone')->name('send.phone');
        Route::get('verify-phone/{country_code}/{phone}/{verifycode}', 'ClientLoginController@verifyphone')->name('client.new_password');
        // end verify phone
        Route::get('verification_code', 'ClientLoginController@showVerificationCode')->name('client.verification_code');
        Route::post('verify_code', 'ClientLoginController@verifyCode')->name('client.verify_code');
    });


});
