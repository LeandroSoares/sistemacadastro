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
        Schema::create('work_guides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('caboclo')->nullable();
            $table->string('cabocla')->nullable();
            $table->string('ogum')->nullable();
            $table->string('xango')->nullable();
            $table->string('baiano')->nullable();
            $table->string('baiana')->nullable();
            $table->string('preto_velho')->nullable();
            $table->string('preta_velha')->nullable();
            $table->string('boiadeiro')->nullable();
            $table->string('boiadeira')->nullable();
            $table->string('cigano')->nullable();
            $table->string('cigana')->nullable();
            $table->string('marinheiro')->nullable();
            $table->string('ere')->nullable();
            $table->string('exu')->nullable();
            $table->string('pombagira')->nullable();
            $table->string('exu_mirim')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_guides');
    }
};
