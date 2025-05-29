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
        Schema::create('colors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('hex_code', 10)->nullable();
            $table->timestamps();
        });

        Schema::create('color_painting', function (Blueprint $table) {
            $table->foreignId('color_id')->constrained()->onDelete('cascade');
            $table->foreignId('painting_id')->constrained()->onDelete('cascade');
            $table->primary(['color_id', 'painting_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('color_painting');
        Schema::dropIfExists('colors');
    }
};
