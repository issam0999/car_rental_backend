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
        Schema::create('center_parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('key', 100);
            $table->string('name', 100);
            $table->string('value', 255)->nullable();
            $table->tinyInteger('required')->default(0);
            $table->string('type')->default('text');
            $table->integer('order')->nullable();
            $table->integer('subscription')->nullable();
            $table->string('group')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->unique(['center_id', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('center_parameters');
    }
};
