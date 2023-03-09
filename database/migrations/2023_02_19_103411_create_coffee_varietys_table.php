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
        Schema::create('coffee_varieties', function (Blueprint $table) {
            $table->id();
            $table->string('coffee_name')->unique();
            $table->string('credit_cost')->default(0);
            $table->string('coffee_image')->default('default_coffee_image.png');
            $table->string('coffee_description')->nullable();
            $table->string('coffee_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coffee_varieties');
    }
};
