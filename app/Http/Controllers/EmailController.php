<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

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
            $selectedEmail = Email::find($request->query('id'));
            if ($selectedEmail && $selectedEmail->user_id === auth()->id() && !$selectedEmail->is_read) {
                $selectedEmail->update(['is_read' => true]);
            }
        }

        $compose = $request->has('compose');
        
        // Contadores para o menu lateral
        $unreadCount = Email::where('user_id', auth()->id())->where('type', 'inbox')->where('is_read', false)->count();

        return view('dashboard', compact('emails', 'folder', 'selectedEmail', 'compose', 'unreadCount'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'recipient' => 'required|email',
            'subject' => 'nullable|string|max:255',
            'body' => 'required|string',
        ]);

        $subject = $request->subject ?? '(Sem Assunto)';
        $body = $request->body;
        $recipient = $request->recipient;
        $senderEmail = auth()->user()->email;
        $senderName = auth()->user()->name;

        // Disparo real via SMTP
        try {
            Mail::raw($body, function ($message) use ($recipient, $subject, $senderEmail, $senderName) {
                $message->to($recipient)
                        ->subject($subject)
                        ->from($senderEmail, $senderName);
            });
        } catch (\Exception $e) {
            return redirect()->route('dashboard', ['compose' => true])->with('status', 'Erro de SMTP: ' . $e->getMessage());
        }

        // Salvar na pasta "Enviados" localmente
        $email = Email::create([
            'user_id' => auth()->id(),
            'sender' => $senderEmail,
            'recipient' => $recipient,
            'subject' => $subject,
            'body' => $body,
            'type' => 'sent',
            'is_read' => true,
        ]);

        // Disparar análise de IA em background
        \App\Jobs\AnalyzeEmailWithBruceIA::dispatch($email);

        return redirect()->route('dashboard')->with('status', 'E-mail enviado via SMTP com sucesso! (Análise IA Iniciada)');
    }
}
