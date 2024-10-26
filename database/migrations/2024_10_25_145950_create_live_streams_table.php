<?php
// database/migrations/xxxx_xx_xx_create_live_streams_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveStreamsTable extends Migration
{
    public function up()
    {
        Schema::create('live_streams', function (Blueprint $table) {
            $table->id();
            $table->string('youtube_link');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('live_streams');
    }
}
