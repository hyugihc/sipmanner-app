<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramIntervensiPiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_intervensi_pia', function (Blueprint $table) {
            $table->foreignId('program_intervensis_id')->constrained('program_intervensis');
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
        Schema::dropIfExists('program_intervensi_pia');
    }
}
