<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class MailserverService
{
    /**
     * Adiciona uma nova conta de e-mail no servidor real (Docker Mailserver).
     * 
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function addAccount(string $email, string $password): bool
    {
        // Aqui conectamos no CLI do servidor via SSH ou localmente via docker exec
        // Comando base: docker exec mailserver setup email add <email> <password>
        
        $command = escapeshellcmd("docker exec mailserver setup email add {$email} {$password}");
        
        // Simulação para o ambiente atual (pois não temos o docker mailserver rodando no local)
        Log::info("SaaS Mailserver: Conta {$email} seria criada no servidor com sucesso.");
        
        // Na AWS, descomentaríamos a execução real:
        // $output = shell_exec($command);
        // return str_contains($output, 'Success');

        return true;
    }

    /**
     * Remove uma conta de e-mail do servidor real (Docker Mailserver).
     * 
     * @param string $email
     * @return bool
     */
    public function removeAccount(string $email): bool
    {
        // Comando base: docker exec mailserver setup email del <email>
        Log::info("SaaS Mailserver: Conta {$email} seria removida do servidor com sucesso.");
        return true;
    }
}
