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
/* database/migrations/XXXX_create_opd_submissions_table.php */
public function up()
{
    Schema::create('opd_submissions', function (Blueprint $t) {
        $t->id();
        $t->foreignId('user_id')->constrained()->cascadeOnDelete();
        $t->foreignId('form_id')->constrained('opd_forms')->cascadeOnDelete();
        $t->json('answers');                    // patient answers
        $t->timestamps();
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('opd_submissions');
    }
};
