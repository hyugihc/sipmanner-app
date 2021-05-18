<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nomor_sk')->unique();;
            $table->date('tanggal_sk');
            $table->string('perihal_sk');
            $table->string('file_sk');
            $table->integer('approval');
            $table->string('kode_org');
            $table->string('alasan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cans');
    }
}
