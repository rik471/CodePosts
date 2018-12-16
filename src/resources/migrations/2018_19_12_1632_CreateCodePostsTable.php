<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use CodePress\CodePosts\Models\Post;


class CreateCodePostsTable extends Migration

{
    public function up()
    {
        Schema::create('codepress_posts', function (Blueprint $table){
           $table->increments('id');
           $table->string('title');
           $table->text('content');
           $table->string('slug');
           $table->integer('state')->default(Post::STATE_DRAFT);
           $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('codepress_posts');
    }
}