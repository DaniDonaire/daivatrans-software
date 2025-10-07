<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Models\Audit;
use Illuminate\Support\Facades\DB;
use App\Models\Lead;
use App\Models\Service;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (view()->exists($request->path())) {
            return view($request->path());
        }
        return abort(404);
    }

    public function root()
    {
        $totalLeads = Lead::count();

        // Leads por servicio con eloquent
        $leadsPorServicio = Service::query()
            ->withCount('leads')                 
            ->orderByDesc('leads_count')
            ->get(['id', 'name'])               
            ->map(function ($service) use ($totalLeads) {
                return (object) [
                    'servicio_nombre' => $service->name,
                    'total_leads'     => $service->leads_count,
                    'porcentaje'      => $totalLeads > 0
                        ? round(($service->leads_count * 100) / $totalLeads, 1)
                        : 0.0,
                ];
            });

        return view('index', compact('leadsPorServicio', 'totalLeads'));
    }

    public function lang($locale)
{
    // Lista de idiomas soportados (según los códigos de Google Translate)
    $availableLanguages = ['en', 'es', 'de', 'it', 'ru', 'zh', 'fr', 'ar'];

    // Si el idioma seleccionado está en la lista, lo cambiamos
    if (in_array($locale, $availableLanguages)) {
        Session::put('locale', $locale);
        App::setLocale($locale);
    }

    return redirect()->back(); // Redirigir sin pasar el idioma en la URL
}


    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        $user = User::find($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');

        if ($request->file('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('/images/');
            $avatar->move($avatarPath, $avatarName);
            $user->avatar =  $avatarName;
        }

        $user->update();
        if ($user) {
            Session::flash('message', 'User Details Updated successfully!');
            Session::flash('alert-class', 'alert-success');
            // return response()->json([
            //     'isSuccess' => true,
            //     'Message' => "User Details Updated successfully!"
            // ], 200); // Status code here
            return redirect()->back();
        } else {
            Session::flash('message', 'Something went wrong!');
            Session::flash('alert-class', 'alert-danger');
            // return response()->json([
            //     'isSuccess' => true,
            //     'Message' => "Something went wrong!"
            // ], 200); // Status code here
            return redirect()->back();

        }
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return response()->json([
                'isSuccess' => false,
                'Message' => "Your Current password does not matches with the password you provided. Please try again."
            ], 200); // Status code
        } else {
            $user = User::find($id);
            $user->password = Hash::make($request->get('password'));
            $user->update();
            if ($user) {
                Session::flash('message', 'Password updated successfully!');
                Session::flash('alert-class', 'alert-success');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Password updated successfully!"
                ], 200); // Status code here
            } else {
                Session::flash('message', 'Something went wrong!');
                Session::flash('alert-class', 'alert-danger');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Something went wrong!"
                ], 200); // Status code here
            }
        }
    }


    public function audit(Request $request) {
        $query = Audit::query();
        $users = User::all(); // Obtener la lista completa de usuarios
    
        // Filtrar por usuario (ahora usando el ID en lugar del nombre)
        if ($request->filled('user')) {
            $query->where('user_id', $request->user);
        }
    
        // Filtrar por modelo
        if ($request->filled('model')) {
            $query->where('auditable_type', $request->model);
        }
    
        // Filtrar por acción (created, updated, deleted)
        if ($request->filled('action')) {
            $query->where('event', $request->action);
        }
    
        // Filtrar por fecha
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
    
        // Obtener los registros paginados
        $audits = $query->latest()->paginate(10);
    
        // Obtener modelos únicos formateados correctamente
        $models = Audit::select('auditable_type')->distinct()->pluck('auditable_type');
    
        return view('audit.index', compact('audits', 'models', 'users'));
    }    
}
