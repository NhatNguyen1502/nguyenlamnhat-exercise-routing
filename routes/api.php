<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('user')->group(function () {
    Route::get('/', function(){
        global $users;
        return $users; 
    });
    
    Route::get('/{userIndex}', function ($userIndex) {
        global $users;
        if (array_key_exists($userIndex, $users)) {
            return $users[$userIndex];
        } else {
            return 'You cannot get a user like this!';
        }
    }) -> where('userIndex', '[0-9]+');
    
    Route::get('/{userName}', function ($userName) {
        global $users;
        foreach($users as $user ) {
            if ($user['name'] == $userName) return $user; 
        }
        return "Canot find the user with name ". $userName;
    }) -> where('userName', '[a-zA-Z]+');

    Route::get('/{userIndex}/post/{postIndex}', function ($userIndex, $postIndex) {
        global $users;
        if (array_key_exists($userIndex, $users)) {
            $user = $users[$userIndex];
            if (array_key_exists($postIndex, $user['posts'])) {
                return $user['posts'][$postIndex];
            } else {
                return 'Cannot find the post with id ' . $postIndex . ' for user ' . $userIndex;
            }
        } else {
            return $users[$userIndex];
        }
    });

    Route::fallback(function () {
        return 'You cannot get a user like this !';
    });

});
