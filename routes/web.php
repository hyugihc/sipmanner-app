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



Route::get('/', 'AuthController@showFormLogin')->name('login');
Route::get('login', 'AuthController@showFormLogin')->name('login');
Route::post('login', 'AuthController@login');
Route::get('register', 'AuthController@showFormRegister')->name('register');
Route::post('register', 'AuthController@register');

Route::group(['middleware' => 'auth'], function () {

    Route::get('logout', 'AuthController@logout')->name('logout');
    Route::get('cans/getUser/{nipLama}', 'UserController@getUser');


    Route::get('users', 'UserController@index')->name('users.index');
    Route::get('users/create', 'UserController@create')->name('users.create');
    Route::post('users', 'UserController@store')->name('users.store');
    Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit');
    Route::put('users/{user}', 'UserController@update')->name('users.update');
    Route::delete('users/{user}', 'UserController@destroy')->name('users.destroy');
    Route::get('users/{user}', 'UserController@show')->name('users.show');


    Route::resource('cans', CanController::class);
    // Route::get('{file_sk}', 'CanController@downloadFileSk')->name('cans.download');
    Route::get('cans/{can}/download', 'CanController@downloadFileSk')->name('cans.download');

    Route::resource('program_intervensis', ProgramIntervensiController::class);
    Route::resource('progress_programs', ProgressProgramController::class);
});

// Route::get('/', function () {
//     return view('layouts.master');
// });
