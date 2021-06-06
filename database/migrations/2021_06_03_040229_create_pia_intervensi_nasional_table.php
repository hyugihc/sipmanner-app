<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePiaIntervensiNasionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pia_intervensi_nasional', function (Blueprint $table) {
            $table->foreignId('intervensi_nasional_id')->constrained('intervensi_nasionals');
            $table->foreignId('pias_id')->constrained('pias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pia_intervensi_nasional');
    }
}
