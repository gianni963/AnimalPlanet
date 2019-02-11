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
Route::get('/', 'WelcomeController@index')->name('welcome');

Auth::routes();

Route::get('/auth/activate', 'Auth\ActivationController@activate')->name('auth.activate');
Route::get('/auth/activate/resend', 'Auth\ActivationResendController@showResendForm')->name('auth.activate.resend');
Route::post('/auth/activate/resend', 'Auth\ActivationResendController@resend');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/guidelines', 'GuidelinesController@index')->name('guidelines');

Route::get('/contact', 'ContactController@index')->name('contact');
Route::post('/contact', 'ContactController@postContact')->name('postContact');

Route::post('/webhook/encoding', 'EncodingWebhookController@handle');

Route::get('/videos/{video}', 'VideoController@show');

Route::post('/videos/{video}/views', 'VideoViewController@create'); 

Route::get('/search', 'SearchController@index');

Route::get('/videos/{video}/votes', 'VideoVoteController@show');

Route::get('videos/{video}/comments', 'VideoCommentController@index');

Route::get('/subscriptions/{channel}', 'ChannelSubscriptionController@show');

Route::get('/channel/{channel}', 'ChannelController@show');

//ADMIN PANEL
Route::group(['middleware' => ['admin']], function(){
	Route::get('/admin_panel_777/users', 'Admin\UserController@index');
	Route::get('/admin_panel_777/videos', 'Admin\VideoController@index');
	Route::get('/admin_panel_777/comments', 'Admin\CommentController@index');
	Route::get('/admin_panel_777/channels', 'Admin\ChannelController@index');
	Route::resource('/admin/datatable/users', 'DataTable\UserController');
	Route::resource('/admin/datatable/videos', 'DataTable\VideoController');
	Route::resource('/admin/datatable/comments', 'DataTable\CommentController');
	Route::resource('/admin/datatable/channels', 'DataTable\ChannelController');
});
//USER AUTHENTIFICATED
Route::group(['middleware' => ['auth']], function(){
	
	Route::get('/upload', 'VideoUploadController@index');
	Route::post('/upload', 'VideoUploadController@store');
	
	Route::get('/deleteTmp/{filename}', 'VideoUploadController@deleteTmp')->name('deleteTmp');

	Route::get('/videos', 'VideoController@index');
	Route::post('/videos', 'VideoController@store');
	Route::delete('/videos/{video}', 'VideoController@delete');
	Route::get('/videos/{video}/edit', 'VideoController@edit');
	Route::put('/videos/{video}', 'VideoController@update');
	
	Route::get('/channel/{channel}/edit', 'ChannelSettingsController@edit');
	Route::put('/channel/{channel}/edit', 'ChannelSettingsController@update');

	Route::post('videos/{video}/comments', 'VideoCommentController@create');
	Route::delete('videos/{video}/comments/{comment}', 'VideoCommentController@delete');

	Route::post('/subscriptions/{channel}', 'ChannelSubscriptionController@create');
	Route::delete('/subscriptions/{channel}', 'ChannelSubscriptionController@delete');

	Route::post('/videos/{video}/votes', 'VideoVoteController@create');
	Route::delete('/videos/{video}/votes', 'VideoVoteController@remove');

	Route::get('/profile', 'ProfileController@index')->name('profile');
	Route::patch('/profile/{user}/update', 'ProfileController@update')->name('profile.update');

	Route::get('/profile/{user}/deleteAccount', 'ProfileController@getDeleteAccount')->name('profile.getDeleteAccount');
	Route::post('/profile/{user}/deleteAccount', 'ProfileController@postDeleteAccount')->name('profile.postDeleteAccount');



});

	//FORUM
//Route::view('scan', 'scan');

Route::get('/forum/threads', 'ThreadsController@index')->name('threads');
Route::get('/forum/threads/create', 'ThreadsController@create');
Route::get('/forum/threads/search', 'ForumSearchController@show');
Route::get('/forum/threads/{topic}/{thread}', 'ThreadsController@show');
Route::patch('/forum/threads/{topic}/{thread}', 'ThreadsController@update');

Route::delete('/forum/threads/{topic}/{thread}', 'ThreadsController@destroy');
Route::post('/forum/threads', 'ThreadsController@store');
Route::get('/forum/threads/{topic}', 'ThreadsController@index');

Route::post('/forum/locked-threads/{thread}', 'LockedThreadsController@store')->name('locked-threads.store')->middleware('admin');
Route::delete('/forum/locked-threads/{thread}', 'LockedThreadsController@destroy')->name('locked-threads.destroy')->middleware('admin');

Route::get('/forum/threads/{topic}/{thread}/replies', 'RepliesController@index');
Route::post('/forum/threads/{topic}/{thread}/replies', 'RepliesController@Store');
Route::patch('/forum/replies/{reply}', 'RepliesController@update');
Route::delete('/forum/replies/{reply}', 'RepliesController@destroy')->name('replies.destroy');

Route::post('/forum/replies/{reply}/best', 'BestRepliesController@store')->name('best-replies.store');

Route::post('/forum/threads/{topic}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')->middleware('auth');
Route::delete('/forum/threads/{topic}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')->middleware('auth');

Route::post('/forum/replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('/forum/replies/{reply}/favorites', 'FavoritesController@destroy');

Route::get('/public_profiles/{user}', 'PublicProfilesController@show')->name('publicProfile');
Route::get('/public_profiles/{user}/notifications', 'UserNotificationsController@index');
Route::delete('/public_profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy');

//Users
Route::get('api/users','Api\UsersController@index');
Route::post('api/users/{user}/avatar','Api\UserAvatarController@store')->middleware('auth')->name('avatar');



