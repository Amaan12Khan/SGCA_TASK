<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('assigned_to');
            $table->enum('priority', ['Low', 'Medium', 'High'])->default('Low');
            $table->date('deadline');
            $table->enum('status', [
                'Pending',
                'In Progress',
                'Submitted',
                'Manager Approved',
                'Approved',
                'Rejected'
            ])->default('Pending');
            $table->string('assigned_role')->default('Employee');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('tasks');
    }
};