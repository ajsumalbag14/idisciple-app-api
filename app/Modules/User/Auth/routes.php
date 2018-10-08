<?php

Route::group(['namespace' => 'App\Modules\User\Auth\Controllers', 'prefix' => 'auth'], function () {
    
    Route::get('/test', 'AuthController@test');

});