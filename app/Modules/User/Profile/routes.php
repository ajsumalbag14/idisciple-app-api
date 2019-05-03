<?php

Route::group(['namespace' => 'App\Modules\User\Profile\Controllers', 'prefix' => 'user'], function () {
    
    Route::post('/add', 'UserProfileController@addUser');
    Route::put('/edit/{id}', 'UserProfileController@editUser');
    Route::post('/delete', 'UserProfileController@deleteUser');

    Route::put('/first-time/{id}', 'UserProfileController@changePassword');
    Route::put('/password/{id}', 'UserProfileController@changePassword');
    Route::post('/reset-password', 'UserProfileController@resetPasswordAndSendEmail');

    Route::get('/all', 'UserProfileController@fetchAll');

    Route::get('/show', 'UserProfileController@fetchUser');

    Route::get('/logout', 'UserProfileController@logout');

    Route::get('/migrate', 'UserProfileController@createUserAccount');

    Route::post('/photo', 'UserProfileController@managePhoto');

});