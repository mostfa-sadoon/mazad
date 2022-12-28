<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


/*
Route::group(['namespace' => 'Site' , 'prefix' => 'user' , 'middleware' => 'auth:web'] , function () {
    
    Route::get('/order', function () {
        return 'In user';
    });

});




Route::group(['namespace' => 'Site' , 'prefix' => 'user'] , function () {
    
    Route::get('/login', function () {
        return "user login";
    })->name('login');

});
*/

// Route::get('/test', function () {
//     return config('laravellocalization.supportedLocales');
// });


Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');
