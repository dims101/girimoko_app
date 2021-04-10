<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('awbs', function (Blueprint $table) {
            $table->id();
            $table->string('no_awb')->unique();
            $table->string('no_ds');
            $table->string('kode_dealer');
            $table->date('tanggal_ds');
            $table->string('status')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('id_pengiriman')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('awbs');
    }
}
