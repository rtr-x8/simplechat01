<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

class ChatBotLogicException extends Exception
{
    protected $message;
    protected $code;
    private array $data;

    public function __construct($message = "", $code = 0, Throwable $previous = null, array $data = [])
    {
        parent::__construct($message, $code, $previous);

        $this->message = $message;
        $this->code = $code;
        $this->data = $data;
    }

    public function report(): void
    {
        Log::alert(
            '[ChatBotLogicException] '.$this->message,
            $this->data
        );
    }
}
