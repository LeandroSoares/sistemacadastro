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
        Schema::create('mysteries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // Inserir os tipos de mistérios padrão
        $mysteries = [
            'Exu Guardião',
            'Pombagira Guardiã',
            'Exu Mirim',
            'Exu do Fogo',
            'Exu do Ouro',
            'Exu Guardião do Mar'
        ];

        foreach ($mysteries as $mystery) {
            DB::table('mysteries')->insert([
                'name' => $mystery,
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
        Schema::dropIfExists('mysteries');
    }
};
