<?php

namespace App\Modules\User\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Auth\Models\User;

class AuthController extends Controller {

    protected $module = "Auth";

    private $_test;
    private $_repoUser;

    public function __construct(User $user) 
    {
        $this->_test = 'Arvin Test';
        $this->_repoUser = $user;         
    }

    public function test()
    {
        return response()->json([
            'name' => $this->_test,
            'state' => 'Success'
        ], 200);
    }

    public function testDB()
    {
        //select user table
        try {
            $resource = $this->_repoUser::find(1);

            return response()->json([
                'DB connection state'   => 'Success',
                'Name'                  => $resource->name,
                'Timestamp'             => $resource->created_at
            ], 200);
        } catch (\Illuminate\Database\QueryException $ex) { 
            return response()->json([
                'code'      => 500,
                'status'    => 'ER000',
                'message'   => $ex
            ], 500);
        }
    }
}