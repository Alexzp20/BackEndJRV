<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create(['username'=>'decano01','name'=>'Luis','apellido'=>'Barrera','email'=>'luis.barrera@gmail.com','password'=>'dfsdfdff',]);
        User::create(['username'=>'rodrigo01','name'=>'Rodrigo','apellido'=>'Zelaya','email'=>'rodrigo@gmail.com','password'=>'dfsdfdff',]);
        User::create(['username'=>'pedro02','name'=>'Pedro','apellido'=>'Zavaleta','email'=>'pedro@gmail.com','password'=>'dfsdfdff',]);
        User::create(['username'=>'diegodcc','name'=>'Diego','apellido'=>'Castro','email'=>'diego@gmail.com','password'=>'dfsdfdff',]);
    }
}