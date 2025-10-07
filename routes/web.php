<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SettingsController;
use App\Models\Audit;
use Illuminate\Http\Request;
use App\Http\Controllers\OcrController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ContactMethodController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\WorkerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

// Ruta editar usuarios
Route::resource('users', UserController::class)->middleware('auth:sanctum');
Route::post('/users/{user}/change-password', [UserController::class, 'changePassword'])->name('users.change-password')->middleware('auth:web'); 
Route::post('/users/{user}/update-password', [UserController::class, 'updatePassword'])->name('users.update-password')->middleware('auth:web'); 
Route::resource('roles', RolePermissionController::class);

// Ruta de auditorías con filtros
Route::get('/audits',  [App\Http\Controllers\HomeController::class, 'audit'])->name('audit.index');
Route::get('/users/search', [UserController::class, 'search'])->name('users.search');

// Rutas para la gestión de leads
Route::prefix('leads')->group(function () {
    Route::get('/', [LeadController::class, 'index'])->name('leads.index');
    Route::get('/create', [LeadController::class, 'create'])->name('leads.create');
    Route::post('/', [LeadController::class, 'store'])->name('leads.store');
    Route::get('/{lead}/edit', [LeadController::class, 'edit'])->name('leads.edit');
    Route::put('/{lead}', [LeadController::class, 'update'])->name('leads.update');
    Route::patch('/{lead}/status', [LeadController::class, 'updateStatus'])->name('leads.updateStatus');
    Route::delete('/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');
    Route::get('/{id}', [LeadController::class, 'show'])->name('leads.show');
    Route::post('/{id}/property', [LeadController::class, 'saveProperty'])->name('leads.saveProperty');
});

    // Exportar datos de clientes
    Route::get('/clientes/export/all', [LeadController::class, 'exportAll'])->name('clientes.export.all');
    Route::get('/clientes/export/webcoding', [LeadController::class, 'exportWebcoding'])->name('clientes.export.webcoding');

    Route::post('/leads/import', [LeadController::class, 'importLeads'])->name('leads.import');

    // Rutas para la gestión de status
    Route::resource('status', StatusController::class);
    Route::post('/status/store2', [StatusController::class, 'store2'])->name('status.store2');
    Route::post('/status/update-colors', [StatusController::class, 'updateColors'])->name('status.updateColors');

    // Rutas para servicios
    Route::resource('services', ServiceController::class);

    // Rutas para métodos de contacto
    Route::resource('contact-methods', ContactMethodController::class);

    //Rutas para gestión de notas
    Route::post('/leads/{lead}/notes', [LeadController::class, 'storeNote'])->name('leads.storeNote');
    Route::delete('/leads/{lead}/notes/{note}', [LeadController::class, 'destroyNote'])->name('leads.destroyNote');
    Route::put('/leads/{lead}/notes/{note}', [LeadController::class, 'updateNote'])->name('leads.updateNote');


Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/create', [SettingsController::class, 'create'])->name('logos.create');
    Route::post('/settings', [SettingsController::class, 'store'])->name('settings.store');
    Route::delete('/settings', [SettingsController::class, 'destroy'])->name('settings.destroy');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::get('/ocr', [OcrController::class, 'index'])->name('ocr.index');
    Route::post('/ocr', [OcrController::class, 'process'])->name('ocr.process');


});
// Ejemplo uso auth:sanctum (Solo pueden acceder a esta ruta los usuarios autenticados)
//Route::resource('ejemplos', EjemploController::class)->middleware('auth:sanctum');
// Ejemplo uso optional.auth (Puede entrar cualquiera, pero si entra un usuario autenticado puedes obtener sus datos de usuario)
//Route::resource('ejemplos', EjemploController::class)->middleware('optional.auth');

// Ruta para preferencias de usuario (dark mode, sidebar pinned)
Route::middleware(['auth'])->group(function () {
    Route::post('/preferences', [PreferenceController::class, 'update'])
        ->name('preferences.update');
});

// Trabajadores

Route::get('/trabajadores', [WorkerController::class,'index'])->name('workers.index');


// ↓↓↓ IMPORATANTE PONER LAS RUTAS ENCIMA DE ESTA ↓↓↓
Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');


// Mostrar configuraciones
Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');

// Crear configuraciones
Route::get('settings/create', [SettingsController::class, 'create'])->name('settings.create');
Route::post('settings', [SettingsController::class, 'store'])->name('settings.store');

// Editar configuraciones
Route::get('settings/edit', [SettingsController::class, 'edit'])->name('settings.edit');
Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');



// Eliminar configuraciones
Route::delete('settings', [SettingsController::class, 'destroy'])->name('settings.destroy');