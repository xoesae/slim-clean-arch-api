<?php

namespace Domain\Exception;

class MustBeUniqueException extends \Exception
{
    const CODE = 409;
    protected $message;
    protected $code;

    public function __construct(string $message)
    {
        parent::__construct($message, self::CODE);
    }
}