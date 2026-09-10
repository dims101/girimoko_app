<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKeteranganToProformasTable extends Migration
{
    public function up()
    {
        Schema::table('proformas', function (Blueprint $table) {
            $table->string('keterangan')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('proformas', function (Blueprint $table) {
            $table->dropColumn('keterangan');
        });
    }
}
