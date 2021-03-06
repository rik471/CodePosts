<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddSoftDeleteToCodeCommentsTable extends Migration
{
    public function up()
    {
        Schema::table('codepress_comments', function (Blueprint $table){

            $table->softDeletes();

        });
    }

    public function down()
    {
        Schema::table('codepress_comments', function (Blueprint $table){
            $table->dropColumn('deleted_at');
        });
    }
}