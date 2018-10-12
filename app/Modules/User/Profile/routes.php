<?php

Route::group(['namespace' => 'App\Modules\User\Profile\Controllers', 'prefix' => 'user'], function () {
    
    Route::post('/add', 'UserProfileController@addUser');
    Route::post('/edit', 'UserProfileController@editUser');
    Route::post('/delete', 'UserProfileController@deleteUser');

    Route::put('/first-time/{id}', 'UserProfileController@changePassword');
    Route::put('/password/{id}', 'UserProfileController@changePassword');
    Route::post('/reset-password', 'UserProfileController@resetPasswordAndSendEmail');

});