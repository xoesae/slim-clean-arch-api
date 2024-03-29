<?php

namespace Domain\Exception;

class MustBeUniqueException extends \Exception
{
    const CODE = 409;
    const MESSAGE = 'Must be unique';

    protected $message;
    protected $code;

    public function __construct(string $message = self::MESSAGE)
    {
        parent::__construct($message, self::CODE);
    }
}