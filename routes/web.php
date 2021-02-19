<?php

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
Route::view('/', 'home');

Route::get('shop', 'ShopController@index');
Route::get('shop_alt', 'ShopController@alternative');
Route::get('shop/{id}', 'ShopController@show');

Route::get('itunes', 'ItunesController@index');

Route::get('contact-us', 'ContactUsController@show');
Route::post('contact-us', 'ContactUsController@sendEmail');

//Route::get('contact', function () {
//    $name = ['name' => env('MAIL_FROM_NAME')];
//    return view('contact', $name);
//});

Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');
Route::redirect('home', '/');
Route::view('/', 'home');
Route::get('logout', 'Auth\LoginController@logout');

Route::prefix('admin')->group(function () {
    Route::redirect('/', '/admin/records');
    Route::get('records', 'Admin\RecordController@index');
});


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    route::redirect('/', 'records');
    Route::resource('genres', 'Admin\GenreController');
    Route::get('genres2/qryGenres', 'Admin\Genre2Controller@qryGenres');
    Route::resource('genres2', 'Admin\Genre2Controller', ['parameters' => ['genres2' => 'genre']]);
    Route::resource('records', 'Admin\RecordController');
    Route::resource('users', 'Admin\UserController');
    Route::get('users', 'Admin\UserController@index');
    Route::get('users/create', 'Admin\UserController@create');
    Route::post('users','Admin\UserController@store');
    Route::get('users/{user}', 'Admin\UserController@show');
    Route::get('users/{user}/edit', 'Admin\UserController@edit');
    Route::put('users/{user}', 'Admin\UserController@update');
    Route::delete('users/{user}', 'Admin\UserController@destroy');
    Route::resource('users2', 'Admin\User2Controller', ['parameters' => ['users2' => 'user']]);
    Route::get('users2', 'Admin\User2Controller@index');
    Route::get('users2/create', 'Admin\User2Controller@create');
    Route::post('users2', 'Admin\User2Controller@store');
    Route::get('users2/{user}', 'Admin\User2Controller@show');
    Route::get('users2/{user}/edit', 'Admin\User2Controller@edit');
    Route::put('users2/{user}', 'Admin\User2Controller@update');
    Route::delete('users2/{user}', 'Admin\User2Controller@destroy');
});

Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::redirect('/', '/user/profile');
    Route::get('profile', 'User\ProfileController@edit');
    Route::post('profile', 'User\ProfileController@update');
    Route::get('password', 'User\PasswordController@edit');
    Route::post('password', 'User\PasswordController@update');
});




