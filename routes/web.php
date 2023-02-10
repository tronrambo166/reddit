<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupPostControler;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homeController;
use App\Http\Controllers\testController;

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

Route::get('/', 'testController@login');
Route::get('forgot/{remail}', 'testController@forgot')->name('forgot');
Route::post('send_reset_email', 'testController@send_reset_email')->name('send_reset_email');
Route::post('reset/{remail}', 'testController@reset')->name('reset');


Route::group(['middleware'=>['auth']], function(){

    //Inside
    // Route::get('home', 'testController@home')->name('home');
    Route::get('home', 'HomeController@home')->name('home');//->name('home');
    Route::post('group/create', [GroupController::class,'groupCreate'])->name('group.create');
    Route::get('my/group/{id}/{slug}', [GroupController::class,'myGroup'])->name('my.group');
    Route::get('public-community/{id}/{slug}', [GroupController::class,'RelatedCommunity'])->name('related.communit');
    Route::get('group/on-off',[GroupController::class,'onOff'])->name('post.on.off');
    Route::post('setup/rules',[GroupController::class,'setupRules'])->name('setup.rules');
    Route::get('delete/rule',[GroupController::class,'deleteRule'])->name('delete.rule');
    Route::get('follow/group',[GroupController::class,'followGroup'])->name('follow.group');
    Route::get('unfollow/group',[GroupController::class,'unFollowGroup'])->name('unfollow.group');
    //create post
    Route::post('group/post',[GroupPostControler::class,'postOnGroup'])->name('group.post');
    Route::post('comment/post',[GroupPostControler::class,'commentOnPost'])->name('post.comment');

    Route::get('group/post_like',[GroupPostControler::class,'post_like'])->name('post_like');

});
Route::get('placeholder-image/{size}', [HomeController::class,'placeholderImage'])->name('placeholder.image');


//Route::get('{anypath}', 'testController@home')->where('path', '.*');

Auth::routes();


Route::get('about', 'HomeController@about')->name('about');
Route::get('social', 'HomeController@social')->name('social');
Route::get('radio', 'HomeController@radio')->name('radio');
Route::get('breakdown', 'HomeController@breakdown')->name('breakdown');


Route::get('clear_cache', function () {
    \Artisan::call('config:cache');
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');
    dd("Cache is cleared");
});

