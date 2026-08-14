<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use App\Services\MailserverService;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $role = $data['role'] ?? 'user';
        $plainPassword = $data['password'] ?? null;
        $createMailbox = ! empty($data['create_mailbox']);

        unset($data['role'], $data['create_mailbox']);

        if ($plainPassword) {
            $data['password'] = Hash::make($plainPassword);
        }

        /** @var User $user */
        $user = static::getModel()::create($data);
        $user->forceFill(['role' => $role])->save();

        if ($createMailbox && $plainPassword) {
            $ok = app(MailserverService::class)->addAccount($user->email, $plainPassword);
            $user->setMailboxPassword($plainPassword);
            $user->forceFill(['has_mailbox' => $ok])->save();

            if (! $ok) {
                Log::warning('MailserverService::addAccount retornou false na criacao', ['user_id' => $user->id, 'email' => $user->email]);
                Notification::make()
                    ->warning()
                    ->title('Usuario criado, mas conta no mailserver falhou')
                    ->body('Confira MAILSERVER_CLI_ENABLED no .env e permissoes docker do www-data.')
                    ->send();
            }
        }

        return $user;
    }
}
