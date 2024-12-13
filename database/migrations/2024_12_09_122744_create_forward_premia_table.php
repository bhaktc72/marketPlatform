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
        Schema::create('forward_premia', function (Blueprint $table) {
            $table->id();
            $table->string('tenor')->nullable();
            $table->string('rate_percentage')->nullable();
            $table->string('rate')->nullable();
            $table->enum('status', ['Active', 'Deleted'])->default('Active')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forward_premia');
    }
};
