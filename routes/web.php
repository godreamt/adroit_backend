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

Route::get('/', 'WebHomeController@homePage');
Route::get('/about-us', 'WebHomeController@aboutPage');
Route::get('/products', 'WebHomeController@productPage');
Route::post('/products', 'WebHomeController@productPage');
Route::get('/products/{slug}', 'WebHomeController@productPage');
Route::get('/product/{slug}', 'WebHomeController@productDetailPage');
Route::get('/careers', 'WebHomeController@careerPage');
Route::get('/contact-us', 'WebHomeController@contactPage');
Route::get('/privacy-policy', 'WebHomeController@privacyPage');
