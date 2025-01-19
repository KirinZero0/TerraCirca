<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_list_id');
            $table->string('name');
            $table->string('barcode')->nullable();
            $table->string('batch')->nullable();
            $table->integer('stock')->default(0);
            $table->double('price')->default(0);
            $table->double('selling_price')->default(0);
            $table->double('profit')->default(0);
            $table->date('expiration_date')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('product_stocks');
    }
}
