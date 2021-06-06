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
    Route::get('getUser/{nipLama}', 'UserController@getUser');
    Route::get('getuser_by_niplama/{nip_lama}', 'UserController@getuser_by_niplama');

    Route::get('users', 'UserController@index')->name('users.index');
    Route::get('users/create', 'UserController@create')->name('users.create');
    Route::post('users', 'UserController@store')->name('users.store');
    Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit');
    Route::put('users/{user}', 'UserController@update')->name('users.update');
    Route::delete('users/{user}', 'UserController@destroy')->name('users.destroy');
    Route::get('users/{user}', 'UserController@show')->name('users.show');


    Route::resource('cans', CanController::class);
    Route::get('cans/{can}/download', 'CanController@downloadFileSk')->name('cans.download');
    Route::put('cans/{can}/approval', 'CanController@approval')->name('cans.approval');

    Route::resource('program_intervensis', ProgramIntervensiController::class);
    Route::resource('progress_programs', ProgressProgramController::class);

    Route::resource('programs', ProgramController::class);
    Route::resource('progress', ProgressController::class);

    Route::resource('intervensi_nasionals', IntervensiNasionalController::class);
    Route::resource('intervensi_khususes', IntervensiKhususController::class);


    // Route::resource('progress_intervensi_nasionals', ProgressIntervensiNasionalController::class);
    Route::get('progress_intervensi_nasionals/{intervensiNasional}', 'ProgressIntervensiNasionalController@index')->name('progress_intervensi_nasionals.index');
    Route::get('progress_intervensi_nasionals/{intervensiNasional}/create', 'ProgressIntervensiNasionalController@create')->name('progress_intervensi_nasionals.create');
    Route::post('progress_intervensi_nasionals/{intervensiNasional}', 'ProgressIntervensiNasionalController@store')->name('progress_intervensi_nasionals.store');
    Route::get('progress_intervensi_nasionals/{intervensiNasional}/{progressIntervensiNasional}/edit', 'ProgressIntervensiNasionalController@edit')->name('progress_intervensi_nasionals.edit');
    Route::put('progress_intervensi_nasionals/{intervensiNasional}/{progressIntervensiNasional}', 'ProgressIntervensiNasionalController@update')->name('progress_intervensi_nasionals.update');
    Route::delete('progress_intervensi_nasionals/{intervensiNasional}/{progressIntervensiNasional}', 'ProgressIntervensiNasionalController@destroy')->name('progress_intervensi_nasionals.destroy');
    Route::get('progress_intervensi_nasionals/{intervensiNasional}/{progressIntervensiNasional}', 'ProgressIntervensiNasionalController@show')->name('progress_intervensi_nasionals.show');

    // Route::resource('progress_intervensi_khususes', ProgressIntervensiKhususController::class);
    Route::get('progress_intervensi_khususes/{intervensiKhusus}', 'ProgressIntervensiKhususController@index')->name('progress_intervensi_khususes.index');
    Route::get('progress_intervensi_khususes/{intervensiKhusus}/create', 'ProgressIntervensiKhususController@create')->name('progress_intervensi_khususes.create');
    Route::post('progress_intervensi_khususes/{intervensiKhusus}', 'ProgressIntervensiKhususController@store')->name('progress_intervensi_khususes.store');
    Route::get('progress_intervensi_khususes/{intervensiKhusus}/{progressIntervensiKhusus}/edit', 'ProgressIntervensiKhususController@edit')->name('progress_intervensi_khususes.edit');
    Route::put('progress_intervensi_khususes/{intervensiKhusus}/{progressIntervensiKhusus}', 'ProgressIntervensiKhususController@update')->name('progress_intervensi_khususes.update');
    Route::delete('progress_intervensi_khususes/{intervensiKhusus}/{progressIntervensiKhusus}', 'ProgressIntervensiKhususController@destroy')->name('progress_intervensi_khususes.destroy');
    Route::get('progress_intervensi_khususes/{intervensiKhusus}/{progressIntervensiKhusus}', 'ProgressIntervensiKhususController@show')->name('progress_intervensi_khususes.show');




    Route::get('pi_index', 'ProgressProgramController@pi_index')->name('pi_index');
    Route::get('ppiindex/{program_intervensi}', 'ProgressProgramController@ppi_index')->name('ppi_index');
});

// Route::get('/', function () {
//     return view('layouts.master');
// });
