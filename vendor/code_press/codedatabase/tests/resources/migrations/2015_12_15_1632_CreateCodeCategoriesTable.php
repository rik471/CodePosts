<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;


class CreateCodeCategoriesTable extends Migration
{
    protected $table = 'codepress_categories';

    public function up()
    {
        Schema::create('codepress_categories', function (Blueprint $table){
           $table->increments('id');
           $table->string('name');
           $table->string('description');
           $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('codepress_categories');
    }
}