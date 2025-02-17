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
        Schema::create('head_orishas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('ancestor')->nullable();
            $table->string('front')->nullable();
            $table->string('front_together')->nullable();
            $table->string('adjunct')->nullable();
            $table->string('adjunct_together')->nullable();
            $table->string('left_side')->nullable();
            $table->string('left_side_together')->nullable();
            $table->string('right_side')->nullable();
            $table->string('right_side_together')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orishas');
    }
};
