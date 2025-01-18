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
            $table->string('isin');
            $table->string('issuer');
            $table->string('coupon_rate');
            $table->string('maturity_date');
            $table->string('rating');
            $table->string('segmentOfIssuer');
            $table->string('ModelYield');
            $table->string('modelPrice');
            $table->string('Y15DaysYield');
            $table->string('P15DaysPrice');
            $table->string('finalYield');
            $table->string('finalPrice');
            $table->string('remarks');
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
