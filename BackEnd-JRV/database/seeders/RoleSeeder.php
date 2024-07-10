<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        //Solicitudes
        $solicitudesUsuario = [
            Permission::create(['name'=> 'crear solicitud']),
        ];

        $solicitudesAdmin = [
            
            Permission::create(['name'=> 'revisar solicitud']),
        ];
        $endpointsSolicutud = [
            
            Permission::create(['name'=> 'endpoints solicitud']),
        ];
        $mostrarEstadoSolicutud = [
            
            Permission::create(['name'=> 'estado solicitud']),
        ];
        $editarAsistentes = [
            
            Permission::create(['name'=> 'editar Asistentes']),
        ];
        
        ///
        $descargarSolicitud = [
            
            Permission::create(['name'=> 'descargar solicitud']),
        ];

        //Crud Usuario
        $mostrarUsuarios = [
            
            Permission::create(['name'=> 'mostrar Usuarios']),
        ];
        $mostrarUsuariosAsistencia = [
            
            Permission::create(['name'=> 'mostrar UsuAsistencia']),
        ];
        $puestoUsuario = [
            
            Permission::create(['name'=> 'mostrar Puesto']),
        ];
        $mostrarIDUsuario = [
            
            Permission::create(['name'=> 'mostrar idUsuario']),
        ];
        $crearUsuarios = [
            
            Permission::create(['name'=> 'crear usuario']),
        ];
        $actualizarUsuario = [
            
            Permission::create(['name'=> 'actualizar usuario']),
        ];
        $borrarUsuario = [
            
            Permission::create(['name'=> 'borrar usuario']),
        ];
        //

        //Crud de actas 
        $crearActas = [
            
            Permission::create(['name'=> 'crear acta']),
        ];
        $actualizarActa = [
            
            Permission::create(['name'=> 'actualizar acta']),
        ];
        $borrarActa = [
            
            Permission::create(['name'=> 'borrar acta']),
        ];
        $mostrarActa = [
            
            Permission::create(['name'=> 'mostrar acta']),
        ];
        $asignarActa = [
            
            Permission::create(['name'=> 'asignar Acta']),
        ];
        $descargarActa = [
            
            Permission::create(['name'=> 'descargar acta']),
        ];

        //

        //crud de Acuerdos
        $crearAcuerdo = [
            
            Permission::create(['name'=> 'crear Acuerdo']),
        ];
        $actualizarAcuerdo = [
            
            Permission::create(['name'=> 'actualizar Acuerdo']),
        ];
        $borrarAcuerdo = [
            
            Permission::create(['name'=> 'borrar Acuerdo']),
        ];
        $descargarAcuerdo = [
            
            Permission::create(['name'=> 'descargar Acuerdo']),
        ];
        
        
        //

        //crud de Informes
        $crearInformes = [
            
            Permission::create(['name'=> 'crear informes']),
        ];
        $actualizarInformes = [
            
            Permission::create(['name'=> 'actualizar informes']),
        ];
        $eliminarInformes = [
            
            Permission::create(['name'=> 'eliminar informes']),
        ];
        $asignarInformes = [
            
            Permission::create(['name'=> 'asignar informes']),
        ];
        $mostrarInformes = [
            
            Permission::create(['name'=> 'mostrar informes']),
        ];
        $descargarInformes = [
            
            Permission::create(['name'=> 'descargar informes']),
        ];

        //

        //Categoria
        $crearCategoria = [
            
            Permission::create(['name'=> 'crear Categoria']),
        ];
        $mostrarCategoria = [
            
            Permission::create(['name'=> 'mostrar Categoria']),
        ];

        //subCategoria
        $crearSubCategoria = [
            
            Permission::create(['name'=> 'crear SubCategoria']),
        ];
        $mostrarIdCategoria = [
            
            Permission::create(['name'=> 'mostrar SubCategoria']),
        ];

        //Agenda
        $mostrarAgenda = [
            
            Permission::create(['name'=> 'mostrar Agenda']),
        ];
        $crearAgenda = [
            
            Permission::create(['name'=> 'crear Agenda']),
        ];
        $mostrarIDAgenda = [
            
            Permission::create(['name'=> 'mostrar idAgenda']),
        ];
        $mostrarIDAcuerdo= [
            
            Permission::create(['name'=> 'mostrar idAcuerdo']),
        ];

        //Puesto
        $mostrarPuesto = [
            
            Permission::create(['name'=> 'mostrar Puesto']),
        ];

        //ROL
        $crearRol = [
            
            Permission::create(['name'=> 'crear Rol']),
        ];


        $mostrarAcuerdo = [
            
            Permission::create(['name'=> 'mostrar Acuerdo']),
        ];
        














        Role::create(['name'=>'Administrador'])->givePermissionTo([$solicitudesAdmin, $solicitudesUsuario]);
        Role::create(['name'=>'Asistente'])->givePermissionTo($solicitudesUsuario);
        Role::create(['name'=>'Escuela'])->givePermissionTo($solicitudesUsuario);
        Role::create(['name'=>'Unidad'])->givePermissionTo($solicitudesUsuario);
    }
}
