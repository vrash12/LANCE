<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('staff_name');
            $table->string('role');        // e.g. Nurse, Midwife, Ward Assistant, Admin
            $table->date('date');
            $table->time('shift_start');
            $table->time('shift_end');
            $table->string('department');  // e.g. OPD, Gyne, Pediatrics
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
