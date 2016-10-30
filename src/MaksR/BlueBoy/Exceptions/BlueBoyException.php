<?php

namespace MaksR\BlueBoy\Exceptions;

class BlueBoyException extends \Exception
{
    public function __construct(string $message = '', array $elements = [], int $code = 0)
    {
        parent::__construct(
            vsprintf($message, $elements),
            $code
        );
    }
}
