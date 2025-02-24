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
        Schema::create('religious_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained();
            $table->date('date')->nullable();  // Data do curso
            $table->boolean('finished')->default(false);  // Status de finalização (Sim/Não)
            $table->boolean('has_initiation')->default(false); // Indica se tem iniciação
            $table->date('initiation_date')->nullable(); // Data da iniciação
            $table->text('observations')->nullable(); // Campo para observações
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('religious_courses');
    }
};
