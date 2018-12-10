<?php



Route::group([
    'prefix' => 'admin',
    'as' => 'admin.posts.',
    'namespace' => 'CodePress\CodePosts\Controllers',
    'middleware' => ['web', 'auth']
], function () {
    Route::get('/posts',['uses' => 'AdminPostsController@index', 'as' => 'index']);
});