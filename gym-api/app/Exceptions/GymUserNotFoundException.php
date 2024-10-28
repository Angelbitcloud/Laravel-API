<?php

namespace App\Exceptions;

use Exception;

class GymUserNotFoundException extends Exception
{
    public function __construct($message = "User not found in gym system", $code = 404)
    {
        parent::__construct($message, $code);
    }
}
