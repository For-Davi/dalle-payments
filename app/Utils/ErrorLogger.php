<?php

namespace App\Utils;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ErrorLogger
{
    public static function log(string $message, \Throwable $e, ?Request $request = null): void
    {
        $context = [
            'exception_message' => $e->getMessage(),
            'exception_file'    => $e->getFile(),
            'exception_line'    => $e->getLine(),
            'trace'             => $e->getTraceAsString(),
        ];

        if ($request) {
            $context['request'] = [
                'url'     => $request->fullUrl(),
                'method'  => $request->method(),
                'payload' => $request->all(),
                'query'   => $request->query(),
                'headers' => $request->headers->all(),
            ];
        }

        Log::error($message, $context);
    }
}
