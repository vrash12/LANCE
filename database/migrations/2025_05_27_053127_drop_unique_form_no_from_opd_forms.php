<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('opd_forms', function (Blueprint $table) {
            // drop the unique index on form_no
            $table->dropUnique(['form_no']);
        });
    }

    public function down()
    {
        Schema::table('opd_forms', function (Blueprint $table) {
            // restore it if you ever roll back
            $table->unique('form_no');
        });
    }
};
