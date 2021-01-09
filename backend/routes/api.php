<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;

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

Route::group([
    'middleware' => ['auth:api']
], function () {
    Route::get('logout', 'App\Http\Controllers\Api\AuthController@logout');
    Route::get('profile/{user}', 'App\Http\Controllers\Api\ProfileController@show');
    Route::put('profile/{user}', 'App\Http\Controllers\Api\ProfileController@update');

    Route::group(['middleware' => ['role:Super Admin']
    ], function () {
        Route::resources([
            'posts' => PostController::class,
        ]);
        Route::get('files/{id}', 'App\Http\Controllers\Api\FileController');
        Route::post('/posts/change-publicity/{post}', 'App\Http\Controllers\Api\PostController@changePublicity');
        Route::get('users', 'App\Http\Controllers\Api\UserController@index');
    });
});

Route::post('/register', 'App\Http\Controllers\Api\AuthController@register');
Route::post('/login', 'App\Http\Controllers\Api\AuthController@login');
