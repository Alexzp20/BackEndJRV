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

        $solicitudesUsuario = [
            Permission::create(['name'=> 'crear solicitud']),
        ];

        $solicitudesAdmin = [
            
            Permission::create(['name'=> 'revisar solicitud']),
        ];


        //
        Role::create(['name'=>'Administrador'])->givePermissionTo([$solicitudesAdmin, $solicitudesUsuario]);
        Role::create(['name'=>'Asistente'])->givePermissionTo($solicitudesUsuario);
        Role::create(['name'=>'Escuela'])->givePermissionTo($solicitudesUsuario);
    }
}
