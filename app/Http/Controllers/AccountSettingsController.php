<?php

namespace App\Http\Controllers;

use App\Services\MailserverService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class AccountSettingsController extends Controller
{
    public function index(Request $request)
    {
        return view('account.settings', ['user' => $request->user()]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'display_name' => ['nullable', 'string', 'max:255'],
            'signature'    => ['nullable', 'string', 'max:5000'],
        ]);

        $request->user()->fill($data)->save();

        return redirect()->route('account.settings.index')->with('status', 'Perfil atualizado.');
    }

    public function updatePassword(Request $request, MailserverService $mailserver)
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = $request->user();
        $user->forceFill(['password' => Hash::make($data['password'])])->save();

        if ($user->has_mailbox) {
            $ok = $mailserver->updatePassword($user->email, $data['password']);
            if ($ok) {
                $user->setMailboxPassword($data['password']);
                $user->save();
                $msg = 'Senha atualizada (painel + servidor de email).';
            } else {
                Log::warning('updatePassword: mailserver falhou', ['user_id' => $user->id]);
                $msg = 'Senha do painel atualizada, mas nao foi possivel sincronizar com o servidor de email.';
            }
        } else {
            $msg = 'Senha atualizada.';
        }

        return redirect()->route('account.settings.index')->with('status', $msg);
    }
}
