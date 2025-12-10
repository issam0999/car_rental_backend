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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->morphs('documentable');
            $table->string('name', 255);
            $table->string('number', 255)->nullable();
            $table->integer('type_id');
            $table->date('issue_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('external_link', 500)->nullable();
            $table->string('path');
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('size')->default(0);

            $table->timestamps();
            $table->index('name');
            $table->index('number');
            $table->index('type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');

    }
};
