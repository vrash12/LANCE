<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokensTable extends Migration
{
    public function up()
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')
                  ->constrained()          // references departments.id
                  ->cascadeOnDelete();
            $table->string('code');         // e.g. “B011”
            $table->timestamp('served_at')  // null = not yet served
                  ->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tokens');
    }
}
