<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Crypt;

class SettingsController extends Controller
{
    public function index()
    {
        // Apenas super_admin
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Acesso não autorizado');
        }

        $deepseekKeySetting = Setting::where('key', 'deepseek_api_key')->first();
        $deepseekKey = '';
        if ($deepseekKeySetting && $deepseekKeySetting->value) {
            try {
                $deepseekKey = Crypt::decryptString($deepseekKeySetting->value);
            } catch (\Exception $e) {
                // Erro de desencriptação
            }
        }

        $privacyPolicy = Setting::where('key', 'privacy_policy')->value('value');
        $termsOfUse = Setting::where('key', 'terms_of_use')->value('value');

        return view('settings.index', compact('deepseekKey', 'privacyPolicy', 'termsOfUse'));
    }

    public function update(Request $request)
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Acesso não autorizado');
        }

        $request->validate([
            'deepseek_api_key' => 'nullable|string',
            'privacy_policy' => 'nullable|string',
            'terms_of_use' => 'nullable|string',
        ]);

        if ($request->filled('deepseek_api_key')) {
            $encryptedKey = Crypt::encryptString($request->deepseek_api_key);
            Setting::updateOrCreate(
                ['key' => 'deepseek_api_key'],
                ['value' => $encryptedKey]
            );
        }

        if ($request->has('privacy_policy')) {
            Setting::updateOrCreate(['key' => 'privacy_policy'], ['value' => $request->privacy_policy]);
        }

        if ($request->has('terms_of_use')) {
            Setting::updateOrCreate(['key' => 'terms_of_use'], ['value' => $request->terms_of_use]);
        }

        return redirect()->route('settings.index')->with('success', 'Configurações atualizadas com sucesso!');
    }
}
