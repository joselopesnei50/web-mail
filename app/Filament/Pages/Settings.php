<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Setting;
use Illuminate\Support\Facades\Crypt;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationLabel = 'Configurações';
    protected static ?string $title = 'Configurações Globais (DeepSeek API)';
    
    protected static string $view = 'filament.pages.settings';

    public $deepseekKey;
    public $privacyPolicy;
    public $termsOfUse;

    public function mount()
    {
        abort_unless(auth()->user()->role === 'super_admin', 403);

        $deepseekSetting = Setting::where('key', 'deepseek_api_key')->first();
        if ($deepseekSetting && $deepseekSetting->value) {
            try {
                $this->deepseekKey = Crypt::decryptString($deepseekSetting->value);
            } catch (\Exception $e) {}
        }
    }

    public function save()
    {
        abort_unless(auth()->user()->role === 'super_admin', 403);

        if ($this->deepseekKey) {
            Setting::updateOrCreate(
                ['key' => 'deepseek_api_key'],
                ['value' => Crypt::encryptString($this->deepseekKey)]
            );
        }

        $this->notify('success', 'Configurações salvas com sucesso!');
    }
}
