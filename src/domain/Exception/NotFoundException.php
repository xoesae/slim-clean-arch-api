<?php

namespace Domain\Exception;

class NotFoundException extends \Exception
{
    protected $message = "Not Found";
    protected $code = 404;

}