<?php
Route::group(['namespace' => 'App\Modules\Contents\Main\Controllers', 'prefix' => 'content'], function () {
    
    Route::get('/all', 'ContentsController@getContent');

});