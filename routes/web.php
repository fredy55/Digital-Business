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

Route::get('/', 'Admin\AdminLoginController@index')->name('home');
Route::get('/login', 'Admin\AdminLoginController@index')->name('login');
Route::post('/login', 'Admin\AdminLoginController@login')->name('login');
Route::get('/logout', 'Admin\AdminLoginController@logout')->name('admin.logout');
Route::get('/dashboard', 'Admin\AdminController@dashboard')->name('admin.dashboard');

//============================= ADMIN OFFICES PAGES =============================//
Route::group(['prefix' => 'offices'], function () {
    Route::get('/', 'Admin\OfficesController@index')->name('admin.offices');
    Route::get('/details/{id}', 'Admin\OfficesController@show')->name('admin.offices.details');
    Route::post('/create', 'Admin\OfficesController@store')->name('admin.offices.save');
    Route::post('/update', 'Admin\OfficesController@update')->name('admin.offices.update');
    Route::get('/delete/{id}', 'Admin\OfficesController@destroy')->name('admin.offices.delete');
});

#======================= ADMIN USERS PAGES =============================//
Route::group(['prefix' => 'users'], function () {
    Route::get('/', 'Admin\UsersController@index')->name('admin.users');
    Route::get('/details/{id}', 'Admin\UsersController@show')->name('admin.users.details');
    Route::post('/save', 'Admin\UsersController@store')->name('admin.users.save');
    Route::post('/update', 'Admin\UsersController@update')->name('admin.users.update');
    Route::get('/activate/{id}', 'Admin\UsersController@activate')->name('admin.users.activate');
    Route::get('/deactivate/{id}', 'Admin\UsersController@deactivate')->name('admin.users.deactivate');
    Route::get('/delete/{id}', 'Admin\UsersController@destroy')->name('admin.users.delete');
});

Route::group(['prefix' => 'users/profile'], function () {
    Route::get('/', 'Admin\UsersController@profile')->name('admin.users.profile');
    Route::post('/update', 'Admin\UsersController@profileUpdate')->name('admin.users.profile.update');
});

//============================= ADMIN TRANSACTIONS PAGES =============================//
Route::group(['prefix' => 'transactions'], function () {
    Route::get('/credits/{type}', 'Admin\TransactionsController@credits')->name('admin.transacts.credits');

    Route::get('/debits/{type}', 'Admin\TransactionsController@debits')->name('admin.transacts.debits');
    
    Route::get('/details/{type}/{id}', 'Admin\TransactionsController@show')->name('admin.transacts.details');
    Route::post('/save/credit', 'Admin\TransactionsController@saveCredit')->name('admin.transacts.save.credit');
    Route::post('/save/debit', 'Admin\TransactionsController@saveDebit')->name('admin.transacts.save.debit');
    Route::post('/update', 'Admin\TransactionsController@update')->name('admin.transacts.update');
    Route::get('/delete/{type}/{id}', 'Admin\TransactionsController@destroy')->name('admin.transacts.delete');
    Route::get('/summary/find', 'Admin\TransactionsController@summaryForm')->name('admin.transacts.summary');
    Route::post('/summary/details', 'Admin\TransactionsController@dailySummary')->name('admin.transacts.summary.details');
});

//============================= ADMIN TRANSACTIONS REPORTS =============================//
Route::group(['prefix' => 'reports'], function () {
    Route::get('/', 'Admin\ReportsController@reportList')->name('admin.reports');
    Route::get('/cashier/find', 'Admin\ReportsController@creportForm')->name('admin.creports.find');
    Route::post('/cashier/details', 'Admin\ReportsController@cdailyReport')->name('admin.creports.details');
    Route::get('/find', 'Admin\ReportsController@reportForm')->name('admin.reports.find');
    Route::post('/details', 'Admin\ReportsController@dailyReport')->name('admin.reports.details');
});

//============================= ADMIN ROLES =============================//
Route::group(['prefix' => 'roles'], function () {
    Route::get('/', 'Admin\AdminRoleController@index')->name('admin.roles');
    Route::get('/view/{id}', 'Admin\AdminRoleController@show')->name('admin.roles.details');
    Route::post('/save', 'Admin\AdminRoleController@store')->name('admin.roles.save');
    Route::post('/update', 'Admin\AdminRoleController@update')->name('admin.roles.update');
    Route::get('/delete/{id}', 'Admin\AdminRoleController@destroy')->name('admin.roles.delete');
    
    Route::get('/restrictions/{id}', 'Admin\AdminAccessController@index')->name('admin.roles.restrict');
});

//============================= ADMIN ROLES ACCESS RESTRICTIONS =============================//
Route::group(['prefix' => 'restrictions'], function () {
    Route::get('/{id}', 'Admin\AdminAccessController@index')->name('admin.restrict');
    Route::post('/save', 'Admin\AdminAccessController@save')->name('admin.restrict.save');
    Route::get('/access/denied', 'Admin\AdminAccessController@accessDenied')->name('admin.restrict.denied');
});

//============================= ADMIN MODULES =============================//
Route::group(['prefix' => 'modules'], function () {
    Route::get('/', 'Admin\AdminModulesController@index')->name('admin.modules');
    Route::get('/view/{id}', 'Admin\AdminModulesController@show')->name('admin.modules.details');
    Route::post('/save', 'Admin\AdminModulesController@store')->name('admin.modules.save');
    Route::post('/update', 'Admin\AdminModulesController@update')->name('admin.modules.update');
    Route::get('/delete/{id}', 'Admin\AdminModulesController@destroy')->name('admin.modules.delete');
});