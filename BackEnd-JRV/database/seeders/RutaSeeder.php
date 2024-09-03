<?php

namespace Database\Seeders;

use App\Models\Ruta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RutaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Ruta::create(['ruta'=>'/buzon','titulo'=>'Solicitudes','ruta_imagen'=>'/images/MenuInicio/Solicitudes.png']);
        Ruta::create(['ruta'=>'/informe','titulo'=>'Informes','ruta_imagen'=>'/images/MenuInicio/Informe.png']);
        Ruta::create(['ruta'=>'/acta','titulo'=>'Actas','ruta_imagen'=>'/images/MenuInicio/Acta.png']);
        Ruta::create(['ruta'=>'/buscador','titulo'=>'Buscador','ruta_imagen'=>'/images/MenuInicio/Buscador.png']);
        //Ruta::create(['ruta'=>'/estadistico','titulo'=>'Estadisticos','ruta_imagen'=>'/images/MenuInicio/Estadisticos.png']);
        Ruta::create(['ruta'=>'/usuarios','titulo'=>'Usuarios','ruta_imagen'=>'/images/MenuInicio/Usuario.png']);
        //Ruta::create(['ruta'=>'/buzon/revision','titulo'=>'Revision','ruta_imagen'=>'/images/Buzon/Revision.png']);//<-------
        //Ruta::create(['ruta'=>'/agenda/nueva','titulo'=>'Nueva Agenda','ruta_imagen'=>'/images/MenuInicio/Nuevo.png']);
        Ruta::create(['ruta'=>'/agenda','titulo'=>'Menu Agendas','ruta_imagen'=>'/images/MenuInicio/Nuevo.png']);
        Ruta::create(['ruta'=>'/acuerdo','titulo'=>'Acuerdos','ruta_imagen'=>'/images/MenuInicio/Acuerdo.png']);

    }
}
