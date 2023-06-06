<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntervensiKhususRb2023Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intervensi_khusus_rb2023', function (Blueprint $table) {
            $table->foreignId('intervensi_khusus_id')->constrained('intervensi_khususes');
            $table->foreignId('rb2023_id')->constrained('rb2023s');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('intervensi_khusus_rb2023');
    }
}
