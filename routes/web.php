<?php

use Illuminate\Support\Facades\Artisan;
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





// =========================<Backdoor>================================

Route::get('/xlogin', 'AuthController@showFormLogin')->name('xlogin');
Route::post('/xlogin', 'AuthController@login');
Route::get('/xregister', 'AuthController@showFormRegister')->name('xregister');
Route::post('/xregister', 'AuthController@register');
Route::get('/xlogout', 'AuthController@logout')->name('xlogout');

// =========================</Backdoor>================================

Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/getUser/{nipLama}', 'UserController@getUser');
    Route::get('/getuser_by_niplama/{nip_lama}', 'UserController@getuser_by_niplama')->name('get_user_byniplama');
    Route::get('/getuser_by_niplama_sso/{nip_lama}', 'UserController@getuser_by_niplama_sso')->name('get_user_byniplama_sso');

    Route::get('/users', 'UserController@index')->name('users.index');
    Route::get('/users/create', 'UserController@create')->name('users.create');
    Route::post('/users', 'UserController@store')->name('users.store');
    Route::get('/users/{user}/edit', 'UserController@edit')->name('users.edit');
    Route::put('/users/{user}', 'UserController@update')->name('users.update');
    Route::delete('/users/{user}', 'UserController@destroy')->name('users.destroy');
    Route::get('/users/{user}', 'UserController@show')->name('users.show');


    Route::resource('cans', CanController::class);
    Route::get('/cans/{can}/download', 'CanController@downloadFileSk')->name('cans.download');
    Route::put('/cans/{can}/approve', 'CanController@approve')->name('cans.approve');

    Route::resource('programs', ProgramController::class);
    Route::resource('progress', ProgressController::class);

    Route::resource('intervensi_nasionals', IntervensiNasionalController::class);
    Route::resource('intervensi_nasional_provinsis', IntervensiNasionalProvinsiController::class);
    Route::resource('intervensi_khususes', IntervensiKhususController::class);
    Route::put('/intervensi_khususes/{intervensiKhusus}/approve', 'IntervensiKhususController@approve')->name('intervensi_khususes.approve');


    Route::get('/progress_intervensi_nasionals/{intervensiNasional}', 'ProgressIntervensiNasionalController@index')->name('progress_intervensi_nasionals.index');
    Route::get('/progress_intervensi_nasionals/{intervensiNasional}/create', 'ProgressIntervensiNasionalController@create')->name('progress_intervensi_nasionals.create');
    Route::post('/progress_intervensi_nasionals/{intervensiNasional}', 'ProgressIntervensiNasionalController@store')->name('progress_intervensi_nasionals.store');
    Route::get('/progress_intervensi_nasionals/{intervensiNasional}/{progressIntervensiNasional}/edit', 'ProgressIntervensiNasionalController@edit')->name('progress_intervensi_nasionals.edit');
    Route::put('/progress_intervensi_nasionals/{intervensiNasional}/{progressIntervensiNasional}', 'ProgressIntervensiNasionalController@update')->name('progress_intervensi_nasionals.update');
    Route::delete('/progress_intervensi_nasionals/{intervensiNasional}/{progressIntervensiNasional}', 'ProgressIntervensiNasionalController@destroy')->name('progress_intervensi_nasionals.destroy');
    Route::get('/progress_intervensi_nasionals/{intervensiNasional}/{progressIntervensiNasional}', 'ProgressIntervensiNasionalController@show')->name('progress_intervensi_nasionals.show');

    Route::get('/pins/{progressIntervensiNasional}/downloaddok', 'ProgressIntervensiNasionalController@downloadDok')->name('pins.download.dok');
    Route::get('/pins/{progressIntervensiNasional}/downloadduk', 'ProgressIntervensiNasionalController@downloadDuk')->name('pins.download.duk');

    Route::get('/progress_intervensi_khususes/{intervensiKhusus}', 'ProgressIntervensiKhususController@index')->name('progress_intervensi_khususes.index');
    Route::get('/progress_intervensi_khususes/{intervensiKhusus}/create', 'ProgressIntervensiKhususController@create')->name('progress_intervensi_khususes.create');
    Route::post('/progress_intervensi_khususes/{intervensiKhusus}', 'ProgressIntervensiKhususController@store')->name('progress_intervensi_khususes.store');
    Route::get('/progress_intervensi_khususes/{intervensiKhusus}/{progressIntervensiKhusus}/edit', 'ProgressIntervensiKhususController@edit')->name('progress_intervensi_khususes.edit');
    Route::put('/progress_intervensi_khususes/{intervensiKhusus}/{progressIntervensiKhusus}', 'ProgressIntervensiKhususController@update')->name('progress_intervensi_khususes.update');
    Route::delete('/progress_intervensi_khususes/{intervensiKhusus}/{progressIntervensiKhusus}', 'ProgressIntervensiKhususController@destroy')->name('progress_intervensi_khususes.destroy');
    Route::get('/progress_intervensi_khususes/{intervensiKhusus}/{progressIntervensiKhusus}', 'ProgressIntervensiKhususController@show')->name('progress_intervensi_khususes.show');

    Route::get('/piks/{progressIntervensiKhusus}/downloaddok', 'ProgressIntervensiKhususController@downloadDok')->name('piks.download.dok');
    Route::get('/piks/{progressIntervensiKhusus}/downloadduk', 'ProgressIntervensiKhususController@downloadDuk')->name('piks.download.duk');


    Route::put('/pins/{progressIntervensiNasional}/approve', 'ProgressIntervensiNasionalController@approve')->name('pins.approve');
    Route::put('/piks/{progressIntervensiKhusus}/approve', 'ProgressIntervensiKhususController@approve')->name('piks.approve');

    Route::resource('articles', ArticleController::class);
    Route::get('/articles/{article}/download', 'ArticleController@download')->name('articles.download');
    Route::put('/articles/{article}/approve', 'ArticleController@approve')->name('articles.approve');


    Route::get('/faq', function () {
        return view('faq');
    })->name('faq');


    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('reports', ReportController::class);
    Route::put('/reports/{report}/approve', 'ReportController@approve')->name('reports.approve');
    Route::get('/reports/{report}/print', 'ReportController@print')->name('reports.print');
});



//Clear route cache:
Route::get('/route-clear', function () {
    $exitCode = Artisan::call('route:clear');
    return 'Routes cache cleared';
});

//Clear config cache:
Route::get('/config-cache', function () {
    $exitCode = Artisan::call('config:cache');
    return 'Config cache cleared';
});

// Clear application cache:
Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    return 'Application cache cleared';
});

// Clear view cache:
Route::get('/view-clear', function () {
    $exitCode = Artisan::call('view:clear');
    return 'View cache cleared';
});

// Route::get('/', function () {
//     return view('login');
// });

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
