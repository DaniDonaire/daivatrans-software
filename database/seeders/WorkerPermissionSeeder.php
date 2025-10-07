<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class WorkerPermissionSeeder extends Seeder
{
    public function run()
    {
        // Lista de permisos para workers
        $permissions = [
            'workers_list',
            'workers_show',
            'workers_create',
            'workers_edit',
            'workers_destroy',
        ];

        // Crear los permisos con traducciones dinámicas
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'display_name' => trans("permissions.{$permission}.display_name"),
                'description' => trans("permissions.{$permission}.description"),
            ]);
        }

        // Asignar permisos al rol administrador
        $roleAdmin = Role::where('name', 'administrador')->first();
        if ($roleAdmin) {
            $roleAdmin->givePermissionTo($permissions);
        }

        // Asignar permisos específicos al comercial
        $roleComercial = Role::where('name', 'comercial')->first();
        if ($roleComercial) {
            $roleComercial->givePermissionTo([
                'workers_list',
                'workers_show'
            ]);
        }
    }
}