<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('opd_forms', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);        // e.g. “Initial Consultation”
            $table->string('form_no', 50)->unique();
            $table->string('department', 100);  // OB, Gyne, etc.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opd_forms');
    }
};

