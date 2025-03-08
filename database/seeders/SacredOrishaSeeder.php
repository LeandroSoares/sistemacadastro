<?php

namespace Database\Seeders;

use App\Models\Orisha;
use Illuminate\Database\Seeder;

class SacredOrishaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orishas = [
            [
                'name' => 'Oxalá',
                'description' => 'Orixá da criação e da paz',
                'is_right' => true,
                'is_left' => false,
                'active' => true
            ],
            [
                'name' => 'Oiá',
                'description' => 'Orixá dos ventos e tempestades',
                'is_right' => true,
                'is_left' => false,
                'active' => true
            ],
            [
                'name' => 'Oxum',
                'description' => 'Orixá das águas doces e do amor',
                'is_right' => true,
                'is_left' => false,
                'active' => true
            ],
            [
                'name' => 'Oxmaré',
                'description' => 'Orixá do arco-íris',
                'is_right' => true,
                'is_left' => false,
                'active' => true
            ],
            [
                'name' => 'Oxóssi',
                'description' => 'Orixá da caça e das matas',
                'is_right' => true,
                'is_left' => false,
                'active' => true
            ],
            [
                'name' => 'Obá',
                'description' => 'Orixá guerreira',
                'is_right' => true,
                'is_left' => false,
                'active' => true
            ],
            [
                'name' => 'Xangô',
                'description' => 'Orixá da justiça e dos raios',
                'is_right' => true,
                'is_left' => false,
                'active' => true
            ],
            [
                'name' => 'Egunitá',
                'description' => 'Orixá da transformação',
                'is_right' => true,
                'is_left' => false,
                'active' => true
            ],
            [
                'name' => 'Ogum',
                'description' => 'Orixá guerreiro e da tecnologia',
                'is_right' => true,
                'is_left' => false,
                'active' => true
            ],
            [
                'name' => 'Iansã',
                'description' => 'Orixá dos ventos e tempestades',
                'is_right' => true,
                'is_left' => false,
                'active' => true
            ],
            [
                'name' => 'Obaluaiyê',
                'description' => 'Orixá da cura e das doenças',
                'is_right' => true,
                'is_left' => false,
                'active' => true
            ],
            [
                'name' => 'Nanã',
                'description' => 'Orixá da chuva e da morte',
                'is_right' => true,
                'is_left' => false,
                'active' => true
            ],
            [
                'name' => 'Iemanjá',
                'description' => 'Orixá do mar e da maternidade',
                'is_right' => true,
                'is_left' => false,
                'active' => true
            ],
            [
                'name' => 'Omolu',
                'description' => 'Orixá da cura e das doenças',
                'is_right' => true,
                'is_left' => false,
                'active' => true
            ],
            [
                'name' => 'Exu Guardião',
                'description' => 'Orixá da comunicação e dos caminhos',
                'is_right' => false,
                'is_left' => true,
                'active' => true
            ],
            [
                'name' => 'Bombagira Guardiã',
                'description' => 'Orixá da sedução e da proteção',
                'is_right' => false,
                'is_left' => true,
                'active' => true
            ],
            [
                'name' => 'Exu Mirim',
                'description' => 'Orixá da travessura e da proteção',
                'is_right' => false,
                'is_left' => true,
                'active' => true
            ],
            [
                'name' => 'Bombagira Mirim',
                'description' => 'Orixá da alegria infantil e da pureza',
                'is_right' => false,
                'is_left' => true,
                'active' => true
            ],
            [
                'name' => 'Exu do Fogo',
                'description' => 'Orixá do fogo e da transformação',
                'is_right' => false,
                'is_left' => true,
                'active' => true
            ],
            [
                'name' => 'Exu do Ouro',
                'description' => 'Orixá da riqueza e da prosperidade',
                'is_right' => false,
                'is_left' => true,
                'active' => true
            ],
            [
                'name' => 'Exu Guardião do Mar',
                'description' => 'Orixá da proteção marítima',
                'is_right' => false,
                'is_left' => true,
                'active' => true
            ]
        ];

        foreach ($orishas as $orisha) {
            Orisha::create($orisha);
        }
    }
}
