<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use App\Services\MailserverService;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function (User $record) {
                    if ($record->has_mailbox) {
                        app(MailserverService::class)->removeAccount($record->email);
                    }
                }),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $role = $data['role'] ?? null;
        $plainPassword = $data['password'] ?? null;
        unset($data['role']);

        if ($plainPassword) {
            $data['password'] = Hash::make($plainPassword);
        } else {
            unset($data['password']);
        }

        $record->update($data);
        if ($role !== null) {
            $record->forceFill(['role' => $role])->save();
        }

        if ($plainPassword && $record->has_mailbox) {
            $ok = app(MailserverService::class)->updatePassword($record->email, $plainPassword);
            if ($ok) {
                $record->setMailboxPassword($plainPassword);
                $record->save();
            } else {
                Notification::make()
                    ->warning()
                    ->title('Senha do painel alterada, mas mailserver falhou')
                    ->body('A senha da caixa nao foi atualizada. Cheque MAILSERVER_CLI_ENABLED.')
                    ->send();
            }
        }

        return $record;
    }
}
