<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgressProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progress_programs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('progress_programs_id')->constrained('program_intervensis');
            $table->string('nama');
            $table->date('tanggal_kegiatan');
            $table->double('progress_kegiatan', 4, 2);
            $table->double('progress_output', 4, 2);
            $table->string('upload_dokumentasi');
            $table->string('upload_bukti_dukung');
            $table->date('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('progress_programs');
    }
}
