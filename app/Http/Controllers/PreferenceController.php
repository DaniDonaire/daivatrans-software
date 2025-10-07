<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreferenceController extends Controller
{
    public function update(Request $request)
    {
        $data = $request->validate([
            'dark_mode'      => ['sometimes', 'boolean'],
            'sidebar_pinned' => ['sometimes', 'boolean'],
        ]);

        $user = Auth::user();
        $pref = $user->preference()->firstOrCreate(['user_id' => $user->id]);

        if (array_key_exists('dark_mode', $data)) {
            $pref->dark_mode = (bool)$data['dark_mode'];
        }
        if (array_key_exists('sidebar_pinned', $data)) {
            $pref->sidebar_pinned = (bool)$data['sidebar_pinned'];
        }

        $pref->save();
    }
}
