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

Route::resource('users', 'UserController');
Route::resource('classes', 'ClassController');
Route::resource('courses', 'CourseController');
Route::resource('studies', 'StudyController');
Route::resource('teachers', 'TeacherController');
Route::resource('students', 'StudentController');

Route::get('/', function () {
    return view('login');
});

Route::get('/welcome', function () {
    return view('welcome');
});

// Route::get('/student{code}/schedule', function() {
//     return view('student.schedule');
// });

Route::get('/student{code}', ['uses' => 'StudentController@get']);
Route::get('/teacher{code}', ['uses' => 'TeacherController@get']);
