<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePinProvinsiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intervensi_nasionals_provinsis', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('intervensi_nasional_id')->constrained('intervensi_nasionals');
            $table->foreignId('provinsi_id')->constrained('provinsis');
            $table->string('kendala');
            $table->string('solusi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pin_provinsi');
    }
}
