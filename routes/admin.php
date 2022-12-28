<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
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


    Route::group(['namespace' => 'Dashboard', 'prefix' => 'admin', 'middleware' => 'auth:admin'], function () {


        ################################## Admins ######################################
        Route::group(['prefix' => 'admins', 'middleware' => 'can:admins'], function () {
            Route::get('/', 'AdminController@index')->name('admin.admins.index');
            Route::get('/create', 'AdminController@create')->name('admin.admins.create');
            Route::post('/store', 'AdminController@store')->name('admin.admins.store');
            Route::get('/edit/{id}', 'AdminController@edit')->name('admin.admins.edit');
            Route::post('update/{id}', 'AdminController@update')->name('admin.admins.update');
            Route::get('delete/{id}', 'AdminController@delete')->name('admin.admins.delete');
        });
        ################################## End of Admins ######################################




        Route::get('/', 'DashboardController@index')->name('admin.dashboard');
        Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard');
        Route::get('/logout', 'LoginController@logout')->name('admin.logout');




        ################################## Users ######################################
        Route::group([], function () {
            Route::get('/users', 'UserController@allUsers')->name('dashboard.users.index');
            Route::get('/user/{id}/change-active', 'UserController@changeActive')->name('dashboard.users.change_active');
            Route::get('/send-notification-to-user/{id}', 'UserController@sendNotificationToUserPage')->name('admin.send-notification-to-user-page');
            Route::post('/send-notification-to-user/{id}', 'UserController@sendNotificationToUser')->name('admin.send-notification-to-user');
        });
        ################################## End of Users ######################################




        ################################## Profile ######################################
        Route::group(['prefix' => 'profile'], function () {
            Route::get('edit', 'ProfileController@editProfile')->name('edit.profile');
            Route::put('update', 'ProfileController@updateprofile')->name('update.profile');
        });
        ################################## End of Profile ######################################



        ################################## categories routes ######################################
        Route::group(['prefix' => 'categories'], function () {
            Route::get('/', 'CategoriesController@index')->name('admin.categories');
            Route::get('/subcategories/{category_id}', 'CategoriesController@subcategories')->name('admin.subcategories');
            Route::get('create', 'CategoriesController@create')->name('admin.categories.create');
            Route::post('store', 'CategoriesController@store')->name('admin.categories.store');
            Route::get('edit/{id}', 'CategoriesController@edit')->name('admin.categories.edit');
            Route::post('update/{id}', 'CategoriesController@update')->name('admin.categories.update');
            Route::get('delete/{id}', 'CategoriesController@destroy')->name('admin.categories.delete');
        });
        ################################## end categories    #######################################



        ################################## attributes routes ######################################
        Route::group(['prefix' => 'attributes/{category_id}'], function () {
            Route::get('/', 'AttributesController@index')->name('admin.attributes');
            Route::get('create', 'AttributesController@create')->name('admin.attributes.create');
            Route::post('store', 'AttributesController@store')->name('admin.attributes.store');
            Route::get('edit/{id}', 'AttributesController@edit')->name('admin.attributes.edit');
            Route::post('update/{id}', 'AttributesController@update')->name('admin.attributes.update');
            Route::get('delete/{id}', 'AttributesController@destroy')->name('admin.attributes.delete');
        });
        ################################## end attributes    #######################################



        ################################## sub attributes routes ######################################
        Route::group(['prefix' => 'sub_attributes/{attribute_id}'], function () {
            Route::get('/', 'SubAttributesController@index')->name('admin.sub_attributes');
            Route::get('create', 'SubAttributesController@create')->name('admin.sub_attributes.create');
            Route::post('store', 'SubAttributesController@store')->name('admin.sub_attributes.store');
            Route::get('edit/{id}', 'SubAttributesController@edit')->name('admin.sub_attributes.edit');
            Route::post('update/{id}', 'SubAttributesController@update')->name('admin.sub_attributes.update');
            Route::get('delete/{id}', 'SubAttributesController@destroy')->name('admin.sub_attributes.delete');
        });
        ################################## end sub attributes    #######################################



        ################################## countries routes ######################################
        Route::group(['prefix' => 'countries'], function () {
            Route::get('/', 'CountriesController@index')->name('admin.countries');
            Route::get('create', 'CountriesController@create')->name('admin.countries.create');
            Route::post('store', 'CountriesController@store')->name('admin.countries.store');
            Route::get('edit/{id}', 'CountriesController@edit')->name('admin.countries.edit');
            Route::post('update/{id}', 'CountriesController@update')->name('admin.countries.update');
            Route::get('delete/{id}', 'CountriesController@destroy')->name('admin.countries.delete');
        });
        ################################## end countries    #######################################



          ################################## aboutus routes ######################################
          Route::group(['prefix' => 'aboutus'], function () {
            Route::get('/edit', 'AboutUsController@edit')->name('admin.aboutus.edit');
            Route::put('/update', 'AboutUsController@update')->name('admin.aboutus.update');
        });
        ################################## end aboutus   #######################################



        ################################## HomeSection routes ######################################
        Route::group(['prefix' => 'HomeSection'], function () {
            Route::get('/index', 'HomeSectionController@index')->name('admin.HomeSection.index');
            Route::get('/create', 'HomeSectionController@create')->name('admin.HomeSection.create');
            Route::post('/store', 'HomeSectionController@store')->name('admin.HomeSection.store');
            Route::get('/edit/{id}', 'HomeSectionController@edit')->name('admin.HomeSection.edit');
            Route::post('/update', 'HomeSectionController@update')->name('admin.HomeSection.update');
            Route::get('/destroy/{id}', 'HomeSectionController@delete')->name('admin.HomeSection.delete');
        });
        ################################## HomeSection routes ######################################
        ################################## quetion routes ######################################
             Route::group(['prefix' => 'Quetion'], function () {
                Route::get('/index', 'QuetionController@index')->name('admin.Quetion.index');
                Route::get('/create', 'QuetionController@create')->name('admin.Quetion.create');
                Route::post('/store', 'QuetionController@store')->name('admin.Quetion.store');
                Route::get('/edit/{id}', 'QuetionController@edit')->name('admin.Quetion.edit');
                Route::post('/update', 'QuetionController@update')->name('admin.Quetion.update');
                Route::get('/destroy/{id}', 'QuetionController@desstroy')->name('admin.Quetion.delete');
            });
        ################################## end quetion ######################################

        ################################## start logo ######################################
        Route::group(['prefix' => 'Logo'], function () {
        Route::get('/edit', 'LogoController@edit')->name('admin.Logo.edit');
        Route::post('/update', 'LogoController@update')->name('admin.Logo.update');
        });
        ################################## end logo ######################################

          ################################## start logo ######################################
          Route::group(['prefix' => 'ContactUs'], function () {
            Route::get('/edit', 'ContactUsController@edit')->name('admin.ContactUs.edit');
            Route::post('/update', 'ContactUsController@update')->name('admin.ContactUs.update');
            });
            ################################## end logo ######################################

        ################################## cities routes ######################################
        Route::group(['prefix' => 'cities'], function () {
            Route::get('/', 'CitiesController@index')->name('admin.cities');
            Route::get('create', 'CitiesController@create')->name('admin.cities.create');
            Route::post('store', 'CitiesController@store')->name('admin.cities.store');
            Route::get('edit/{id}', 'CitiesController@edit')->name('admin.cities.edit');
            Route::post('update/{id}', 'CitiesController@update')->name('admin.cities.update');
            Route::get('delete/{id}', 'CitiesController@destroy')->name('admin.cities.delete');
        });
        ################################## end cities    #######################################



        ################################## auctions routes ######################################
        Route::group(['prefix' => 'auctions'], function () {
            Route::get('/', 'AuctionsController@index')->name('admin.auctions');
            // Route::get('create', 'AuctionsController@create')->name('admin.auctions.create');
            // Route::post('store', 'AuctionsController@store')->name('admin.auctions.store');
            Route::get('auction-mark/{id}', 'AuctionsController@markPage')->name('admin.auction.mark.get');
            Route::post('mark-auction/{id}', 'AuctionsController@markAuction')->name('admin.auction.mark');
            Route::get('delete/{id}', 'AuctionsController@destroy')->name('admin.auctions.delete');
        });
        ################################## end auctions    #######################################





        ################################## recognitions routes ######################################
        Route::group(['prefix' => 'recognitions'], function () {
            Route::get('/', 'RecognitionsController@index')->name('admin.recognitions');
            Route::get('create', 'RecognitionsController@create')->name('admin.recognitions.create');
            Route::post('store', 'RecognitionsController@store')->name('admin.recognitions.store');
            Route::get('edit/{id}', 'RecognitionsController@edit')->name('admin.recognitions.edit');
            Route::post('update/{id}', 'RecognitionsController@update')->name('admin.recognitions.update');
            Route::get('delete/{id}', 'RecognitionsController@destroy')->name('admin.recognitions.delete');
        });
        ################################## end recognitions    #######################################



        ################################## slider routes ######################################
        Route::group(['prefix' => 'slider'], function () {
            Route::get('/', 'SliderController@index')->name('admin.slider');
            Route::get('create', 'SliderController@create')->name('admin.slider.create');
            Route::post('store', 'SliderController@store')->name('admin.slider.store');
            Route::get('edit/{id}', 'SliderController@edit')->name('admin.slider.edit');
            Route::post('update/{id}', 'SliderController@update')->name('admin.slider.update');
            Route::get('delete/{id}', 'SliderController@destroy')->name('admin.slider.delete');
        });
        ################################## end slider    #######################################


        ################################## terms&condation routes ######################################
        Route::group(['prefix' => 'terms&condation'], function () {
            Route::get('edit', 'TermController@edit')->name('admin.terms.edit');
            Route::post('update', 'TermController@update')->name('admin.terms.update');
        });
        ################################## end terms&condation    #######################################

          ################################## terms&condation routes ######################################
        Route::group(['prefix' => 'privecypolices'], function () {
            Route::get('edit', 'PrivacyController@edit')->name('admin.privacy.edit');
            Route::post('update', 'PrivacyController@update')->name('admin.privacy.update');
        });
        ################################## end terms&condation    #######################################

        ################################## bannars routes ######################################
        Route::group(['prefix' => 'bannars'], function () {
            Route::get('/', 'BannerController@index')->name('admin.banners');
            Route::get('create', 'BannerController@create')->name('admin.banners.create');
            Route::post('store', 'BannerController@store')->name('admin.banners.store');
            Route::get('edit/{id}', 'BannerController@edit')->name('admin.banners.edit');
            Route::post('update', 'BannerController@update')->name('admin.banners.update');
            // Route::post('update/{id}', 'BannarController@update')->name('admin.bannars.update');
            Route::get('delete/{id}', 'BannerController@destroy')->name('admin.banners.delete');
        });
        ################################## end bannars    #######################################

        ################################## socialmedia routes ######################################
        Route::group(['prefix' => 'socialmedia'], function () {
            Route::get('/', 'socialmediaController@index')->name('admin.socialmedia');
            Route::get('edit/{id}', 'socialmediaController@edit')->name('admin.socialmedia.edit');
            Route::post('update', 'socialmediaController@update')->name('admin.socialmedia.update');
            Route::get('delete/{id}', 'socialmediaController@destroy')->name('admin.socialmedia.delete');
        });
        ################################## end bannars    #######################################


    });




    Route::group(['namespace' => 'Dashboard', 'prefix' => 'admin', 'middleware' => 'guest:admin'], function () {

        Route::get('/login', function () {
            return view('dashboard.auth.login');
            //return "admin login";
        })->name('admin.login');

        Route::post('login', 'LoginController@postLogin')->name('admin.post.login');
    });
});
