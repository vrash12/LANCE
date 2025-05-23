<?php
/* database/migrations/2025_05_23_000000_create_patient_profiles_table.php */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_profiles', function (Blueprint $t) {
            $t->id();

            /* FK to patients */
            $t->foreignId('patient_id')
               ->constrained()
               ->cascadeOnDelete();

            /* demographic */
            $t->enum('sex', ['male','female'])->nullable();
            $t->string('religion')->nullable();
            $t->date('date_recorded')->nullable();

            /* parents / marriage */
            $t->string('father_name')->nullable();
            $t->string('father_occupation')->nullable();
            $t->string('mother_name')->nullable();
            $t->string('mother_occupation')->nullable();
            $t->string('place_of_marriage')->nullable();
            $t->date('date_of_marriage')->nullable();
            $t->string('contact_no')->nullable();   // parent contact

            /* birth stats */
            $t->string('blood_type', 3)->nullable();
            $t->string('delivery_type')->nullable();
            $t->decimal('birth_weight', 5, 2)->nullable(); // kg
            $t->decimal('birth_length', 5, 2)->nullable(); // cm

            /* APGAR (0‒2 each) */
            $t->tinyInteger('apgar_appearance')->nullable();
            $t->tinyInteger('apgar_pulse')->nullable();
            $t->tinyInteger('apgar_grimace')->nullable();
            $t->tinyInteger('apgar_activity')->nullable();
            $t->tinyInteger('apgar_respiration')->nullable();

            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_profiles');
    }
};
