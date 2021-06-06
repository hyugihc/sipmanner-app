<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgressIntervensiKhususesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progress_intervensi_khususes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('intervensi_khusus_id')->constrained('intervensi_khususes');
            $table->string('uraian_program');
            $table->date('bulan');
            $table->double('presentase_program', 4, 2);
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
        Schema::dropIfExists('progress_intervensi_khususes');
    }
}
