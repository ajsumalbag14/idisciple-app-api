<?php

Route::group(['namespace' => 'App\Modules\User\Profile\Controllers', 'prefix' => 'user'], function () {
    
    Route::post('/add', 'UserProfileController@addUser');
    Route::post('/edit', 'UserProfileController@editUser');
    Route::post('/delete', 'UserProfileController@deleteUser');

});