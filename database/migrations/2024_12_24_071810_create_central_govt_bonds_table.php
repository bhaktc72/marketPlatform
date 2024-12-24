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
        Schema::create('central_govt_bonds', function (Blueprint $table) {
            $table->id();
            $table->string('isin')->nullable();
            $table->string('nomenclature')->nullable();
            $table->date('dateOfIssue')->nullable();
            $table->date('dateOfMaturity')->nullable();
            $table->integer('outStandingStock')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('central_govt_bonds');
    }
};
