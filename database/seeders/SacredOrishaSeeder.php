<?php

namespace Database\Seeders;

use App\Models\SacredOrisha;
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
                'active' => true
            ],
            [
                'name' => 'Oiá',
                'description' => 'Orixá dos ventos e tempestades',
                'active' => true
            ],
            [
                'name' => 'Oxum',
                'description' => 'Orixá das águas doces e do amor',
                'active' => true
            ],
            [
                'name' => 'Oxmaré',
                'description' => 'Orixá do arco-íris',
                'active' => true
            ],
            [
                'name' => 'Oxóssi',
                'description' => 'Orixá da caça e das matas',
                'active' => true
            ],
            [
                'name' => 'Obá',
                'description' => 'Orixá guerreira',
                'active' => true
            ],
            [
                'name' => 'Xangô',
                'description' => 'Orixá da justiça e dos raios',
                'active' => true
            ],
            [
                'name' => 'Egunitá',
                'description' => 'Orixá da transformação',
                'active' => true
            ],
            [
                'name' => 'Ogum',
                'description' => 'Orixá guerreiro e da tecnologia',
                'active' => true
            ],
            [
                'name' => 'Iansã',
                'description' => 'Orixá dos ventos e tempestades',
                'active' => true
            ],
            [
                'name' => 'Obaluaiyê',
                'description' => 'Orixá da cura e das doenças',
                'active' => true
            ],
            [
                'name' => 'Nanã',
                'description' => 'Orixá da chuva e da morte',
                'active' => true
            ],
            [
                'name' => 'Iemanjá',
                'description' => 'Orixá do mar e da maternidade',
                'active' => true
            ],
            [
                'name' => 'Omolu',
                'description' => 'Orixá da cura e das doenças',
                'active' => true
            ]
        ];

        foreach ($orishas as $orisha) {
            SacredOrisha::create($orisha);
        }
    }
}
