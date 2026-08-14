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

        $subject = $request->subject ?? '(Sem Assunto)';
        $body = $request->body;
        $recipient = $request->recipient;
        $senderEmail = $user->email;
        $senderName = $user->name;

        try {
            Mail::raw($body, function ($message) use ($recipient, $subject, $senderEmail, $senderName) {
                $message->to($recipient)
                        ->subject($subject)
                        ->from($senderEmail, $senderName);
            });
        } catch (\Exception $e) {
            return redirect()->route('dashboard', ['compose' => true])->with('status', 'Erro de SMTP: ' . $e->getMessage());
        }

        $email = Email::create([
            'user_id' => $user->id,
            'sender' => $senderEmail,
            'recipient' => $recipient,
            'subject' => $subject,
            'body' => $body,
            'type' => 'sent',
            'is_read' => true,
        ]);

        \App\Jobs\AnalyzeEmailWithBruceIA::dispatch($email);

        return redirect()->route('dashboard')->with('status', 'E-mail enviado via SMTP com sucesso! (Análise IA Iniciada)');
    }
}
