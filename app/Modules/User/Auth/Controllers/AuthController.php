<?php

namespace App\Modules\User\Auth\Controllers;

use App\Http\Controllers\Controller;

class AuthController extends Controller {

    protected $module = "Auth";

    private $_test;

    public function __construct() 
    {
        $this->_test = 'Arvin Test';         
    }

    public function test()
    {
        return response()->json([
            'name' => $this->_test,
            'state' => 'Success'
        ], 200);
    }
}