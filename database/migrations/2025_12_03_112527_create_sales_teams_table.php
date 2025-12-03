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
        Schema::create('sales_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained()->onDeleteCascade();
            // Polymorphic columns
            $table->unsignedBigInteger('salesable_id');
            $table->string('salesable_type');
            $table->integer('percentage_onsales')->default(0);
            $table->decimal('amount_onsales', 8, 2)->default(0);
            $table->timestamps();

            $table->unique(['salesable_id', 'salesable_type']); // One-to-one

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_teams');
    }
};
