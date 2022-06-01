<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SkillsController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Auth\ApiAuthController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Route::resource('project', 'ProjectController']);

Route::group(['middleware' => ['cors', 'json.response']], function(){
    //---------------TEST SERVER---------------//
    Route::get('/test', function(){
        return response(['message' => 'Server is Live']); 
    });
    //---------------TEST SERVER---------------//   

    //---------------AUTH ROUTE---------------//
    Route::post('/login', [ApiAuthController::class, 'login'])->name('login.api');
    Route::post('/register', [ApiAuthController::class, 'register'])->name('register.api');
    //---------------AUTH ROUTE---------------// 
});

// Route::middleware('auth.api', function(){

//     Route::get('/user', [UserController::class, 'index']);
//     Route::post('/user', [UserController::class, 'store']);

//     Route::post('/user/skills', [SkillsController::class, 'store']);

//     Route::get('/project', [ProjectController::class, 'index']);
//     Route::Post('/project', [ProjectController::class, 'store']);
//     Route::get('/project/{id}', [ProjectController::class, 'show']);
//     Route::put('/project/{id}', [ProjectController::class, 'update']);
//     Route::delete('/project/{id}', [ProjectController::class, 'destroy']);

//      //---------------LOGOUT---------------// 
//     Route::post('/logout', 'Auth\ApiAuthController@logout')->name('logout.api');
//      //---------------LOGOUT---------------// 
// });
