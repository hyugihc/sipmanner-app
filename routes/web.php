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

    //====================================USER====================================

    // Route::get('/searchuser_by_name_sso/{name}', 'UserController@searchuser_by_name_sso');
    Route::get('/users/recap', 'UserController@recap')->name("users.recap");
    Route::get('/users/index/', 'UserController@index');
    Route::get('/users/index/{query}', 'UserController@queryIndex')->name('users.index.query');
    Route::resource('users', UserController::class);
    //Route::get('/getUser/{nipLama}', 'UserController@getUser');
    Route::get('/getuser_by_niplama_sso/{nip_lama}', 'UserController@getuser_by_niplama_sso')->name('get_user_byniplama_sso');
    Route::get('/searchuser_by_niplama_sso/{nip_lama}', 'UserController@searchuser_by_niplama_sso')->name('search_user_byniplama_sso');

    //======================================DATA=====================================

    Route::resource('cans', CanController::class);
    Route::get('/cans/{can}/download', 'CanController@downloadFileSk')->name('cans.download');
    Route::put('/cans/{can}/approve', 'CanController@approve')->name('cans.approve');
    //====================================================================================
  
    Route::get('/programs', 'ProgramController@index')->name('programs.index');
    Route::get('/progress', 'ProgressController@index')->name('progress.index');
    //====================================================================================

    Route::resource('programs/intervensi-nasionals', IntervensiNasionalController::class);
    Route::resource('programs/intervensi-khususes', IntervensiKhususController::class);
    Route::put('/intervensi-khususes/{intervensiKhusus}/approve', 'IntervensiKhususController@approve')->name('intervensi-khususes.approve');

    //=====================================PIK======================================
    //Route::resource('programs/intervensi-nasionals-provinsi', IntervensiNasionalProvinsiController::class);
    Route::get('/programs/intervensi-nasionals-provinsi/{intervensiNasionalProvinsi}', 'IntervensiNasionalProvinsiController@show')->name('inp.show');
    Route::get('/programs/intervensi-nasionals-provinsi/{intervensiNasionalProvinsi}/edit', 'IntervensiNasionalProvinsiController@edit')->name('inp.edit');
    Route::put('/programs/intervensi-nasionals-provinsi/{intervensiNasionalProvinsi}', 'IntervensiNasionalProvinsiController@update')->name('inp.update');
    Route::put('/programs/intervensi-nasionals-provinsi/{intervensiNasionalProvinsi}/approve', 'IntervensiNasionalProvinsiController@approve')->name('inp.approve');


    //===================================PROGRESS PIN===================================
    Route::resource('progress/intervensi-nasionals.progress-intervensi-nasionals', 'ProgressIntervensiNasionalController')->middleware('progress.intervensi.nasional');
    Route::get('/pins/{progressIntervensiNasional}/downloaddok', 'ProgressIntervensiNasionalController@downloadDok')->name('pins.download.dok');
    Route::get('/pins/{progressIntervensiNasional}/downloadduk', 'ProgressIntervensiNasionalController@downloadDuk')->name('pins.download.duk');
    Route::put('/pins/{progressIntervensiNasional}/approve', 'ProgressIntervensiNasionalController@approve')->name('pins.approve');

    //====================================PROGRES PIK====================================
    Route::resource('progress/intervensi-khususes.progress-intervensi-khususes', 'ProgressIntervensiKhususController')->middleware('progress.intervensi.khusus');
    Route::get('/piks/{progressIntervensiKhusus}/downloaddok', 'ProgressIntervensiKhususController@downloadDok')->name('piks.download.dok');
    Route::get('/piks/{progressIntervensiKhusus}/downloadduk', 'ProgressIntervensiKhususController@downloadDuk')->name('piks.download.duk');
    Route::put('/piks/{progressIntervensiKhusus}/approve', 'ProgressIntervensiKhususController@approve')->name('piks.approve');

    //======================================ARTIKEL=====================================
    Route::resource('articles', ArticleController::class);
    Route::get('/articles/{article}/download', 'ArticleController@download')->name('articles.download');
    Route::put('/articles/{article}/approve', 'ArticleController@approve')->name('articles.approve');

    //==============================FAQ==================================
    Route::get('/faq', function () {
        return view('faq');
    })->name('faq');

    //============================DASHBOARD============================

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/about', 'AboutController@index')->name('about');
    Route::put('/about/{user}/tahun', 'AboutController@gantiTahun')->name('settings.tahun');


    //=============================REPORTS========================================
    Route::resource('reports', ReportController::class);
    Route::get('/reports/{tahun}/{semester}/createLaporan', 'ReportController@createLaporan')->name('reports.create.laporan');
    Route::put('/reports/{report}/approve', 'ReportController@approve')->name('reports.approve');
    Route::get('/reports/{report}/print', 'ReportController@print')->name('reports.print');
    Route::get('/reports/{report}/download-lampiran', 'ReportController@downloadLampiran')->name('reports.download-lampiran');
    Route::post('/reports/{report}/delete-lampiran', 'ReportController@deleteLampiran')->name('reports.delete-lampiran');
    //2021
    Route::get('/reports/{report}/2021', 'ReportController@report2021show')->name('reports.2021.show');
    //upload laporan
    Route::post('/reports/{report}/upload-laporan', 'ReportController@uploadLaporan')->name('reports.upload-laporan');
    //unduh laporan
    ROute::get('/reports/{report}/download-laporan', 'ReportController@downloadLaporan')->name('reports.download-laporan');
    

    //=============================NOTIFIKASI========================================
    Route::get('/emailme', function () {
        \Illuminate\Support\Facades\Mail::send(new \App\Mail\ProgramSubmitted);
    })->name('emailme');

    Route::get('/sendme', function () {
        $details = ['title' => "ntitt", 'body' => 'fungc'];
        \Illuminate\Support\Facades\Mail::to('hyugihc@gmail.com')->send(new \App\Mail\TestMail($details));
        echo "mail sent";
    })->name('sendme');

    Route::get('/notifyme', function () {
        \Illuminate\Support\Facades\Notification::send(\App\User::find(1), new \App\Notifications\ProgramSubmitted);
    })->name('notifyme');
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
