<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MailserverService
{
    public function addAccount(string $email, string $password): bool
    {
        if (! $this->isValidEmail($email) || strlen($password) < 8) {
            Log::warning('MailserverService::addAccount rejeitado', ['email' => $email]);
            return false;
        }

        return $this->runSetup(['email', 'add', $email, $password], 'add', $email);
    }

    public function updatePassword(string $email, string $password): bool
    {
        if (! $this->isValidEmail($email) || strlen($password) < 8) {
            Log::warning('MailserverService::updatePassword rejeitado', ['email' => $email]);
            return false;
        }

        return $this->runSetup(['email', 'update', $email, $password], 'update', $email);
    }

    public function removeAccount(string $email): bool
    {
        if (! $this->isValidEmail($email)) {
            Log::warning('MailserverService::removeAccount rejeitado', ['email' => $email]);
            return false;
        }

        return $this->runSetup(['email', 'del', '-y', $email], 'del', $email);
    }

    public function accountExists(string $email): bool
    {
        if (! $this->isValidEmail($email)) {
            return false;
        }

        [$ok, $out] = $this->execRaw(['email', 'list']);
        if (! $ok) {
            return false;
        }
        return str_contains($out, "* {$email}");
    }

    private function runSetup(array $args, string $op, string $email): bool
    {
        [$ok, $out] = $this->execRaw($args);

        if (! $ok) {
            Log::error("MailserverService::{$op} falhou", ['email' => $email, 'output' => trim($out)]);
            return false;
        }

        Log::info("MailserverService::{$op} sucesso", ['email' => $email]);
        return true;
    }

    private function execRaw(array $setupArgs): array
    {
        if (! config('mailserver.cli_enabled', false)) {
            Log::info('MailserverService dry-run (mailserver.cli_enabled=false)', ['args' => $setupArgs]);
            return [true, ''];
        }

        $container = config('mailserver.container', 'mailserver');
        $dockerBin = config('mailserver.docker_bin', '/usr/bin/docker');
        $prefix = config('mailserver.use_sudo', true) ? 'sudo -n ' : '';

        $parts = [$prefix . $dockerBin, 'exec', escapeshellarg($container), 'setup'];
        foreach ($setupArgs as $a) {
            $parts[] = escapeshellarg($a);
        }
        $cmd = trim(implode(' ', $parts)) . ' 2>&1';

        $output = [];
        $exitCode = -1;
        exec($cmd, $output, $exitCode);
        return [$exitCode === 0, implode("\n", $output)];
    }

    private function isValidEmail(string $email): bool
    {
        return Validator::make(['email' => $email], ['email' => 'required|email:rfc'])->passes();
    }
}
