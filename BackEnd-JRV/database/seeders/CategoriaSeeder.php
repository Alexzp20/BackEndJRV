<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\Subcategoria;


class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Categoria::create(['name'=>'SEGUIMIENTO']);
        Categoria::create(['name'=>'ASUNTOS DE INDOLE ACADEMICA']);
        Categoria::create(['name'=>'FUNCIONAMIENTO DE LA FACULTAD']);
        Categoria::create(['name'=>'MOVIMIENTO DE PERSONAL']);
        Categoria::create(['name'=>'VARIOS']);


        Subcategoria::create(['name'=>'Administracion Academica','categoria_id'=>'2']);
        Subcategoria::create(['name'=>'Comite Tecnico Asesor','categoria_id'=>'2']);
        Subcategoria::create(['name'=>'Direccion general de procesos de graduacion','categoria_id'=>'2']);
        Subcategoria::create(['name'=>'Otras solicitudes de indole academico','categoria_id'=>'2']);
        Subcategoria::create(['name'=>'Sin erogacion de fondos','categoria_id'=>'4']);
        Subcategoria::create(['name'=>'Con erogacion de fondos','categoria_id'=>'4']);

    }
}
