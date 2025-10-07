<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;     
use Illuminate\Support\Facades\App;      
use App\Models\Settings;
// use Session;                          // mejor: Illuminate\Support\Facades\Session
use Illuminate\Support\Facades\Session;  // <-- si usas Session::has(...)
use App\Observers\RoleObserver;
use App\Traits\AuditableRole;
use Spatie\Permission\Models\Role as SpatieRole;
use App\Models\Role;
use App\Models\UserPreference;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SpatieRole::class, Role::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        if (Schema::hasTable('settings')) {
            $settings = Settings::all()->pluck('value', 'key')->toArray();
            Config::set('settings', $settings);  
            // dd($settings);
        } 

        Role::observe(RoleObserver::class);
        // Aplicar dinámicamente el trait al modelo de Spatie sin modificarlo
        if (!in_array('OwenIt\Auditing\Contracts\Auditable', class_implements(Role::class))) {
            Role::mixin(new class {
                use AuditableRole;
            });
        }

        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }

        View::composer('*', function ($view) {
            $prefs = null;

            if (Schema::hasTable('user_preferences') && Auth::check()) {
                // Requiere que exista el modelo App\Models\UserPreference y su tabla
                $prefs = UserPreference::firstOrCreate(
                    ['user_id' => Auth::id()],
                    ['dark_mode' => false, 'sidebar_pinned' => false]
                );
            }

            // $userPrefs estará disponible en TODAS las vistas Blade
            $view->with('userPrefs', $prefs);
        });

    }
}