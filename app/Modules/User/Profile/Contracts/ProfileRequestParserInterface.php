<?php

namespace App\Modules\User\Profile\Contracts;

use Illuminate\Http\Request;

interface ProfileRequestParserInterface
{
    public function create(Request $request);
    public function update(Request $request);
}