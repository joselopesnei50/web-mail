<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MailserverService
{
    public function addAccount(string $email, string $password): bool
    {
        if (! $this->isValidEmail($email) || strlen($password) < 8) {
            Log::warning('MailserverService::addAccount rejeitado — email ou senha invalidos', ['email' => $email]);
            return false;
        }

        $cmd = sprintf(
            'docker exec mailserver setup email add %s %s',
            escapeshellarg($email),
            escapeshellarg($password)
        );

        Log::info("SaaS Mailserver: comando preparado para {$email}", ['cmd_masked' => 'docker exec mailserver setup email add '.$email.' ***']);

        if (! env('MAILSERVER_CLI_ENABLED', false)) {
            return true;
        }

        $output = shell_exec($cmd);
        return $output !== null && str_contains($output, 'Success');
    }

    public function removeAccount(string $email): bool
    {
        if (! $this->isValidEmail($email)) {
            Log::warning('MailserverService::removeAccount rejeitado — email invalido', ['email' => $email]);
            return false;
        }

        $cmd = sprintf(
            'docker exec mailserver setup email del %s',
            escapeshellarg($email)
        );

        Log::info("SaaS Mailserver: comando preparado para remover {$email}");

        if (! env('MAILSERVER_CLI_ENABLED', false)) {
            return true;
        }

        $output = shell_exec($cmd);
        return $output !== null;
    }

    private function isValidEmail(string $email): bool
    {
        return Validator::make(['email' => $email], ['email' => 'required|email:rfc'])->passes();
    }
}
