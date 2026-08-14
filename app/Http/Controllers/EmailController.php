<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\EmailAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EmailController extends Controller
{
    public function inbox(Request $request)
    {
        $folder = $request->query('folder', 'inbox');
        $emails = Email::where('user_id', auth()->id())
            ->where('type', $folder)
            ->orderBy('created_at', 'desc')
            ->get();

        $selectedEmail = null;
        if ($request->has('id')) {
            $selectedEmail = Email::with('attachments')->find($request->query('id'));
            if ($selectedEmail && $selectedEmail->user_id === auth()->id() && ! $selectedEmail->is_read) {
                $selectedEmail->update(['is_read' => true]);
            }
        }

        $compose = $request->has('compose') || $request->has('reply') || $request->has('forward');
        $prefill = ['recipient' => '', 'subject' => '', 'body' => '', 'in_reply_to_id' => null];

        if ($replyId = $request->query('reply')) {
            $orig = Email::where('user_id', auth()->id())->find($replyId);
            if ($orig) {
                $prefill = [
                    'recipient' => $orig->sender,
                    'subject'   => $this->prefixSubject('Re:', $orig->subject),
                    'body'      => "\n\n---\nEm " . $orig->created_at->format('d/m/Y H:i') . ", {$orig->sender} escreveu:\n" . $this->quoteBody($orig->body),
                    'in_reply_to_id' => $orig->id,
                ];
            }
        } elseif ($fwdId = $request->query('forward')) {
            $orig = Email::where('user_id', auth()->id())->find($fwdId);
            if ($orig) {
                $prefill = [
                    'recipient' => '',
                    'subject'   => $this->prefixSubject('Fwd:', $orig->subject),
                    'body'      => "\n\n---------- Mensagem encaminhada ----------\nDe: {$orig->sender}\nData: " . $orig->created_at->format('d/m/Y H:i') . "\nAssunto: {$orig->subject}\n\n{$orig->body}",
                    'in_reply_to_id' => null,
                ];
            }
        }

        $unreadCount = Email::where('user_id', auth()->id())->where('type', 'inbox')->where('is_read', false)->count();

        return view('dashboard', compact('emails', 'folder', 'selectedEmail', 'compose', 'unreadCount', 'prefill'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'recipient'       => 'required|email',
            'subject'         => 'nullable|string|max:255',
            'body'            => 'required|string',
            'attachments.*'   => 'file|max:20480', // 20 MB por arquivo
            'in_reply_to_id'  => 'nullable|integer',
        ]);

        $user = $request->user();
        $company = $user->company;

        if ($company && $company->max_emails_month) {
            $sentThisMonth = Email::where('user_id', $user->id)
                ->where('type', 'sent')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();

            if ($sentThisMonth >= $company->max_emails_month) {
                return redirect()->route('dashboard', ['compose' => true])
                    ->with('status', "Cota mensal atingida ({$company->max_emails_month} envios). Contate seu administrador.");
            }
        }

        $subject = $request->input('subject') ?: '(Sem Assunto)';
        $body = $request->input('body');
        if ($user->signature) {
            $body .= "\n\n-- \n" . $user->signature;
        }
        $recipient = $request->input('recipient');
        $senderEmail = $user->email;
        $senderName = $user->display_name ?: $user->name;

        $files = $request->file('attachments', []);

        try {
            Mail::raw($body, function ($message) use ($recipient, $subject, $senderEmail, $senderName, $files) {
                $message->to($recipient)
                        ->subject($subject)
                        ->from($senderEmail, $senderName);
                foreach ($files as $file) {
                    if ($file && $file->isValid()) {
                        $message->attach($file->getRealPath(), [
                            'as'   => $file->getClientOriginalName(),
                            'mime' => $file->getClientMimeType(),
                        ]);
                    }
                }
            });
        } catch (\Throwable $e) {
            return redirect()->route('dashboard', ['compose' => true])
                ->with('status', 'Erro de SMTP: ' . $e->getMessage());
        }

        $email = Email::create([
            'user_id'   => $user->id,
            'sender'    => $senderEmail,
            'recipient' => $recipient,
            'subject'   => $subject,
            'body'      => $body,
            'type'      => 'sent',
            'is_read'   => true,
        ]);

        foreach ($files as $file) {
            if ($file && $file->isValid()) {
                $stored = $file->store("attachments/{$user->id}/{$email->id}", 'local');
                EmailAttachment::create([
                    'email_id'      => $email->id,
                    'path'          => $stored,
                    'original_name' => $file->getClientOriginalName(),
                    'mime'          => $file->getClientMimeType(),
                    'size'          => $file->getSize(),
                ]);
            }
        }

        \App\Jobs\AnalyzeEmailWithBruceIA::dispatch($email);

        return redirect()->route('dashboard')->with('status', 'E-mail enviado com sucesso.');
    }

    public function downloadAttachment(EmailAttachment $attachment)
    {
        $email = $attachment->email;
        abort_unless($email && $email->user_id === auth()->id(), 403);
        abort_unless(Storage::disk('local')->exists($attachment->path), 404);

        return Storage::disk('local')->download($attachment->path, $attachment->original_name, [
            'Content-Type' => $attachment->mime ?: 'application/octet-stream',
        ]);
    }

    private function prefixSubject(string $prefix, ?string $subject): string
    {
        $s = trim((string) $subject);
        if ($s === '') return $prefix;
        return str_starts_with(strtolower($s), strtolower($prefix)) ? $s : $prefix . ' ' . $s;
    }

    private function quoteBody(?string $body): string
    {
        if (! $body) return '';
        return "> " . str_replace("\n", "\n> ", trim($body));
    }
}
