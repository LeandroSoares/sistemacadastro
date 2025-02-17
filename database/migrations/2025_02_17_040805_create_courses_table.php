<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        $courses = [
            'Teologia e Sacerdócio',
            'Oferendas',
            'Exu do Fogo',
            'Exu Mirim',
            'Exu do Ouro',
            'Pombo Gira',
            'Teologia II',
            'Exu Guardião Do Mar',
            'Benzimento'
        ];

        foreach ($courses as $course) {
            DB::table('courses')->insert([
                'name' => $course,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
