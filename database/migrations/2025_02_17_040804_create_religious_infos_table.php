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
        Schema::create('religious_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('start_date')->nullable();
            $table->string('start_location')->nullable();
            $table->date('charity_house_start')->nullable();
            $table->date('charity_house_end')->nullable();
            $table->text('charity_house_observations')->nullable();
            $table->date('development_start')->nullable();
            $table->date('development_end')->nullable();
            $table->date('service_start')->nullable();
            $table->date('umbanda_baptism')->nullable();
            $table->boolean('cambone_experience')->default(false);
            $table->date('cambone_start_date')->nullable();
            $table->date('cambone_end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('religious_infos');
    }
};
