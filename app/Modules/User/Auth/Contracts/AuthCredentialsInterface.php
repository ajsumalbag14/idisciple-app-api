<?php

namespace App\Modules\User\Auth\Contracts;

use Illuminate\Http\Request;

interface AuthCredentialsInterface {

    public function verify(Request $request);
    
}