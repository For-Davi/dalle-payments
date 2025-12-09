<?php

namespace App\Modules\Asaas\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendPaymentDataAsaasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $data;

    protected string $token;

    protected string $baseUrl;

    public function __construct(array $data, string $baseUrl)
    {
        $this->data = $data;
        $this->baseUrl = $baseUrl;
        $this->token = config('app.access_token');
    }

    public function handle(): void
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'access-token' => $this->token,
        ])->post("{$this->baseUrl}/send-webhook", $this->data);
    }
}
