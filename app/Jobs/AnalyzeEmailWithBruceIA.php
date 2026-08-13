<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Email;
use App\Services\BruceIAService;
use Illuminate\Support\Facades\Log;

class AnalyzeEmailWithBruceIA implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $email;

    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(BruceIAService $bruceIA): void
    {
        Log::info("Iniciando análise do e-mail ID {$this->email->id} pelo BruceIA");
        $bruceIA->analyzeEmail($this->email);
    }
}
