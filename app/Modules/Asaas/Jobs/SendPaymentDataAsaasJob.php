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

    protected $data;

    protected string $baseUrl;

    public function __construct($data, string $baseUrl)
    {
        $this->data = $data;
        $this->baseUrl = $baseUrl;
    }

    public function handle(): void
    {
        Http::withHeaders([
            'accept'       => 'application/json',
            'Content-Type' => 'application/json',
            'access-token' => config('app.access_token'),
        ])->post("{$this->baseUrl}/send-webhook", $this->data);
    }
}
