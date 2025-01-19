<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('reference_id');
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->double('total_amount')->default(0);
            $table->double('paid_amount')->default(0);
            $table->double('change_amount')->default(0);
            $table->double('profit_amount')->default(0);
            $table->date('date');
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
        Schema::dropIfExists('reservations');
    }
}
