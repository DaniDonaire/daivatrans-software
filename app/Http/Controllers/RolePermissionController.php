<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function __construct()
    {
        // Middleware para controlar el acceso a las diferentes acciones según permisos
        $this->middleware(['auth:web', 'permission:roles_list'])->only('index');
        $this->middleware(['auth:web', 'permission:roles_create'])->only(['create', 'store']);
        $this->middleware(['auth:web', 'permission:roles_edit'])->only(['edit', 'update']);
        $this->middleware(['auth:web', 'permission:roles_destroy'])->only('destroy');
    }

    /**
     * Muestra la lista de roles con opción de búsqueda y paginación.
     */
    public function index(Request $request)
    {
        $query = Role::query();

        // Filtrar por búsqueda
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Obtener cantidad de registros por página con un valor predeterminado de 10
        $perPage = $request->input('perPage', 10);
        $roles = $query->with('permissions')->paginate($perPage);

        return view('roles.index', compact('roles', 'perPage'));
    }

    /**
     * Muestra el formulario para crear un nuevo rol.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Guarda un nuevo rol en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'name' => 'required|unique:roles|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ], [
            'name.required' => trans('roles.role_name_required'),
            'name.unique' => trans('roles.role_name_unique'),
            'permissions.*.exists' => trans('roles.permissions_invalid'),
        ]);

        // Crear el rol
        $role = Role::create(['name' => $request->name]);

        // Asignar permisos si existen
        if ($request->has('permissions')) {
            $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
            $role->syncPermissions($permissionNames);
        }

        // Redireccionar con mensaje de éxito
        return redirect()->route('roles.index')->with('sweetalert', [
            'type' => 'success',
            'title' => trans('roles.success'),
            'text' => trans('roles.create_success'),
        ]);
    }

    /**
     * Muestra el formulario de edición de un rol.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Actualiza los datos de un rol en la base de datos.
     */
    public function update(Request $request, Role $role)
    {
        // Validar los datos de entrada
        $request->validate([
            'name' => 'required|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ], [
            'name.required' => trans('roles.role_name_required'),
            'name.unique' => trans('roles.role_name_unique'),
            'permissions.*.exists' => trans('roles.permissions_invalid'),
        ]);

        // Actualizar nombre del rol
        $role->update(['name' => $request->name]);

        // Actualizar permisos
        if ($request->has('permissions')) {
            $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
            $role->syncPermissions($permissionNames);
        } else {
            $role->syncPermissions([]);
        }

        // Redireccionar con mensaje de éxito
        return redirect()->route('roles.index')->with('sweetalert', [
            'type' => 'success',
            'title' => trans('roles.success'),
            'text' => trans('roles.update_success'),
        ]);
    }

    /**
     * Elimina un rol de la base de datos.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->with('sweetalert', [
            'type' => 'success',
            'title' => trans('roles.success'),
            'text' => trans('roles.delete_success'),
        ]);
    }
}
