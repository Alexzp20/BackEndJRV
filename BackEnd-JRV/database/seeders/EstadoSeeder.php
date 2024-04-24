<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estado;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Estado::create(['id'=>'1','name'=>'SUBIDO']);
        Estado::create(['id'=>'2','name'=>'ACEPTADO']);
        Estado::create(['id'=>'3','name'=>'RECHAZO']);
        Estado::create(['id'=>'4','name'=>'APROBADO']);
        Estado::create(['id'=>'5','name'=>'DENEGADO']);
        Estado::create(['id'=>'6','name'=>'PENDIENTE']);

    }
}
