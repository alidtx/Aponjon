<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasker_profiles', function (Blueprint $table) {
            $table->foreignId('district_id')->nullable()->after('user_id')->constrained('districts')->nullOnDelete();

            $table->foreignId('zila_id')->nullable()->after('user_id')
                ->constrained('zilas')
                ->nullOnDelete();

            $table->foreignId('upozila_id')->nullable()->after('user_id')
                ->constrained('upozilas')
            ->nullOnDelete();

            $table->string('nid_number')->nullable()->after('document');
            $table->json('experience')->nullable()->after('document');
        });
    }

    public function down(): void
    {
        Schema::table('tasker_profiles', function (Blueprint $table) {
            $table->dropForeign(['district_id']);
            $table->dropForeign(['zila_id']);
            $table->dropForeign(['upozila_id']);
            $table->dropColumn([
                'district_id',
                'zila_id',
                'upozila_id',
                'nid_number',
                'experience'
            ]);
        });
    }
};
