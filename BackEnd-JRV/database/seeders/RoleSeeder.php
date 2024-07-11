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

        $permisosAdmin = [
            
            Permission::create(['name'=> 'revisar solicitud']),
            Permission::create(['name'=> 'editar Asistentes']),
            Permission::create(['name'=> 'mostrar Usuarios']),
            Permission::create(['name'=> 'mostrar UsuAsistencia']),
            Permission::create(['name'=> 'mostrar PuestoU']),
            Permission::create(['name'=> 'crear usuario']),
            Permission::create(['name'=> 'actualizar usuario']),
            Permission::create(['name'=> 'borrar usuario']),
            Permission::create(['name'=> 'crear Categoria']),
            Permission::create(['name'=> 'crear SubCategoria']),
            Permission::create(['name'=> 'crear Agenda']),
            Permission::create(['name'=> 'mostrar idAcuerdo']),
            Permission::create(['name'=> 'mostrar Puesto']),
            Permission::create(['name'=> 'mostrar Rol']),

        ];
        
        
        //Crud de actas 
        $crudActas = [
            Permission::create(['name'=> 'crear acta']),
            Permission::create(['name'=> 'actualizar acta']),
            Permission::create(['name'=> 'borrar acta']),
            Permission::create(['name'=> 'mostrar acta']),
            Permission::create(['name'=> 'asignar Acta']),
        ];


        //crud de Acuerdos
        $crudAcuerdo = [
            Permission::create(['name'=> 'crear Acuerdo']),
            Permission::create(['name'=> 'actualizar Acuerdo']),
            Permission::create(['name'=> 'borrar Acuerdo']),
            Permission::create(['name'=> 'mostrar Acuerdo']),
        ];
        
        //

        //crud de Informes
        $crudInformes = [
            Permission::create(['name'=> 'crear informes']),
            Permission::create(['name'=> 'actualizar informes']),
            Permission::create(['name'=> 'eliminar informes']),
            Permission::create(['name'=> 'asignar informes']),
            Permission::create(['name'=> 'mostrar informes']),

        ]; 
    



        Role::create(['name'=>'Administrador'])->givePermissionTo([$permisosAdmin, $permisosUsuario, $crudActas, $crudAcuerdo, $crudInformes]);
        Role::create(['name'=>'Asistente'])->givePermissionTo([$permisosAdmin, $permisosUsuario]);
        Role::create(['name'=>'Escuela'])->givePermissionTo($permisosUsuario);
        Role::create(['name'=>'Unidad'])->givePermissionTo($permisosUsuario);
    }
}
