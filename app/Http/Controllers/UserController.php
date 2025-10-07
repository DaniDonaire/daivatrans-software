<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:web', 'permission:users_list'])->only('index');
        $this->middleware(['auth:web', 'permission:users_create'])->only(['create', 'store']);
        $this->middleware(['auth:web', 'permission:users_edit_own|users_edit_all'])->only(['edit', 'update']);
        $this->middleware(['auth:web', 'permission:users_show'])->only('show');
        $this->middleware(['auth:web', 'permission:users_delete'])->only('destroy');
        $this->middleware(['auth:web', 'permission:users_change_password'])->only(['changePassword', 'updatePassword']);
    }
    public function search(Request $request)
    {
        $search = $request->search;
        $users = User::where('name', 'LIKE', "%$search%")->limit(10)->get();
    
        return response()->json($users->map(function ($user) {
            return ['id' => $user->id, 'text' => $user->name];
        }));
    }
    public function index(Request $request)
    {
        $query = User::query()->where('deshabilitado', false);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $perPage = $request->input('perPage', 10);
        $users = $query->paginate($perPage);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'avatar' => 'nullable|image|max:2048',
            'nombre' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required',
        ], [
            'password.confirmed' => trans('users.password_confirm_error'),
        ]);
 
        $user = User::create([
            'name' => $request->input('nombre'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        // Verificar si se ha subido un avatar
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->syncRoles($request->input('roles'));

        // Guardar el usuario en la base de datos
        $user->save();
        
        return redirect()->route('users.index')->with('sweetalert', [
            'type' => 'success',
            'title' => trans('users.success'),
            'text' => trans('users.create_success'),
        ]);
    
    }

    public function show($id)
    {
        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $currentUser = Auth::user(); // Obtener el usuario autenticado
    

        // Validar permisos
        if ($currentUser->can('users_edit_all')) {
            // Puede editar todos los usuarios, incluyendo cambiar roles
            return view('users.edit', compact('user', 'roles', 'currentUser'))->with('canEditRoles', true);
        } elseif ($currentUser->can('users_edit_own') && $currentUser->id === $user->id) {
            // Puede editar su propio perfil, pero no cambiar roles
            return view('users.edit', compact('user', 'roles', 'currentUser'))->with('canEditRoles', false);
        } else {
            abort(403, trans('users.no_permission'));
        }
    }
    
    

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id); // Usuario que se está editando
            $currentUser = Auth::user(); // Usuario actual (autenticado)
    
            // Validar datos básicos
            $rules = [
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users', 'email')->ignore($user->id), // Ignora al usuario actual
                ],
                'avatar' => 'nullable|image|max:2048',
            ];
    
            // Validar contraseña solo si se envía y dependiendo del caso
            if ($request->has('password') && $request->filled('password')) {
                if ($currentUser->id === $user->id && !$currentUser->can('users_edit_all')) {
                    // Validar contraseña actual para el propio usuario
                    $rules['current_password'] = 'required|string';
                    if (!Hash::check($request->input('current_password'), $user->password)) {
                        return redirect()->back()->with('sweetalert', [
                            'type' => 'error',
                            'title' => trans('users.error'),
                            'text' => trans('users.password_current_error'),
                        ]);
                    }
                }
            }
    
            $request->validate($rules);
    
            // Actualizar datos básicos
            $user->name = $request->input('name');
            $user->email = $request->input('email');
    
            // Actualizar el avatar
            if ($request->file('avatar')) {

                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $user->avatar = $request->file('avatar')->store('avatars', 'public');
            }            
    
            // Cambiar roles solo si el usuario tiene permiso
            if ($currentUser->can('users_edit_all') && $request->has('role')) {
                $user->syncRoles([$request->input('role')]);
            }
    
            $user->save();
    
            // Redirección según el caso
            if ($currentUser->id === $user->id) {
                // Redirige al perfil si es el propio usuario
                return redirect()->route('users.edit', $user->id)->with('sweetalert', [
                    'type' => 'success',
                    'title' => trans('users.success'),
                    'text' => trans('users.profile_update_success'),
                ]);                
            } else {
                // Redirige al índice si el administrador editó otro perfil
                return redirect()->route('users.index')->with('sweetalert', [
                    'type' => 'success',
                    'title' => trans('users.success'),
                    'text' => trans('users.user_update_success'),
                ]);                
            }
        } catch (\Throwable $e) {
            // Manejar errores y redirigir con SweetAlert
            if ($currentUser->id === $user->id) {
                return redirect()->route('users.index')->with('sweetalert', [
                    'type' => 'error',
                    'title' => trans('users.error'),
                    'text' => trans('users.error_updating') . ': ' . $e->getMessage(),
                ]);                
            } else {
                return redirect()->route('users.edit', $user->id)->with('sweetalert', [
                    'type' => 'error',
                    'title' => trans('users.error'),
                    'text' => trans('users.error_updating_profile') . ': ' . $e->getMessage(),
                ]);                
            }
        }
    }

    
    public function destroy(User $user)
    {
        $user->deshabilitado = true;
        $user->save();

        return redirect()->route('users.index')->with('sweetalert', [
            'type' => 'success',
            'title' => trans('users.success'),
            'text' => trans('users.user_disabled_success'),
        ]);        
    }

    public function updatePassword(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id); // Usuario a editar
            $currentUser = Auth::user(); // Usuario autenticado
    
            $rules = [
                'password' => 'required|string|min:8|confirmed', // Nueva contraseña y confirmación
            ];
    
            // Si el usuario edita su propio perfil y no tiene permiso `users_edit_all`
            if ($currentUser->id === $user->id && !$currentUser->can('users_edit_all')) {
                $rules['current_password'] = 'required|string'; // Requiere contraseña actual
                if (!Hash::check($request->input('current_password'), $user->password)) {
                    return redirect()->back()->with('sweetalert', [
                        'type' => 'error',
                        'title' => trans('users.error'),
                        'text' => trans('users.password_current_error'),
                    ]);
                }
            }
    
            $request->validate($rules, [
                'password.required' => trans('users.password_required'),
                'password.string' => trans('users.password_invalid_format'),
                'password.min' => trans('users.password_min_error', ['min' => 8]),
                'password.confirmed' => trans('users.password_confirm_error'),
            ]);
    
            // Actualizar contraseña
            $user->password = Hash::make($request->input('password'));
            $user->save();
    
            // Redirección según el caso
            if ($currentUser->id === $user->id) {
                return redirect()->route('users.edit', $user->id)->with('sweetalert', [
                    'type' => 'success',
                    'title' => trans('users.success'),
                    'text' => trans('users.password_update_success'),
                ]);
            } else {
                return redirect()->route('users.index')->with('sweetalert', [
                    'type' => 'success',
                    'title' => trans('users.success'),
                    'text' => trans('users.user_password_update_success'),
                ]);
            }
        } catch (\Throwable $e) {
            return redirect()->route('users.index')->with('sweetalert', [
                'type' => 'error',
                'title' => trans('users.error'),
                'text' => trans('users.error_updating_password') . ': ' . $e->getMessage(),
            ]);
        }
    }
    
}
