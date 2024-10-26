<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('call_schedules', function (Blueprint $table) {
            $table->id();
            $table->date('scheduled_date');  // For day, month, and year
            $table->time('scheduled_time');  // Time field
            $table->enum('status', ['scheduled', 'live', 'completed'])->default('scheduled');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('call_schedules');
    }
}
