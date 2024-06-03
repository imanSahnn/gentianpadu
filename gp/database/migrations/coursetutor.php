<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCourseIdToTutorsTable extends Migration
{
    public function up()
    {
        Schema::table('tutor', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')->references('id')->on('course')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('tutor', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropColumn('course_id');
        });
    }
}
