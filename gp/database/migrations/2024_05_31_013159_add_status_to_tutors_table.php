<?php

// database/migrations/xxxx_xx_xx_add_status_to_tutors_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToTutorsTable extends Migration
{
    public function up()
    {
        Schema::table('tutor', function (Blueprint $table) {
            $table->string('status')->default('inactive'); // Add status column with default value 'inactive'
        });
    }

    public function down()
    {
        Schema::table('tutor', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
