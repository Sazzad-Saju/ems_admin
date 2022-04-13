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

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', function () {
        return view('welcome');
    });

    /* Employee route */
    Route::put('employee/make-head','EmployeeController@makeHeadOfDepartment')->name('department.head.update');
    Route::resource('employees', 'EmployeeController');
    Route::get('employees/{employee}', 'EmployeeController@statusUpdate')->name('employees.status');
    /* End Employee route */

    /* Leave route */
    Route::get('leaves/calender', 'LeaveController@calendarView')->name('view.calendar');
    Route::resource('leaves', 'LeaveController');
    /* End Leave route */

    /* Attendance route */
    Route::resource('attendances', 'AttendanceController');
    Route::post('get-attendance', 'AttendanceController@getAttendanceData')->name('get.attendances');
    /* End Attendance route */

    /* Conveyance Bill route */
    Route::resource('conveyance-bills', 'ConveyanceBillController');
    Route::get('conveyance-bills/{conveyance_bill}', 'ConveyanceBillController@statusUpdate')->name('conveyance-bills.status');
    /* End Conveyance Bill route */

    /* Loan route */
    Route::resource('loans', 'LoanController');
    /* End Loan route */

    /* firs (First information report) route */
    Route::resource('firs', 'FirsController');
    /* End firs route */

    /* Task route */
    Route::resource('tasks', 'TaskController');
    /* End Task route */

    /* Holiday route */
    Route::resource('holidays', 'HolidayController');
    /* End Holiday route */

    /* Profile route */
    Route::resource('profile', 'ProfileController');
    Route::post('/profile/{user}', 'ProfileController@passwordUpdate')->name('update.password');
    /* End Profile route */

    /* Setting route */
//    Route::resource('settings','SettingController');
    Route::get('/settings', 'SettingController@index')->name('settings.index');
    Route::post('/settings', 'SettingController@update')->name('settings.update');
    /* End Setting route */

    /* Department route */
    Route::resource('departments','DepartmentController');
    Route::get('departments/{department}', 'DepartmentController@statusUpdate')->name('departments.status');
    /* End Department route */

    // notice route
    Route::resource('notices','NoticeController');

});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test', 'TestController@index')->name('test');


