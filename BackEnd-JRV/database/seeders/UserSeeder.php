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
        User::create(['username'=>'decano01','name'=>'Luis','apellido'=>'Barrera','email'=>'luis.barrera@gmail.com','password'=>'12345','puesto_id'=>'1'])->assignRole('Administrador');
        User::create(['username'=>'rodrigo01','name'=>'Rodrigo','apellido'=>'Zelaya','email'=>'rodrigo@gmail.com','password'=>'12345','puesto_id'=>'4'])->assignRole('Administrador');
        User::create(['username'=>'pedro02','name'=>'Pedro','apellido'=>'Zavaleta','email'=>'pedro@gmail.com','password'=>'12345','puesto_id'=>'4'])->assignRole('Asistente');
        User::create(['username'=>'diegodcc','name'=>'Diego','apellido'=>'Castro','email'=>'diego@gmail.com','password'=>'12345','puesto_id'=>'4'])->assignRole('Asistente');
        User::create(['username'=>'UCB','name'=>'Unidad de Ciencias Basicas','email'=>'ucb@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'6'])->assignRole('Usuario');
        User::create(['username'=>'EISI','name'=>'Escuela de Ingeniería de Sistemas Informáticos','email'=>'sistemas@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'5'])->assignRole('Usuario');

        User::create(['username'=>'Secretaria1','name'=>'Secretario','email'=>'secretaria1@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'4'])->assignRole('Administrador');
        User::create(['username'=>'Secretaria2','name'=>'Secretario','email'=>'secretaria2@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'4'])->assignRole('Administrador');
        User::create(['username'=>'Secretaria3','name'=>'Secretario','email'=>'secretaria3@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'4'])->assignRole('Administrador');
        User::create(['username'=>'Secretario','name'=>'Raul','apellido'=>'Fabian','email'=>'raul.fabian@ues.edu.sv','password'=>'12345','puesto_id'=>'4'])->assignRole('Administrador');
    }
}
