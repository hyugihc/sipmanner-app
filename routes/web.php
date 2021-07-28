<?php

use App\IntervensiNasionalProvinsi;
use App\ProgressIntervensiNasional;
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

Route::get('/login', 'AuthController@showFormLogin')->name('login');
Route::post('/login', 'AuthController@login');

// =========================</Backdoor>================================

Route::get('/', 'Auth\LoginController@showLoginForm')->name('sso.login');
Route::post('/logout', [
    'as' => 'logout',
    'uses' => 'Auth\LoginController@logout'
]);

Route::group(['middleware' => 'auth'], function () {

    Route::resource('users', UserController::class);
    Route::get('/getUser/{nipLama}', 'UserController@getUser');
    Route::get('/getuser_by_niplama_sso/{nip_lama}', 'UserController@getuser_by_niplama_sso')->name('get_user_byniplama_sso');


    Route::resource('cans', CanController::class);
    Route::get('/cans/{can}/download', 'CanController@downloadFileSk')->name('cans.download');
    Route::put('/cans/{can}/approve', 'CanController@approve')->name('cans.approve');

    Route::get('/programs', 'ProgramController@index')->name('programs.index');
    Route::get('/progress', 'ProgressController@index')->name('progress.index');

    Route::resource('programs/intervensi-nasionals', IntervensiNasionalController::class);
    Route::resource('programs/intervensi-khususes', IntervensiKhususController::class);
    Route::put('/intervensi-khususes/{intervensiKhusus}/approve', 'IntervensiKhususController@approve')->name('intervensi-khususes.approve');


    Route::resource('progress/intervensi-nasionals.progress-intervensi-nasionals', 'ProgressIntervensiNasionalController')->middleware('progress.intervensi.nasional');
    Route::get('/pins/{progressIntervensiNasional}/downloaddok', 'ProgressIntervensiNasionalController@downloadDok')->name('pins.download.dok');
    Route::get('/pins/{progressIntervensiNasional}/downloadduk', 'ProgressIntervensiNasionalController@downloadDuk')->name('pins.download.duk');
    Route::put('/pins/{progressIntervensiNasional}/approve', 'ProgressIntervensiNasionalController@approve')->name('pins.approve');


    Route::resource('progress/intervensi-khususes.progress-intervensi-khususes', 'ProgressIntervensiKhususController')->middleware('progress.intervensi.khusus');
    Route::get('/piks/{progressIntervensiKhusus}/downloaddok', 'ProgressIntervensiKhususController@downloadDok')->name('piks.download.dok');
    Route::get('/piks/{progressIntervensiKhusus}/downloadduk', 'ProgressIntervensiKhususController@downloadDuk')->name('piks.download.duk');
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



Route::get('/home', 'HomeController@index')->name('home');
