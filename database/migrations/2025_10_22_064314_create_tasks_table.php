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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task_number')->unique();
            $table->foreignId('customer_id')->constrained('users');
            $table->foreignId('category_id')->constrained();
            $table->foreignId('tasker_id')->nullable()->constrained('users');
            $table->string('title');
            $table->text('description');
            $table->string('location_address');
            $table->string('location_coordinates')->nullable();  //will add point data type with it pakage $table->point('location_coordinates');
            $table->foreignId('district_id')->nullable()->constrained();
            $table->foreignId('zila_id')->nullable()->constrained();
            $table->foreignId('upozila_id')->nullable()->constrained();
            $table->string('emergency');
            $table->decimal('budget', 10, 2);
            $table->enum('status', ['posted', 'assigned', 'in_progress', 'completed', 'cancelled', 'disputed'])->default('posted');
            $table->text('customer_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
