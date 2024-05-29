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
        Puesto::create(['name'=>'Decano']);
        Puesto::create(['name'=>'Miembro Junta']);
        Puesto::create(['name'=>'Asistente']);
    }
}
