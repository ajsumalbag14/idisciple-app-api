<?php

namespace App\Modules\User\Profile\Contracts;

interface ProfileResponseParserInterface
{
    public function created($multiArray);
    public function updated($multiArray);
}