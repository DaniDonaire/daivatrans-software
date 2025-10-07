<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class DetectUserLanguage
{
    public function handle($request, Closure $next)
    {
        // Si el usuario ya tiene un idioma en sesión, lo usamos
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
            Log::info('🌍 [Detección de Idioma] Usando idioma desde sesión: ' . Session::get('locale'));

            return $next($request);
        }

        // Obtener idioma del navegador (puede ser 'es-ES', 'es-MX', etc.)
        $browserLang = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);

        // Mapeo de códigos de idioma personalizados a códigos de Google Translate
        $languageMap = [
            'sp' => 'es', // Si Laravel lo detecta como 'sp', convertirlo a 'es'
            'es' => 'es', // Español
            'en' => 'en', // Inglés
            'de' => 'de', // Alemán
            'it' => 'it', // Italiano
            'ru' => 'ru', // Ruso
            'zh' => 'zh', // Chino
            'fr' => 'fr', // Francés
            'ar' => 'ar', // Árabe
        ];

        // Convertir el idioma detectado al código correcto (o usar 'en' por defecto)
        $locale = $languageMap[$browserLang] ?? 'en';

        // Guardar en sesión y aplicar el idioma
        Session::put('locale', $locale);
        App::setLocale($locale);

        Log::info("🌍 [Detección de Idioma] Idioma detectado del navegador: {$browserLang} → Configurado como: {$locale}");

        return $next($request);
    }
}
