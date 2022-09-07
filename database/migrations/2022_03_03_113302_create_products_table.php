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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('hsn');
            $table->string('unit_price');
            $table->string('gst_percent');
            $table->string('quantity');
            $table->date('mfg_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('selling_price');
            $table->string('image')->nullable();
            $table->string('quantity');
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
        Schema::dropIfExists('products');
    }
};
