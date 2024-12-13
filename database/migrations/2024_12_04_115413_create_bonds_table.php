<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bonds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('issuer');
            $table->string('currency');
            $table->string('maturity');
            $table->float('face_value');
            $table->float('coupon');
            $table->integer('frequency');
            $table->integer('day_count');
            $table->float('price');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bonds');
    }
};
