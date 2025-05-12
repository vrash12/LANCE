<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('opd_forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');             // e.g. Pedia Consultation & Triage Form
            $table->string('form_no')->unique(); // e.g. PD-008
            $table->string('department');        // e.g. Pediatrics
            $table->json('schema')->nullable();  // optional JSON structure for dynamic fields
            $table->timestamps();
        });
    }
    public function down() { Schema::dropIfExists('opd_forms'); }
};
