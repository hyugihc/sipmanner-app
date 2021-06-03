<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\UserResource;
use App\User;
use App\Http\Resources\UserCollection;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/user/{user}', function (User $user) {
    return new UserResource($user);
});

// Route::get('/user/{nip_lama}', function ($nip_lama) {
//     return new UserResource( User::select('*')->where('nip_lama', $nip_lama)->get());
// });

Route::get('/users', function () {
    // return UserResource::collection(User::all());
    return new UserCollection(User::all());
});
