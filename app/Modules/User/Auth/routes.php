<?php

Route::group(['namespace' => 'App\Modules\User\Auth\Controllers', 'prefix' => 'auth'], function () {
    
    Route::post('/login', 'AuthController@handle');

});