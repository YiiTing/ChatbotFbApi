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
    // return view('welcome');
// });

Auth::routes();

// Socialite Login
Route::get('/login/{provider}', 'SocialAuthController@redirectToFacebook')->where('provider', '[A-Za-z]+');
Route::get('/login/{provider}/callback', 'SocialAuthController@handleFacebookCallback')->where('provider', '[A-Za-z]+');

// Main
Route::middleware(['auth'])->group(function () {
	Route::match(array('get'), '/robot', 'HomeController@robot');
	Route::match(array('get', 'post', 'put'), '/createRobot', 'HomeController@createRobot');
	Route::match(array('post'), '/saveRobot', 'HomeController@saveRobot');
	Route::match(array('get'), '/{pageid?}', 'HomeController@dashBoard')->where('pageid', '[0-9]+');
});
Route::middleware(['auth', 'checkFbPage'])->group(function () {
	Route::match(array('get'), '/customer', 'HomeController@customer');
	Route::match(array('post'), '/customerAllBot', 'FunctionController@customerAllBot');
	Route::match(array('post'), '/customerBot', 'FunctionController@customerBot');
	Route::match(array('post'), '/customerBlock', 'FunctionController@customerBlock');
	Route::match(array('get'), '/feed', 'HomeController@feed');
	Route::match(array('get'), '/history', 'HomeController@history');
	Route::match(array('get', 'post'), '/keyword', 'HomeController@keyword');
	Route::match(array('post'), '/keywordDefaultAdd', 'FunctionController@keywordDefaultAdd');
	Route::match(array('post'), '/keywordDefaultDelete', 'FunctionController@keywordDefaultDelete');
	Route::match(array('post'), '/keywordDefaultList', 'FunctionController@keywordDefaultList');
	Route::match(array('post'), '/keywordCustomAdd', 'FunctionController@keywordCustomAdd');
	Route::match(array('post'), '/keywordCustomDelete', 'FunctionController@keywordCustomDelete');
	Route::match(array('post'), '/keywordCustomSave', 'FunctionController@keywordCustomSave');
	Route::match(array('post'), '/keywordCustomCancel', 'FunctionController@keywordCustomCancel');
	Route::match(array('get'), '/lottery', 'HomeController@lottery');
	Route::match(array('get'), '/message', 'HomeController@message');
	Route::match(array('get'), '/setting', 'HomeController@setting');
	
	// Broadcasting Messages
	Route::prefix('bm')->group(function () {
		Route::match(array('get'), '/cbm', 'HomeController@cbm');
		Route::match(array('get'), '/tbm', 'HomeController@tbm');
		Route::match(array('get'), '/alp', 'HomeController@alp');
		Route::match(array('get'), '/sbm', 'HomeController@sbm');
		Route::match(array('get'), '/smm', 'HomeController@smm');
	});
});

// Bot
Route::prefix('bot')->group(function () {
	Route::match(array('post', 'delete'), '/subscribedapps ', 'BotController@subscribedapps');
	Route::match(array('get'), '/deltest ', 'BotController@deltest');
	Route::match(array('post', 'delete'), '/persistentmenu  ', 'BotController@persistentmenu');
	Route::match(array('post', 'delete'), '/persistentmenubtn  ', 'BotController@persistentmenubtn');
});
Route::match(array('get', 'post'), '/greeting ', 'BotController@greeting');
Route::match(array('get', 'post'), '/webhook ', 'BotController@webhook');


// Admin
Route::match(array('get'), '/admin ', 'AdminController@admin');
Route::match(array('get', 'post'), '/test ', 'BotController@test');

// Bot
Route::get('/bot', 'BotController@bot')->middleware('verifybot');
Route::post('/bot', 'BotController@bot');
Route::get('/accounts', 'BotController@accounts');
Route::get('/getfanskey', 'BotController@getfanskey');
Route::get('/setmessengerprofile', 'BotController@setmessengerprofile');
Route::get('/pushfansarticle', 'BotController@pushfansarticle');
Route::get('/fanswrite', 'BotController@fanswrite');
Route::get('/getmentionsfeed', 'BotController@getmentionsfeed');
Route::get('/getmentionscomments', 'BotController@getmentionscomments');
Route::get('/getmentionscomments_message', 'BotController@getmentionscomments_message');
Route::get('/getsubscribedapps', 'BotController@getsubscribedapps');
Route::get('/postsubscribedapps', 'BotController@postsubscribedapps');
Route::get('/delsubscribedapps', 'BotController@delsubscribedapps');
Route::get('/getfanslike', 'BotController@getfanslike');
Route::get('/getcomments', 'BotController@getcomments');
Route::get('/pushsubcomments', 'BotController@pushsubcomments');
