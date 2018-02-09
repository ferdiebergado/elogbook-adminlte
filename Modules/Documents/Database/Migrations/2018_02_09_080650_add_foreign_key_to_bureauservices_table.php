<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToBureauservicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bureauservices', function (Blueprint $table) {
            $table->foreign('strand_id')->references('id')->on('strands');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bureauservices', function (Blueprint $table) {
            $table->dropForeign(['strand_id']);
        });
    }
}
