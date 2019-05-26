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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('v1')->group(function () {

    /*Login + Register Methods */
    Route::post('login', 'AuthenticationController@login');
    Route::post('register', 'AuthenticationController@register');

    Route::group(['middleware' => 'auth.jwt'], function () {

        Route::get('logout', 'AuthenticationController@logout');


        /*ONLY TEACHER + ADMIN  CAN USE*/
        Route::group(['middleware' => ['auth-teacher']], function () {

            /*TEACHER PERIODS*/
            Route::post('teachers/{teacher_id}/periods', 'PeriodController@storeTeacherPeriod')
                ->name('teacher-period.store-teacher-period');
            Route::put('teachers/{teacher_id}/periods/{period_id}', 'PeriodController@update')
                ->name('teacher-period.update');
            Route::delete('teachers/{teacher_id}/periods/{period_id}', 'PeriodController@destroy')
                ->name('teacher-period.destroy');

            /*TEACHERS CRUD*/
            Route::get('teachers', 'TeacherController@index')->name('teacher.index');
            Route::get('teachers/{teacher_id}', 'TeacherController@show')->name('teacher.show');
            Route::post('teachers/', 'TeacherController@store')->name('teacher.store');
            Route::put('teachers/{teacher_id}', 'TeacherController@update')->name('teacher.update');
            Route::delete('teachers/{teacher_id}', 'TeacherController@destroy')->name('teacher.destroy');
        });


        /*ONLY STUDENT + ADMIN  CAN USE*/
        Route::group(['middleware' => 'auth-student'], function () {

            //ADD STUDENT TO SPECIFIC PERIOD
            Route::post('periods/{period_id}/users/{user_id}', 'PeriodController@attachStudent')
                ->name('periods.attachStudent');

            //REMOVE STUDENT FROM SPECIFIC PERIOD
            Route::delete('periods/{period_id}/users/{user_id}', 'PeriodController@detachStudent')
                ->name('periods.detachStudent');

            /*STUDENT CRUD*/
            Route::get('students', 'StudentController@index')->name('student.index');
            Route::get('students/{student_id}', 'StudentController@show')->name('student.show');
            Route::post('students/', 'StudentController@store')->name('student.store');
            Route::put('students', 'StudentController@update')->name('student.update');
            Route::delete('students/{student_id}', 'StudentController@destroy')->name('student.destroy');
        });

        /*ONLY ADMIN*/
        Route::group(['middleware' => 'auth-admin'], function () {

            /*PERIODS*/
            Route::post('periods', 'PeriodController@store')->name('period.store');
            Route::put('periods/{period_id}', 'PeriodController@update')->name('period.update');
            Route::delete('periods/{period_id}', 'PeriodController@destroy')->name('period.destroy');
        });

        /*All Authenticated users can use this */

        /*Get User details according to the token*/
        Route::get('user', 'AuthenticationController@getAuthUser');

        //Fetch all periods
        Route::get('periods', 'PeriodController@index')->name('period.name');

        //Fetch specific period
        Route::get('periods/{period_id}', 'PeriodController@show')->name('period.show');

        /*Required End Points */

        //Fetch all students in a given period
        Route::get('periods/{period_id}/students', 'UserPeriodController@getStudentsByPeriod')
            ->name('student-period.getStudentByPeriod');

        //Fetch all periods associated with a given teacher
        Route::get('teachers/{teacher_id}/periods', 'PeriodController@getTeacherPeriods')
            ->name('teacher-period.index');

        //Fetch specific periods associated with a given teacher
        Route::get('teachers/{teacher_id}/periods/{period_id}', 'PeriodController@getTeacherPeriod')
            ->name('teacher-period.show');

        /*Get All students linked to periods */
        Route::get('linked_users', 'UserPeriodController@getLinkedUsers');
    });

});
