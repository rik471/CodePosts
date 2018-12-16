<?php


Route::group([
    'prefix' => 'admin/posts',
    'as' => 'admin.posts.',
    'namespace' => '\CodePress\CodePosts\Controllers',
    'middleware' => ['web', 'auth']]
    , function () {
    Route::get('/', ['uses' => 'AdminPostsController@index',  'as' => 'index']);
    Route::get('/create', ['uses' => 'AdminPostsController@create', 'as' => 'create']);
    Route::post('/store', ['uses' => 'AdminPostsController@store', 'as' => 'store']);
    Route::get('{id}/edit/', ['uses' => 'AdminPostsController@edit', 'as' => 'edit']);
    Route::post('{id}/update', [ 'uses' => 'AdminPostsController@update', 'as' => 'update']);
    Route::patch('{id}/update-state', [ 'uses' => 'AdminPostsController@updateState', 'as' => 'update_state',
       'middleware' => 'authorization:publish_post' ,
    ]);
});