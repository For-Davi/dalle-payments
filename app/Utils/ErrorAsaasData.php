<?php

namespace App\Utils;

use Illuminate\Http\Request;
use Exception;

class ErrorAsaasData
{
    public static function hasError(array $response, string $alternativeMessage): void
    {
    if(isset($response['errors'])){
    $message = $response['errors'][0]['description'] ?? $alternativeMessage;
    throw new Exception($message);
    }
    }
}
