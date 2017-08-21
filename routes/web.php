<?php

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

Route:: get('task', function(){
	return view('task')->with('hideBg', true);
})->middleware('auth')->name('task');

Route::get('/', function(){
    return redirect()->route('task');
});

Auth::routes();
