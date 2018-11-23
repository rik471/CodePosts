<?php



Route::group([
    'prefix' => 'admin/posts',
    'as' => 'admin.posts',
    'namespace' => 'CodePress\CodePosts\Controllers',
    'middleware' => ['web']

], function () {
    Route::get('/',['uses' => 'AdminPostsController@index', 'as' => 'index']);
});
