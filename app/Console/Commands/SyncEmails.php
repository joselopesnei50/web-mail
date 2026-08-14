<?php

namespace App\Console\Commands;

use App\Models\Email;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Webklex\PHPIMAP\ClientManager;

class SyncEmails extends Command
{
    protected $signature = 'mail:sync {--user= : sync apenas um user_id especifico}';

    protected $description = 'Sync IMAP inbox de cada usuario com caixa no docker-mailserver';

    public function handle(): int
    {
        $query = User::withoutGlobalScope(\App\Scopes\TenantScope::class)
            ->where('has_mailbox', true)
            ->whereNotNull('mailbox_password_encrypted');

        if ($id = $this->option('user')) {
            $query->where('id', $id);
        }

        $users = $query->get();
        if ($users->isEmpty()) {
            $this->warn('Nenhum usuario com caixa ativa para sincronizar.');
            return self::SUCCESS;
        }

        $host = config('imap.accounts.default.host');
        $port = (int) config('imap.accounts.default.port', 993);
        $encryption = config('imap.accounts.default.encryption', 'ssl');
        $validateCert = (bool) config('imap.accounts.default.validate_cert', true);
        $protocol = config('imap.accounts.default.protocol', 'imap');

        $totalNew = 0;

        foreach ($users as $user) {
            $password = $user->getMailboxPassword();
            if (! $password) {
                $this->warn("User#{$user->id} ({$user->email}): senha nao pode ser decriptada, pulando.");
                continue;
            }

            try {
                $cm = new ClientManager([
                    'accounts' => [
                        'default' => [
                            'host'          => $host,
                            'port'          => $port,
                            'encryption'    => $encryption,
                            'validate_cert' => $validateCert,
                            'username'      => $user->email,
                            'password'      => $password,
                            'protocol'      => $protocol,
                        ],
                    ],
                ]);
                $client = $cm->account('default');
                $client->connect();

                $folder = $client->getFolder('INBOX');
                $messages = $folder->query()->unseen()->limit(25)->get();

                $count = 0;
                foreach ($messages as $message) {
                    $subject = (string) $message->getSubject();
                    $body = $message->getTextBody() ?: (string) $message->getHTMLBody();
                    $from = $message->getFrom()[0]->mail ?? 'desconhecido@exemplo.com';
                    $to = $message->getTo()[0]->mail ?? $user->email;

                    $email = Email::withoutGlobalScope(\App\Scopes\TenantScope::class)->create([
                        'user_id'   => $user->id,
                        'sender'    => $from,
                        'recipient' => $to,
                        'subject'   => $subject,
                        'body'      => $body,
                        'type'      => 'inbox',
                        'is_read'   => false,
                    ]);
                    $email->forceFill(['company_id' => $user->company_id])->save();

                    foreach ($message->getAttachments() as $att) {
                        try {
                            $original = $att->getName() ?: ('attachment-' . $att->getId());
                            $safeName = preg_replace('/[^A-Za-z0-9._-]/', '_', $original);
                            $path = "attachments/{$user->id}/{$email->id}/" . uniqid('', true) . '_' . $safeName;
                            \Illuminate\Support\Facades\Storage::disk('local')->put($path, $att->getContent());
                            \App\Models\EmailAttachment::create([
                                'email_id'      => $email->id,
                                'path'          => $path,
                                'original_name' => $original,
                                'mime'          => $att->getContentType(),
                                'size'          => strlen($att->getContent()),
                            ]);
                        } catch (\Throwable $e) {
                            Log::warning('anexo IMAP falhou', ['email_id' => $email->id, 'error' => $e->getMessage()]);
                        }
                    }

                    if (class_exists(\App\Jobs\AnalyzeEmailWithBruceIA::class)) {
                        \App\Jobs\AnalyzeEmailWithBruceIA::dispatch($email);
                    }

                    $message->setFlag('Seen');
                    $count++;
                }

                $totalNew += $count;
                $this->info("User#{$user->id} ({$user->email}): +{$count} novas.");
            } catch (\Throwable $e) {
                Log::error('mail:sync falhou para user', ['user_id' => $user->id, 'email' => $user->email, 'error' => $e->getMessage()]);
                $this->error("User#{$user->id} ({$user->email}): {$e->getMessage()}");
            }
        }

        $this->info("Sync concluida. Total novas: {$totalNew}");
        return self::SUCCESS;
    }
}
