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
        Schema::create('wrote_offs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('wroteoffable_id');
            $table->string('wroteoffable_type');
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('wrote_offs');
    }
};
