<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalKoliToProformasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('proformas', function (Blueprint $table) {
        $table->integer('total_koli')->default(0)->after('no_awb');
        $table->string('status')->nullable()->after('total_koli');
    });
}

public function down()
{
    Schema::table('proformas', function (Blueprint $table) {
        $table->dropColumn(['total_koli', 'status']);
    });
}
}
