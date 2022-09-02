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
//Route::get('/students/{name}', function ($name) {
//    return 'Имя студента: '. $name;});
//Route::post('/students/check','MainController@students_check' );

Route::get('/subjects','MainController@subjects' )->name('subject');
Route::post('/subject/check','MainController@subject_check' );
Route::get('/subjects/{name}', function ($name) {
    return 'Название дисциалины: '. $name;});

Route::get('/mark','MainController@mark' )->name('mark');
Route::post('/mark/check','MainController@mark_check' );
Route::post('/mark/grade_check','MainController@grade_check' );

Route::get('/sub','MainController@sub' )->name('sub');
Route::post('/sub/check','MainController@sub_check' );

//Route::get('deletestud/{id}','MainController@destroy');
//Route::post('/deletestud/{id}', 'MainController@destroy')->name('sendName');
Route::get('deletesub/{id}','MainController@destroysub');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/showTable', 'MainController@showTable');
Route::post('/sendName', 'MainController@sendName')->name('sendName');
Route::post('/deleteName', 'MainController@deleteName')->name('deleteID');

Route::post('/showTableSub', 'MainController@showTableSub');
Route::post('/sendSubject', 'MainController@sendSubject')->name('sendSubject');
Route::post('/deleteSubject', 'MainController@deleteSubject')->name('deleteID');
