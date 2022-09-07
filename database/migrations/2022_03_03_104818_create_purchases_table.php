<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('supplier_id');
            $table->string('supplier_invoice')->nullable();
            $table->string('total_amount')->nullable();
            $table->enum('payment_method', ['upi', 'bank_transfer', 'cash', 'card']);
            $table->string('transaction_id')->nullable();
            $table->dateTime('payment_date');
            $table->softDeletes();
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
        Schema::dropIfExists('purchases');
    }
};
