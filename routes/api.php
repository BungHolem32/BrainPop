<?php

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

Route::prefix('v1')->group(

    function () {

        /*LOGIN + REGISTER METHODS */
        Route::post('login', 'AuthenticationController@login');
        Route::post('register', 'AuthenticationController@register');

        /*ALL THESE ENDPOINT REQUIRE AUTHENTICATION*/
        Route::group(['middleware' => 'auth.jwt'], function () {

            /*LOGOUT*/
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
                //FETCH ALL PERIODS
                Route::get('periods', 'PeriodController@index')->name('period.name');

                //FETCH SPECIFIC PERIOD
                Route::get('periods/{period_id}', 'PeriodController@show')->name('period.show');

                //CREATE NEW PERIOD
                Route::post('periods', 'PeriodController@store')->name('period.store');

                /*UPDATE  PERIOD*/
                Route::put('periods/{period_id}', 'PeriodController@update')->name('period.update');

                /*DESTROY PERIOD */
                Route::delete('periods/{period_id}', 'PeriodController@destroy')->name('period.destroy');


                /*GET USER DETAILS ACCORDING TO THE TOKEN*/
                Route::get('user', 'AuthenticationController@getAuthUser');
            });


            /*REQUIRED END POINTS (ACCORDING TO EXAM ) */
            //FETCH ALL STUDENTS IN A GIVEN PERIOD
            Route::get('periods/{period_id}/students', 'UserPeriodController@getStudentsByPeriod')
                ->name('student-period.getStudentByPeriod');

            //FETCH ALL PERIODS ASSOCIATED WITH A GIVEN TEACHER
            Route::get('teachers/{teacher_id}/periods', 'PeriodController@getTeacherPeriods')
                ->name('teacher-period.index');

            //FETCH SPECIFIC PERIODS ASSOCIATED WITH A GIVEN TEACHER
            Route::get('teachers/{teacher_id}/periods/{period_id}', 'PeriodController@getTeacherPeriod')
                ->name('teacher-period.show');

            /*GET ALL STUDENTS LINKED TO PERIODS */
            Route::get('linked_users', 'UserPeriodController@getLinkedUsers');
        });

    });
