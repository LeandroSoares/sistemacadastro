<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PersonalData;
use App\Models\ReligiousInfo;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => 'Leandro Silva Soares',
            'email' => 'leandrogamedesigner@gmail.com',
            'password' => bcrypt('123456')
        ]);
        $user->assignRole('admin');
    }
}
