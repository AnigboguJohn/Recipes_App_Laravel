<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" e group. Now create something great!
|
*/

//we need routes in order for the app to work
//---- this is the main route
//---- the first page the app will load
//---- we assign the controller function we want to use
// in this case is the index function
//lets see what it does
Route::get('/', "PostsController@index");

//forgot to mention
//this is a special syntax
//that creates all the routes for the post model
//that way we dont have to define the with the get functionality
//that way we can access the routes
Route::resource('posts', 'PostsController');

Auth::routes();

Route::resource('user', 'UserController');


Route::get('/home', 'HomeController@index')->name('home');
