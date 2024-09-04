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
        User::create(['username'=>'vicedecano','name'=>'Ana Beatriz','apellido'=>'Lima de Zaldaña','email'=>'ana.lima@ues.edu.sv', 'password'=>'12345','puesto_id'=>'2'])->assignRole('Administrador');


        //Usuarios junta
        //Propietarios
        User::create(['username'=>'junta01','name'=>'Silvia Milagro','apellido'=>'Mayorga de Orellana','email'=>'silvia.mayorga@ues.edu.sv', 'password'=>'12345','puesto_id'=>'3'])->assignRole('Usuario');
        User::create(['username'=>'junta02','name'=>'Andrés Omar','apellido'=>'Aguilar Menéndez','email'=>'andres.aguilar@ues.edu.sv', 'password'=>'12345','puesto_id'=>'3'])->assignRole('Usuario');
        User::create(['username'=>'junta03','name'=>'Domingo Benjamín','apellido'=>'Flores Melara','email'=>'domingo.flores@ues.edu.sv', 'password'=>'12345','puesto_id'=>'3'])->assignRole('Usuario');
        User::create(['username'=>'junta04','name'=>'Jorge Alberto','apellido'=>'Basagoitia García','email'=>'jorge.basagoitia@ues.edu.sv', 'password'=>'12345','puesto_id'=>'3'])->assignRole('Usuario');
        User::create(['username'=>'junta05','name'=>'Esteban Natanael','apellido'=>'Ramos Rivera','email'=>'rr19146@ues.edu.sv', 'password'=>'12345','puesto_id'=>'3'])->assignRole('Usuario');
        User::create(['username'=>'junta06','name'=>'Yesenia Abigail','apellido'=>'Jimenez Venavides','email'=>'jv19007@ues.edu.sv', 'password'=>'12345','puesto_id'=>'3'])->assignRole('Usuario');
        //Suplentes
        User::create(['username'=>'junta07','name'=>'Daniel Antonio','apellido'=>'Magaña Magaña','email'=>'daniel.magana@ues.edu.sv', 'password'=>'12345','puesto_id'=>'3'])->assignRole('Usuario');
        User::create(['username'=>'junta08','name'=>'Wilfredo','apellido'=>'Amaya Zelaya','email'=>'amayazelaya@gmail.com', 'password'=>'12345','puesto_id'=>'3'])->assignRole('Usuario');
        User::create(['username'=>'junta09','name'=>'Marco Antonio','apellido'=>'Alfaro Hernández','email'=>'marco.alfaro@ues.edu.sv', 'password'=>'12345','puesto_id'=>'3'])->assignRole('Usuario');
        User::create(['username'=>'junta10','name'=>'Carlos Alfredo','apellido'=>'Mejía Mejía','email'=>'mm13197@ues.edu.sv', 'password'=>'12345','puesto_id'=>'3'])->assignRole('Usuario');
        User::create(['username'=>'junta11','name'=>'Pablo Alfredo','apellido'=>'Monterrosa Valle','email'=>'mv20038@ues.edu.sv', 'password'=>'12345','puesto_id'=>'3'])->assignRole('Usuario');
        
        
        User::create(['username'=>'rodrigo01','name'=>'Rodrigo','apellido'=>'Zelaya','email'=>'zf17004@ues.edu.sv','password'=>'12345','puesto_id'=>'4'])->assignRole('Administrador');
        User::create(['username'=>'pedro02','name'=>'Pedro','apellido'=>'Zavaleta','email'=>'zp19013@ues.edu.sv','password'=>'12345','puesto_id'=>'4'])->assignRole('Asistente');
        User::create(['username'=>'diegodcc','name'=>'Diego','apellido'=>'Castro','email'=>'cc17018@ues.edu.sv','password'=>'12345','puesto_id'=>'4'])->assignRole('Asistente');
        
        
        User::create(['username'=>'decanato','name'=>'Decanato FIA','email'=>'decanato@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'7'])->assignRole('Usuario');
        User::create(['username'=>'vicedecanato','name'=>'Vicedecanato FIA','email'=>'vicedecanato@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'7'])->assignRole('Usuario');
        User::create(['username'=>'CTA FIA','name'=>'Comite Tecnico Asesor FIA','email'=>'comite.tecnico@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'6'])->assignRole('Usuario');
        User::create(['username'=>'DGPG','name'=>'Dirección General de Procesos de Graduación','email'=>'trabajos.graduacion@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'6'])->assignRole('Usuario');
        User::create(['username'=>'administracionFIA','name'=>'Administracion General FIA','email'=>'administracion.general@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'7'])->assignRole('Usuario');
        User::create(['username'=>'academicaFIA','name'=>'Administracion Academica FIA','email'=>'academica1.ingenieria@ues.edu.sv','password'=>'12345','puesto_id'=>'7'])->assignRole('Usuario');
        User::create(['username'=>'planificacionFIA','name'=>'Unidad de Planificacion FIA','email'=>'planificacion@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'6'])->assignRole('Usuario');
        User::create(['username'=>'Proyeccion social','name'=>'Unidad de Proyección Social','email'=>'proyeccionsocial@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'6'])->assignRole('Usuario');
        User::create(['username'=>'FIA-NET','name'=>'FIA-NET','email'=>'fianet@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'6'])->assignRole('Usuario');
        User::create(['username'=>'biblioteca','name'=>'Biblioteca FIA','email'=>'biblioteca@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'6'])->assignRole('Usuario');
        User::create(['username'=>'CIAN','name'=>'CIAN','email'=>'cian@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'6'])->assignRole('Usuario');
        User::create(['username'=>'UMS-FIA','name'=>'Unidad de Mantenimiento y Servicios FIA','email'=>'mantenimiento@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'6'])->assignRole('Usuario');
        User::create(['username'=>'investigacionFIA','name'=>'Unidad de Investigación FIA','email'=>'investigaciones@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'6'])->assignRole('Usuario');
        User::create(['username'=>'EIC','name'=>'Escuela de Ingeniería Civil','email'=>'civil@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'5'])->assignRole('Usuario');
        User::create(['username'=>'EII','name'=>'Escuela de Ingeniería Industrial','email'=>'industrial@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'5'])->assignRole('Usuario');
        User::create(['username'=>'EIM','name'=>'Escuela de Ingeniería Mecánica','email'=>'mecanica@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'5'])->assignRole('Usuario');
        User::create(['username'=>'EIE','name'=>'Escuela de Ingeniería Eléctrica','email'=>'electrica@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'5'])->assignRole('Usuario');
        User::create(['username'=>'EIQ','name'=>'Escuela de Ingeniería Química','email'=>'ingenieria.quimica@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'5'])->assignRole('Usuario');
        User::create(['username'=>'Arquitectura','name'=>'Escuela de Arquitectura','email'=>'arquitectura@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'5'])->assignRole('Usuario');
        User::create(['username'=>'EISI','name'=>'Escuela de Ingeniería de Sistemas Informáticos','email'=>'sistemas@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'5'])->assignRole('Usuario');
        User::create(['username'=>'EP','name'=>'Escuela de Posgrado','email'=>'uposgrados@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'5'])->assignRole('Usuario');
        User::create(['username'=>'UCB','name'=>'Unidad de Ciencias Basicas','email'=>'ucb@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'6'])->assignRole('Usuario');
        User::create(['username'=>'UAIP','name'=>'Enlace de Unidad de Acceso a la Información Pública','email'=>'enlace.uaip@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'6'])->assignRole('Usuario');
        User::create(['username'=>'CGDA','name'=>'Coordinación de Gestión Documental y Archivo','email'=>'Ugda.fia@ues.edu.sv','password'=>'12345','puesto_id'=>'6'])->assignRole('Usuario');
        User::create(['username'=>'UVE','name'=>'Unidad de Vida Estudiantil','email'=>'vidaestudiantil@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'6'])->assignRole('Usuario');
    


        User::create(['username'=>'Secretaria1','name'=>'Secretario','email'=>'secretaria1@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'4'])->assignRole('Administrador');
        User::create(['username'=>'Secretaria2','name'=>'Secretario','email'=>'secretaria2@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'4'])->assignRole('Administrador');
        User::create(['username'=>'Secretaria3','name'=>'Secretario','email'=>'secretaria3@fia.ues.edu.sv','password'=>'12345','puesto_id'=>'4'])->assignRole('Administrador');
        User::create(['username'=>'Secretario','name'=>'Raul','apellido'=>'Fabian','email'=>'raul.fabian@ues.edu.sv','password'=>'12345','puesto_id'=>'4'])->assignRole('Administrador');



    }
}
