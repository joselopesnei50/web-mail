<?php

namespace App\Services;

use App\Models\Email;
use App\Models\Setting;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BruceIAService
{
    /**
     * Analisa um e-mail utilizando a API do DeepSeek
     */
    public function analyzeEmail(Email $email)
    {
        $deepseekKeySetting = Setting::where('key', 'deepseek_api_key')->first();
        if (!$deepseekKeySetting || !$deepseekKeySetting->value) {
            Log::warning("BruceIA: DeepSeek API Key não configurada. Abortando análise.");
            return false;
        }

        try {
            $apiKey = Crypt::decryptString($deepseekKeySetting->value);
        } catch (\Exception $e) {
            Log::error("BruceIA: Erro ao descriptografar a API Key.");
            return false;
        }

        $systemPrompt = "Você é o BruceIA, um assistente corporativo de leitura de e-mails de clientes.
Sua tarefa é analisar o e-mail fornecido e retornar EXATAMENTE UM JSON válido com a seguinte estrutura, sem explicações adicionais ou marcação markdown (```json):
{
    \"sentiment\": \"Positivo|Negativo|Neutro|Raiva|Ansiedade\",
    \"urgency\": \"Baixa|Média|Alta|Crítica\",
    \"summary\": \"Um resumo de no máximo 2 linhas do que o cliente precisa\",
    \"suggested_reply\": \"Uma sugestão de resposta rápida, profissional e empática para o problema\"
}

Aqui está o e-mail:
Assunto: {$email->subject}
Mensagem: {$email->body}";

        // Tenta usar o Laravel AI SDK se disponível
        if (function_exists('agent')) {
            try {
                // Definindo a chave do DeepSeek dinamicamente via config para a chamada atual
                config(['ai.providers.deepseek.key' => $apiKey]);
                
                $response = agent()
                    ->provider('deepseek')
                    ->prompt($systemPrompt);
                
                $jsonResponse = $response->text();
            } catch (\Exception $e) {
                // Fallback para HTTP se der erro no agent()
                $jsonResponse = $this->fallbackHttp($apiKey, $systemPrompt);
            }
        } else {
            // Fallback usando Http Facade puro se o SDK não estiver rodando no PHP local
            $jsonResponse = $this->fallbackHttp($apiKey, $systemPrompt);
        }

        if (!$jsonResponse) return false;

        // Limpar possíveis blocos markdown do retorno do LLM
        $jsonResponse = str_replace(['```json', '```'], '', $jsonResponse);
        $data = json_decode(trim($jsonResponse), true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
            $email->aiReport()->updateOrCreate(
                ['email_id' => $email->id],
                [
                    'sentiment' => $data['sentiment'] ?? 'Neutro',
                    'urgency' => $data['urgency'] ?? 'Baixa',
                    'summary' => $data['summary'] ?? '',
                    'suggested_reply' => $data['suggested_reply'] ?? '',
                ]
            );
            return true;
        }

        Log::error("BruceIA: Resposta inválida da IA.", ['response' => $jsonResponse]);
        return false;
    }

    private function fallbackHttp(string $apiKey, string $prompt)
    {
        $response = Http::withToken($apiKey)
            ->post('https://api.deepseek.com/chat/completions', [
                'model' => 'deepseek-chat',
                'messages' => [
                    ['role' => 'system', 'content' => $prompt]
                ],
                'temperature' => 0.1,
                'response_format' => ['type' => 'json_object']
            ]);

        if ($response->successful()) {
            return $response->json('choices.0.message.content');
        }

        Log::error("BruceIA: Erro na chamada HTTP", ['error' => $response->body()]);
        return null;
    }
}
