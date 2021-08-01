<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportIntervensiKhususTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_intervensi_khusus', function (Blueprint $table) {
            $table->foreignId('intervensi_khusus_id')->constrained('intervensi_khususes');
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
        Schema::dropIfExists('report_intervensi_khusus');
    }
}
