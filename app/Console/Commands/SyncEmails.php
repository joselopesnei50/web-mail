<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Webklex\IMAP\Facades\Client;
use App\Models\Email;
use App\Models\User;

class SyncEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync incoming emails via IMAP into the local database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Iniciando sincronização via IMAP...");

        $user = User::first();
        if (!$user) {
            $this->error("Nenhum usuário cadastrado.");
            return 1;
        }

        try {
            /** @var \Webklex\PHPIMAP\Client $client */
            $client = Client::account('default');
            $client->connect();

            $folder = $client->getFolder('INBOX');

            $messages = $folder->query()->unseen()->limit(10)->get();

            $count = 0;
            foreach ($messages as $message) {
                $subject = $message->getSubject();
                $body = $message->getTextBody() ?? $message->getHTMLBody() ?? '';
                
                $from = $message->getFrom()[0]->mail ?? 'desconhecido@exemplo.com';
                $to = $message->getTo()[0]->mail ?? $user->email;

                Email::create([
                    'user_id' => $user->id,
                    'sender' => $from,
                    'recipient' => $to,
                    'subject' => (string) $subject,
                    'body' => (string) $body,
                    'type' => 'inbox',
                    'is_read' => false,
                ]);

                $message->setFlag('Seen');
                $count++;
            }

            $this->info("Sincronização completa. {$count} novas mensagens recebidas.");
            return 0;

        } catch (\Exception $e) {
            $this->error("Erro ao sincronizar: " . $e->getMessage());
            return 1;
        }
    }
}
