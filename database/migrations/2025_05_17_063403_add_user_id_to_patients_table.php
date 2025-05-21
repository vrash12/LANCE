<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToPatientsTable extends Migration
{
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            // 1) add the column (nullable to avoid breaking existing rows)
            $table->unsignedBigInteger('user_id')->nullable()->after('id');

            // 2) index & FK constraint
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            // drop FK then column
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
