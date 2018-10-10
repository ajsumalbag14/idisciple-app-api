<?php

namespace App\Modules\User\Profile\Contracts;

interface ProfileResponseParserInterface
{
    public function created($multiArray);
    public function updatedPassword($array);
    public function updated($multiArray);
}