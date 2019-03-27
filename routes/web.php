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

Auth::routes(['verify' => true]);

Route::get('/', 'PageController@homePage')->name('home');

Route::get('/branches', 'PageController@branchPage');

Route::get('/companies', 'PageController@companyPage');

Route::get('/reports', 'PageController@reportsPage');

Route::get('/reports/{id}', 'PageController@reportPage');

Route::get('/api/branches', 'BranchController@index');
Route::post('/api/branches', 'BranchController@store');
Route::put('/api/branches/{branch}', 'BranchController@update');
Route::delete('/api/branches/{branch}', 'BranchController@destroy');

Route::get('/api/companies', 'CompanyController@index');
Route::post('/api/companies', 'CompanyController@store');
Route::put('/api/companies/{branch}', 'CompanyController@update');
Route::delete('/api/companies/{company}', 'CompanyController@destroy');

Route::get('/api/reports', 'ReportController@index');
Route::get('/api/reports/{report}', 'ReportController@show');
Route::post('/api/reports', 'ReportController@store');
Route::put('/api/reports/{report}', 'ReportController@update');
Route::delete('/api/reports/{report}', 'ReportController@destroy');
Route::put('/api/reports/{id}/add-rank', 'ReportController@addRank');

Route::post('/api/reports/{report}/types/create', 'ReportTypeController@createReportType');
Route::delete('/api/reports/types/delete/{type}', 'ReportTypeController@deleteReportType');
Route::put('/api/reports/{report}/types/{type}/edit', 'ReportTypeController@update');


Route::resource('/api/reports/create-subfield', 'ReportTypeSubFieldController');

Route::post('/api/reports/{id}/create-trend', 'OverallDataController@createData');
Route::delete('/api/reports/trend-data/{id}', 'OverallDataController@deleteData');

Route::get('/admin/users', 'PageController@adminUsersPage');
Route::get('/admin/users/{user}', 'PageController@adminUserPage');


Route::get('/api/admin/users', 'AdminController@getUsers');
Route::get('/api/admin/users/{user}', 'AdminController@getUser');
Route::post('/api/admin/users/{user}/assign-role', 'AdminController@assignRole');