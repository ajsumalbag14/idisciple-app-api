<?php

namespace App\Modules\User\Auth\Contracts;

interface AuthResponseFormatterInterface 
{
    public function prepare($objectData);
}