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


Route::group(['prefix' => 'Users'], function () {
    //--- Agents ----//
    Route::get('/', 'Admin\AdminController@agentList')->name('admin.agents');
    Route::get('/details/{id}', 'Admin\AdminController@agentdetails')->name('admin.agents.details');
    Route::get('/delete/{id}', 'Admin\AdminController@destroy')->name('admin.agents.delete');
});

//============================= ADMIN AGENTS PAGES =============================//
Route::group(['prefix' => 'genadmin-betagent/agents'], function () {
    Route::get('/', 'Admin\AgentsController@index')->name('admin.agents');
    Route::get('/details/{id}', 'Admin\AgentsController@view')->name('admin.agents.details');
    Route::get('/delete/{id}', 'Admin\AgentsController@destroy')->name('admin.agents.delete');
});

//============================= ADMIN TUTORIALS PAGES =============================//
Route::group(['prefix' => 'genadmin-betagent/tutorials'], function () {
    Route::get('/', 'Admin\TutorialsController@index')->name('admin.tutorials');
    Route::get('/faq', 'Admin\TutorialsController@faqList')->name('admin.tutorials.faq');
    Route::get('/details/{id}', 'Admin\TutorialsController@show')->name('admin.tutorials.details');
    Route::get('/add', 'Admin\TutorialsController@create')->name('admin.tutorials.add');
    Route::post('/save', 'Admin\TutorialsController@store')->name('admin.tutorials.save');
    Route::get('/edit/{id}', 'Admin\TutorialsController@edit')->name('admin.tutorials.edit');
    Route::post('/update', 'Admin\TutorialsController@update')->name('admin.tutorials.update');
    Route::get('/delete/{id}', 'Admin\TutorialsController@destroy')->name('admin.tutorials.delete');
});

//============================= ADMIN MESSAGE PAGES =============================//
Route::group(['prefix' => 'jregadmin-tebplog/messages'], function () {
    Route::get('/', 'Admin\MessagesController@index')->name('admin.messages');
    Route::get('/details/{id}', 'Admin\MessagesController@show')->name('admin.messages.details');
    Route::get('/delete/{id}', 'Admin\MessagesController@destroy')->name('admin.messages.delete');
    Route::get('/messages', 'Admin\MessagesController@index')->name('admin.messages.list');
    
    Route::post('/messages/confirm', 'Admin\MessagesController@getMessage')->name('admin.messages.confirm');
    Route::post('/messages/update', 'Admin\MessagesController@updateMessage')->name('admin.messages.update');
});