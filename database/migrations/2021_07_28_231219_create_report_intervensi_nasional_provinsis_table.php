<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportIntervensiNasionalProvinsisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_intervensi_nasional_provinsis', function (Blueprint $table) {
            $table->foreignId('inp_id')->constrained('intervensi_nasional_provinsis');
            $table->foreignId('report_id')->constrained('reports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_intervensi_nasional_provinsis');
    }
}
