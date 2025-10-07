<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Lang;

class CreateRolesAndAdmin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles 
        $roleAdmin = Role::create(['name' => 'administrador']);
        $roleComercial = Role::create(['name' => 'comercial']);

        // Lista de permisos optimizada
        $permissions = [
            'users_list',
            'users_show',
            'users_create',
            'users_edit_all',
            'users_edit_own',
            'users_delete',
            'users_change_password',
            'users_update_password',
            'roles_list',
            'roles_create',
            'roles_edit',
            'roles_destroy',
            'audit_list',
            'config_list',
        ];

        // Crear los permisos con traducciones dinámicas
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'display_name' => trans("permissions.{$permission}.display_name"),
                'description' => trans("permissions.{$permission}.description"),
            ]);
        }

        // Asignar permisos a un rol (Administrador)
        $roleAdmin->givePermissionTo($permissions);

        // Asignar permisos específicos al comercial
        $roleComercial->givePermissionTo([
            'users_list',
            'users_show',
            'users_edit_own',
        ]);

        // Crear usuario Administrador
        $userAdmin = User::create([
            'name' => 'Administrador',
            'email' => 'info@webcoding.es',
            'password' => bcrypt('12345678'),
        ]);
        $userAdmin->assignRole($roleAdmin);

        // Crear usuario Comercial
        $userComercial = User::create([
            'name' => 'Comercial',
            'email' => 'comercial@example.com',
            'password' => bcrypt('12345678'),
        ]);
        $userComercial->assignRole($roleComercial);
    }
}
