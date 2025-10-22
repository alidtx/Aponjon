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
        Schema::create('tasker_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->text('bio')->nullable();
            $table->json('skill')->nullable();
            $table->decimal('daily_rate',8,2)->nullable();
            $table->json('document')->nullable();
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('completed_task')->default(0);
            $table->boolean('is_online')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasker_profiles');
    }
};
