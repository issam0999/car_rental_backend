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
        Schema::create('centers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('industry_id')->nullable();
            $table->foreignId('subscription_type')->constrained('center_packages');
            $table->string('name');
            $table->string('description')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('countries');
            $table->foreignId('city_id')->nullable()->constrained('cities');
            $table->string('phone')->nullable();
            $table->string('phone1')->nullable();
            $table->string('email')->nullable();
            $table->string('email1')->nullable();
            $table->string('logo')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centers');
    }
};
