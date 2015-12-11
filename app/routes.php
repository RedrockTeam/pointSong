<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//后台登陆
Route::get('admin/login','AdminController@login');
Route::post('admin/login','AdminController@doLogin');
Route::filter('admin_is_login',function(){
    Route::get('admin/index',array('as' => 'adminIndex',function(){
        return View::make('admin.index');
    }));
    if(!Session::get('admin_is_login',0)){
        return Redirect::to('admin/login');
    }
});
Route::group(array('before' => 'admin_is_login'),function(){
    //后台主页面

    Route::controller('admin','AdminController');
    Route::controller('music','MusicController');
    Route::controller('announcement','AnnouncementController');
    Route::controller('word','WordController');

});

  //前台页面
Route::controller('personal','PersonalController');

  Route::controller('/','ListController');
