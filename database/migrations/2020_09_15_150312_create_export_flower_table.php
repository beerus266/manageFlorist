<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExportFlowerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('export_flower', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('flower_id');
            $table->foreign('flower_id')->references('id')->on('flower');
            $table->bigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customer');
            $table->date('date');
            $table->string('tai');
            $table->string('quantity')->default(0);
            $table->string('price')->default(0);
            $table->string('invoice_img')->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('export_flower');
    }
}
