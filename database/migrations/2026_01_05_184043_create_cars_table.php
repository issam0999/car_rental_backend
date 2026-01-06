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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('brand', 100);
            $table->string('model', 100);
            $table->year('year');
            $table->string('category', 50)->nullable();
            $table->string('color')->nullable();
            $table->string('plate_number', 20)->unique()->nullable();
            $table->tinyInteger('seats')->unsigned()->default(4);
            $table->tinyInteger('doors')->unsigned()->default(4);
            $table->enum('transmission', ['manual', 'automatic'])->nullable();
            $table->enum('fuel_type', ['gasoline', 'diesel', 'electric', 'hybrid'])->nullable();
            $table->integer('mileage')->unsigned()->nullable();
            $table->decimal('price_per_day', 8, 2)->nullable();
            $table->decimal('price_per_week', 8, 2)->nullable();
            $table->decimal('price_per_month', 8, 2)->nullable();
            $table->tinyInteger('minimum_rental_days')->default(1);
            $table->enum('status', ['available', 'maintenance', 'rented', 'unavailable'])->default('available');
            $table->string('image', 255)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['center_id', 'category', 'status']);
            $table->index(['category']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
