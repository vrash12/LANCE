<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
/* database/migrations/XXXX_add_fields_to_opd_forms_table.php */
public function up()
{
    Schema::table('opd_forms', function (Blueprint $t) {
        $t->json('fields')->nullable();          // ← the questions live here
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('opd_forms', function (Blueprint $table) {
            //
        });
    }
};
