<?php

namespace Zyrus\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    public function render()
    {
        dd($this);
    }
}