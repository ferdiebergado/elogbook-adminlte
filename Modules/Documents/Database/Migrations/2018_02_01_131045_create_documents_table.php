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
            $table->biIncrements('id');    
            $table->integer('doctype_id');
            $table->string('details', 250);
            $table->timestamp('date_received')->default(DB::raw(CURRENT TIMESTAMP));
            $table->string('received_from', 150)->nullable()->default(null);
            $table->string('received_to', 150)->nullable()->default(null);
            $table->timestamp('date_released')->default(DB::raw(CURRENT TIMESTAMP));
            $table->string('released_from', 150)->nullable()->default(null);
            $table->string('released_to', 150)->nullable()->default(null);            
            $table->string('persons_concerned', 250);
            $table->string('action_taken', 250);
            $table->string('received_by', 150);
            $table->unsignedInteger('created_by')->nullable()->default(null)->after('created_at');
            $table->unsignedInteger('updated_by')->nullable()->default(null)->after('updated_at');            
            $table->unsignedInteger('deleted_by')->nullable()->default(null)->after('updated_by');
            $table->timestamps();
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
