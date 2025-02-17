<?php
// Migration para tipos de magias divinas
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tabela para tipos de magias
        Schema::create('magic_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // Seed inicial com os tipos de magias
        $magicTypes = [
            'Magia do Fogo',
            'Magia das Pedras',
            'Magia das Ervas',
            'Magia dos Raios',
            'Magia dos Gênios',
            'Magia das Conchas',
            'Magia dos Portais',
            'Magia dos Anjos'
        ];

        foreach ($magicTypes as $type) {
            DB::table('magic_types')->insert([
                'name' => $type,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Tabela principal de magias divinas
        Schema::create('divine_magics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('magic_type_id')->constrained('magic_types');
            $table->date('date')->nullable();
            $table->boolean('performed')->default(false);
            $table->text('observations')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('divine_magics');
        Schema::dropIfExists('magic_types');
    }
};
