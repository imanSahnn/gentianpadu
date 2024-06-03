<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedBigInteger('selected_tutor_id')->nullable()->after('course_id');
            $table->foreign('selected_tutor_id')->references('id')->on('tutor')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['selected_tutor_id']);
            $table->dropColumn('selected_tutor_id');
        });
    }
};
