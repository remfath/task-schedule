<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'task'], function () {
	Route::get('list', 'TaskController@index');
	Route::get('run/{taskId}', 'TaskController@run');
	Route::get('log/{taskId?}', 'TaskController@getLogs');
	Route::get('summary', 'TaskController@getSystemSummary');
	Route::get('status', 'TaskController@getTaskSummary');
	Route::post('update/{taskId}', 'TaskController@updateTask');
	Route::get('delete/{taskId}', 'TaskController@deleteTask');
	Route::post('add', 'TaskController@addTask');
	Route::get('restore/{taskId}', 'TaskController@restoreTask');
});