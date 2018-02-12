<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('document_id');
            $table->enum('task',['I', 'O']);
            $table->unsignedInteger('from_to_office');                
            $table->timestamp('date');
            $table->string('action', 250);
            $table->string('action_to_be_taken', 250);
            $table->string('by', 150);
            $table->unsignedInteger('office_id');
            $table->boolean('pending')->default(0);
            $table->unsignedInteger('created_by')->nullable()->default(null);
            $table->unsignedInteger('updated_by')->nullable()->default(null);            
            $table->unsignedInteger('deleted_by')->nullable()->default(null);             
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
        Schema::dropIfExists('transactions');
    }
}
