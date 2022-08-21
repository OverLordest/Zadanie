<?php

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

Route::get('/', 'MainController@index');

Route::get('/students', 'MainController@students')->name('students');

Route::get('/students/{name}', function ($name) {
    return 'Имя студента: '. $name;
});

Route::post('/students/check','MainController@students_check' );

Route::get('/subjects','MainController@subjects' )->name('subject');

Route::post('/subject/check','MainController@subject_check' );

Route::get('/subjects/{name}', function ($name) {
    return 'Название дисциалины: '. $name;
});


Route::get('delete-records','MainController@delstud');
Route::get('delete/{id}','MainController@destroy');
Route::get('delete-records','MainController@delsub');
Route::get('delete/{id}','MainController@destroysub');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
