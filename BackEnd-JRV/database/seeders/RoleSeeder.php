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
        $permisosUsuario = [
            Permission::create(['name'=> 'crear solicitud']),
            Permission::create(['name'=> 'endpoints solicitud']),
            Permission::create(['name'=> 'estado solicitud']),
            Permission::create(['name'=> 'descargar solicitud']),
            Permission::create(['name'=> 'mostrar idUsuario']),
            Permission::create(['name'=> 'descargar acta']),
            Permission::create(['name'=> 'descargar Acuerdo']),
            Permission::create(['name'=> 'descargar informes']),
            Permission::create(['name'=> 'mostrar Categoria']),
            Permission::create(['name'=> 'mostrar SubCategoria']),
            Permission::create(['name'=> 'mostrar Agenda']),
            Permission::create(['name'=> 'mostrar idAgenda']),
        ];

        $permisosAsistente = [
            
            //permisos solicitudes
            Permission::create(['name'=> 'revisar solicitud']),
            Permission::create(['name'=> 'editar solicitud']),
            
            //permisos usuarios
            Permission::create(['name'=> 'mostrar Usuarios']),
            Permission::create(['name'=> 'crear usuario']),
            Permission::create(['name'=> 'actualizar usuario']),
            
            //permisos agenda
            Permission::create(['name'=> 'mostrar UsuAsistencia']),
            Permission::create(['name'=> 'crear Agenda']),
            Permission::create(['name'=> 'mostrar idAcuerdo']),
            Permission::create(['name'=> 'mostrar Puesto']),
            Permission::create(['name'=> 'mostrar Rol']),
            Permission::create(['name'=> 'actualizar agenda']),

            //permisos actas
            Permission::create(['name'=> 'crear acta']),
            Permission::create(['name'=> 'actualizar acta']),
            Permission::create(['name'=> 'borrar acta']),
            Permission::create(['name'=> 'mostrar acta']),
            Permission::create(['name'=> 'asignar Acta']),

            //permisos acuerdos
            Permission::create(['name'=> 'crear Acuerdo']),
            Permission::create(['name'=> 'actualizar Acuerdo']),
            Permission::create(['name'=> 'borrar Acuerdo']),
            Permission::create(['name'=> 'mostrar Acuerdo']),

            //permisos informes
            Permission::create(['name'=> 'crear informes']),
            Permission::create(['name'=> 'actualizar informes']),
            Permission::create(['name'=> 'eliminar informes']),
            Permission::create(['name'=> 'asignar informes']),
            Permission::create(['name'=> 'mostrar informes']),
            Permission::create(['name'=> 'remitente'])

        ];

        $permisosAdministrador = [
            Permission::create(['name'=> 'borrar usuario']),
            Permission::create(['name'=> 'crear Categoria']),
            Permission::create(['name'=> 'crear SubCategoria']),
            Permission::create(['name'=> 'publicar agenda']),
        ];
        
    


        Role::create(['name'=>'Administrador'])->givePermissionTo([$permisosAsistente, $permisosUsuario, $permisosAdministrador]);
        Role::create(['name'=>'Asistente'])->givePermissionTo([$permisosAsistente, $permisosUsuario]);
        Role::create(['name'=>'Usuario'])->givePermissionTo($permisosUsuario);
    }
}
