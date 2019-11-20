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



// Route::get('/', function () {
//     return view('case_study');
// });

Auth::routes();

Route::get('/', function () {
  return view('welcome');
});

Route::get('/mailverification', function () {
  return view('mailverification');
});

Route::get('/terms-of-service', function () {
  return view('term of service');
});

Route::get('/privacy_policy', function () {
  return view('privacy_policy');
});

Route::middleware('auth')->group(function () {
  Route::get('/step', function () {
    return view('step');
  });

  Route::get('/faq', function () {
    return view('FAQ');
  });
  
  Route::get('/home', 'HomeController@index')->name('home');

  Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

  Route::post('/dashboard', 'HomeController@addKeyword')->name('stepResult');

  Route::get('/dashboard/{keyword}', 'HomeController@showCampaignPage')->name('campaignPage');

  Route::get('/tdata', 'HomeController@getTableData')->name('searchTableData');

  Route::get('/graph', 'HomeController@getGraphData')->name('graphData');

  Route::get('/deleteRow', 'HomeController@deleteRowTabledata');


  Route::get('/twitter', 'HomeController@search_twitter');

  Route::get('/facebook', 'HomeController@search_facebook');

  Route::get('/instagram', 'HomeController@search_instagram');

  Route::get('/youtube', 'HomeController@search_youtube');

  Route::get('/web', 'HomeController@search_web');
  
});