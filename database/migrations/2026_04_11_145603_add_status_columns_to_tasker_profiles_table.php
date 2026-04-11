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
        Schema::table('tasker_profiles', function (Blueprint $table) {
            $table->boolean('is_profile_completed')
                  ->default(false)
                  ->after('is_online');

            $table->enum('status', ['pending', 'approved', 'rejected'])
                  ->default('pending')
                  ->after('is_profile_completed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasker_profiles', function (Blueprint $table) {
            $table->dropColumn(['is_profile_completed', 'status']);
        });
    }
};