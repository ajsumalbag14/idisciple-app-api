<?php

namespace App\Modules\User\Auth\Services;

use Hash;

use Illuminate\Http\Request;

use App\Modules\User\Profile\Models\User;

use App\Modules\User\Auth\Contracts\AuthCredentialsInterface;

class AuthCredentials implements AuthCredentialsInterface
{
    protected $userObject;

    public function __construct()
    {
        $this->userObject = new User;
    }

    public function verify(Request $request)
    {
        // get user details
        $user = $this->userObject->whereEmail($request->get('email'))->first();
        if ($user) {

            // check if user is first time user
            if ($user->first_time_user == 0) {
                if (Hash::check($request->get('password'), $user->temp_password)) {
                    $response = [
                        'status'    => 1,
                        'data'      => [
                            'user'  => $user
                        ]
                    ];
                } else {
                    $response = [
                        'status'    => 2,
                        'message'   => 'Invalid password'
                    ];
                }
            } else {
                // returning user    
                if (Hash::check($request->get('password'), $user->password)) {
                    $response = [
                        'status'    => 1,
                        'data'      => [
                            'user'  => $user
                        ]
                    ];
                } else {
                    $response = [
                        'status'    => 2,
                        'message'   => 'Invalid password'
                    ];
                }
            }

        } else {
            $response = [
                'status'    => 3,
                'message'   => 'Invalid email'
            ];
        }

        return $response;

    }
}