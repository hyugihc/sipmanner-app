<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramIntervensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_intervensis', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nama');
            $table->string('uraian_kegiatan');
            $table->string('nilai_pia');
            $table->string('vol_keg_tahun');
            $table->string('output');
            $table->string('outcome');
            $table->string('awal_pelaksanaan');
            $table->string('selesai_pelaksanaan');
            $table->string('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program_intervensis');
    }
}
