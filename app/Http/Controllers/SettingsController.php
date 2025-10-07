<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Settings::all()->keyBy('key');
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'nullable|string|max:255',
            'favicon' => 'nullable|image|max:2048',
            'logo_rectangular' => 'nullable|image|max:2048',
            'logo_square' => 'nullable|image|max:2048',
        ], [
            'app_name.max' => trans('settings.validation_app_name'),
            'favicon.image' => trans('settings.validation_image'),
            'favicon.max' => trans('settings.validation_image'),
            'logo_rectangular.image' => trans('settings.validation_image'),
            'logo_rectangular.max' => trans('settings.validation_image'),
            'logo_square.image' => trans('settings.validation_image'),
            'logo_square.max' => trans('settings.validation_image'),
        ]);

        $this->saveSettings($request);

        return redirect()->route('settings.index')->with('success', trans('settings.update_success'));
    }

    private function saveSettings(Request $request)
    {
        $settings = [
            'app_name' => $request->input('app_name'),
            'favicon' => $request->file('favicon'),
            'logo_rectangular' => $request->file('logo_rectangular'),
            'logo_square' => $request->file('logo_square'),
        ];

        foreach ($settings as $key => $value) {
            if ($value instanceof \Illuminate\Http\UploadedFile) {
                $path = $value->store('settings', 'public');
                Settings::updateOrCreate(['key' => $key], ['value' => $path]);
            } elseif ($value !== null) {
                Settings::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }
    }
}
