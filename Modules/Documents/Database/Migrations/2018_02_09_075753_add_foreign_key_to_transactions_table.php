<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('document_id')->references('id')->on('documents');
            $table->foreign('doctype_id')->references('id')->('doctypes');
            $table->foreign('from_to_office')->references('id')->on('offices');
            $table->foreign('office_id')->references('id')->on('offices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['document_id']);
            $table->dropForeign(['doctype_id']);
            $table->dropForeign(['from_to_office']);
            $table->dropForeign(['office_id']);
        });
    }
}
