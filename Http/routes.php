<?php

Route::group(['middleware' => 'auth', 'namespace' => 'Modules\Blog\Http\Controllers'], function()
{
    Route::resource('blog', 'BlogController');
    Route::post('blog/bulk', 'BlogController@bulk');
    Route::get('api/blog', 'BlogController@datatable');
});

Route::group(['middleware' => 'api', 'namespace' => 'Modules\Blog\Http\ApiControllers', 'prefix' => 'api/v1'], function()
{
    Route::resource('blog', 'BlogApiController');
});
