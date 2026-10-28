<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Home: search, categories and all recipes
Route::get('/', 'PostsController@index')->name('recipes');

Route::resource('posts', 'PostsController');
Route::get('/posts/{post}/cook', 'PostsController@cook')->name('posts.cook');
Route::post('/posts/{post}/save', 'SavedController@toggle')->name('posts.save');
Route::post('/posts/{post}/rate', 'RatingController@store')->name('posts.rate');
Route::get('/saved', 'SavedController@index')->name('saved');

Auth::routes();

Route::resource('user', 'UserController')->only(['edit', 'update']);

// Profile and my recipes
Route::get('/home', 'HomeController@index')->name('home');
