<?php

namespace Domain\Exception;

class InvalidArgumentException extends \Exception
{
    const CODE = 422;
    const MESSAGE = 'Invalid argument';

    protected $message;
    protected $code;

    public function __construct(string $message = self::MESSAGE)
    {
        parent::__construct($message, self::CODE);
    }
}