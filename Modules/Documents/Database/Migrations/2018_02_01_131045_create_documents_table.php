<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');    
            $table->integer('doctype_id');
            $table->string('details', 250);
            $table->string('persons_concerned', 250);
            $table->unsignedInteger('received_from')->nullable()->default(null);
            $table->unsignedInteger('received_to')->nullable()->default(null);
            $table->timestamp('date_received')->nullable()->default(null);
            $table->string('action_to_be_taken', 250)->nullable()->default(null);
            $table->string('received_by', 150)->nullable()->default(null);
            $table->unsignedInteger('released_from')->nullable()->default(null);
            $table->unsignedInteger('released_to')->nullable()->default(null);            
            $table->timestamp('date_released')->nullable()->default(null);
            $table->string('action_taken', 250)->nullable()->default(null);
            $table->string('released_by', 150)->nullable()->default(null);
            $table->foreign('received_from')->references('id')->on('offices');
            $table->foreign('received_to')->references('id')->on('offices');
            $table->foreign('released_from')->references('id')->on('offices');
            $table->foreign('released_to')->references('id')->on('offices');
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable()->default(null);
            $table->unsignedInteger('updated_by')->nullable()->default(null);            
            $table->unsignedInteger('deleted_by')->nullable()->default(null);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
