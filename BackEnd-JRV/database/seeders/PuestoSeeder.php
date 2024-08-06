<?php

namespace Database\Seeders;

use App\Models\Puesto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Puesto::create(['name'=>'Decano'])->rutas()->attach([1,2,3,4,6,7,8,9,10]);//1
        Puesto::create(['name'=>'Vice-Decano'])->rutas()->attach([1,2,3,4,6,7,8,9,10]);//2
        Puesto::create(['name'=>'Miembro Junta'])->rutas()->attach([1,4]);//3
        Puesto::create(['name'=>'Secretario'])->rutas()->attach([1,2,3,4,6,7,8,9,10]);//4
        Puesto::create(['name'=>'Escuela'])->rutas()->attach([1,4]);//5
        Puesto::create(['name'=>'Unidad'])->rutas()->attach([1,4]);//6
        Puesto::create(['name'=>'Administracion'])->rutas()->attach([1,4]);//7
        Puesto::create(['name'=>'Otro'])->rutas()->attach([1,4]);//8


    }
}
