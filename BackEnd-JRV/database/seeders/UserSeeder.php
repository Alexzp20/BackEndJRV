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
        User::create(['username'=>'decano01','name'=>'Luis','apellido'=>'Barrera','email'=>'luis.barrera@gmail.com','password'=>'12345','puesto_id'=>'1'])->assignRole('Administrador')->rutas()->attach([1,2,3,4,5,6,7,8,9,10]);
        User::create(['username'=>'rodrigo01','name'=>'Rodrigo','apellido'=>'Zelaya','email'=>'rodrigo@gmail.com','password'=>'12345','puesto_id'=>'3'])->assignRole('Asistente')->rutas()->attach([1,2,3,4,5,6,8]);
        User::create(['username'=>'pedro02','name'=>'Pedro','apellido'=>'Zavaleta','email'=>'pedro@gmail.com','password'=>'12345','puesto_id'=>'3'])->assignRole('Asistente')->rutas()->attach([1,2,3,4,5,6,8]);
        User::create(['username'=>'diegodcc','name'=>'Diego','apellido'=>'Castro','email'=>'diego@gmail.com','password'=>'12345','puesto_id'=>'3'])->assignRole('Asistente')->rutas()->attach([1,2,3,4,5,6,8]);
        User::create(['username'=>'UCB','name'=>'Unidad de Ciencias Basicas','email'=>'ucb@fia.ues.edu.sv','password'=>'12345',])->assignRole('Unidad')->rutas()->attach([1,4,5]);

    }
}
