<?php

use Illuminate\Http\Request;

/*php
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


/////Hajar
Route::apiResource('major', 'API\MajorController');
Route::apiResource('demandeur', 'API\DemandeurController');
Route::apiResource('hopital', 'API\HopitalController');
Route::apiResource('service', 'API\ServiceController');
Route::apiResource('coordinateur', 'API\CoordinateurController');


///Me
Route::put('brancardier/{id}', 'API\BrancardierController@updateUser');
Route::apiResources(['user' => 'API\UserController']);
Route::get('profileAuth', 'API\BrancardierController@profileAuth');
//Route::get('profile', 'API\UserController@profile');
Route::get('findUser', 'API\UserController@search');
<<<<<<< HEAD
Route::put('profile', 'API\UserController@updateProfile');
//Route::apiResource('brancardier', 'API\BrancardierController');
Route::apiResource('login', 'Auth\LoginController');
Route::get('redirection', 'Auth\LoginController@redirection');


=======
Route::put('profile', 'API\BrancardierController@updateProfile2');
>>>>>>> 3babbebbcc85c1f03dad313534d848255da7a4a3

Route::get('users_v', 'API\BrancardierController@index');
Route::get('brancardier', 'API\BrancardierController@index2');
Route::get('users_nv', 'API\BrancardierController@index3');
Route::get('profile/{id}', 'API\BrancardierController@index4');
Route::get('brancardier/{id}', 'API\BrancardierController@index5');

Route::put('updateProfile/{id}', 'API\BrancardierController@updateProfile');


Route::delete('brancardier/{id}', 'API\BrancardierController@destroy');
Route::post('brancardier', 'API\BrancardierController@store');
Route::post('CreateUser', 'API\BrancardierController@storeUser');
Route::put('updateUser/{id}', 'API\BrancardierController@updateUser2');
