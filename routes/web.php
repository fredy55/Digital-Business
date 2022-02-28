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
    Route::get('/delete/{id}', 'Admin\UsersController@destroy')->name('admin.users.delete');
});

//============================= ADMIN STAFF PAGES =============================//
Route::group(['prefix' => 'transactions'], function () {
    Route::get('/credits', 'Admin\TransactionsController@credits')->name('admin.transacts.credits');
    Route::get('/debits', 'Admin\TransactionsController@debits')->name('admin.transacts.debits');
    Route::get('/details/{type}/{id}', 'Admin\TransactionsController@show')->name('admin.transacts.details');
    Route::post('/save', 'Admin\TransactionsController@store')->name('admin.transacts.save');
    Route::post('/update', 'Admin\TransactionsController@update')->name('admin.transacts.update');
    Route::get('/delete/{type}/{id}', 'Admin\TransactionsController@destroy')->name('admin.transacts.delete');
});

//============================= ADMIN ROLES =============================//
Route::group(['prefix' => 'roles'], function () {
    Route::get('/', 'Admin\AdminRoleController@index')->name('admin.roles');
    Route::get('/view/{id}', 'Admin\AdminRoleController@show')->name('admin.roles.details');
    Route::post('/save', 'Admin\AdminRoleController@store')->name('admin.roles.save');
    Route::post('/update', 'Admin\AdminRoleController@update')->name('admin.roles.update');
    Route::get('/delete/{id}', 'Admin\AdminRoleController@destroy')->name('admin.roles.delete');
});


//============================= ADMIN MODULES =============================//
// Route::group(['prefix' => 'admin/modules'], function () {
//     Route::get('/', 'Admin\AdminModulesController@index')->name('module.list');
//     Route::get('/view/{id}', 'Admin\AdminModulesController@show')->name('module.details');
//     Route::get('/addnew', 'Admin\AdminModulesController@create')->name('module.addnew');
//     Route::post('/save', 'Admin\AdminModulesController@store')->name('module.save');
//     Route::get('/edit/{id}', 'Admin\AdminModulesController@edit')->name('module.editform');
//     Route::post('/savedit', 'Admin\AdminModulesController@update')->name('module.update');
//     Route::get('/delete/{id}', 'Admin\AdminModulesController@destroy')->name('module.delete');
// });