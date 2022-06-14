<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

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

// Route::get('/users', function() {
//     // If the Content-Type and Accept headers are set to 'application/json', 
//     // this will return a JSON structure. This will be cleaned up later.
//     return User::all();
// });

// Route::get('users', 'App\Http\Controllers\UserController@index');
// Route::post('users', 'App\Http\Controllers\UserController@store');
// Route::post('register', 'App\Http\Controllers\RegisterController@register');

Route::controller(App\Http\Controllers\RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});
        
Route::middleware('auth:sanctum')->group( function () {
    Route::resource('jobs', App\Http\Controllers\JobController::class);
    Route::resource('notes', App\Http\Controllers\NoteController::class);
});
