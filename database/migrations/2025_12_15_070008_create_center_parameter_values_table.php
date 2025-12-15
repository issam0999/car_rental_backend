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
        Schema::create('center_parameter_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_parameter_id')->constrained()->cascadeOnDelete();
            $table->string('value');
            $table->tinyInteger('status')->default(1);
            $table->integer('order')->default(1);
            $table->timestamps();

            $table->unique(['center_parameter_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('center_parameter_values');
    }
};
