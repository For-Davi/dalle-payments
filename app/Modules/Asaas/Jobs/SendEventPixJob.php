<?php

namespace App\Modules\Asaas\Jobs;

use App\Modules\Asaas\Event\PixPaid;
use App\Modules\Asaas\Event\PixFailed;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEventPixJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected bool $success;

    public function __construct(bool $success)
    {
        $this->success = $success;
    }

    public function handle(): void
    {
        if($this->success){
            broadcast(new PixPaid());
        } else {
            broadcast(new PixFailed());
        }
    }
}
