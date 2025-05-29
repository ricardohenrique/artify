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
        Schema::create('paintings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->boolean('is_draft')->default(true);

            $table->string('title')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->text('description')->nullable();

            $table->decimal('price', 10, 2)->nullable();
            $table->string('material')->nullable();
            $table->year('year_created')->nullable();
            $table->string('dimensions')->nullable();
            $table->boolean('framed')->nullable();
            $table->enum('orientation', ['portrait', 'landscape', 'square'])->nullable();

            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            $table->enum('availability', ['for_sale', 'sold', 'reserved'])->default('for_sale');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paintings');
    }
};
