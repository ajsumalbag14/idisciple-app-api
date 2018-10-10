<?php

namespace App\Modules\User\Profile\Helpers;

use Validator;
use Hash;
use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Modules\User\Profile\Contracts\ProfileRequestParserInterface;

class ProfileRequestParser implements ProfileRequestParserInterface
{

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), 
            [
                'firstname'         => 'required|string:max=50',
                'lastname'          => 'required|string:max=50',
                'nickname'          => 'string:max=50',
                'email'             => 'required|email',
                'mobile_no'         => 'string:max=13'
            ]
        );

        if ($validator->fails()) {
            \Log::debug($validator->errors());
            $response = [
                'status'    => 2,
                'message'   => 'Invalid input.'
            ];
        } else {
            $profile_param = [
                'firstname'     => $request->get('firstname'),
                'lastname'      => $request->get('lastname'),
                'middlename'    => $request->get('middlename'),
                'nickname'      => $request->get('nickname'),
                'mobile_no'     => $request->get('mobile_no'),
                'birthdate'     => $request->get('birthdate'),
                'gender'        => $request->get('gender'),
                'country'       => $request->get('country'),
                'is_pwd'        => $request->get('is_pwd') == 1 ? 1 : 0,
                'created_at'    => Carbon::now()
            ];

            $user_param = [
                'name'          => $request->get('firstname').' '.$request->get('lastname'),
                'email'         => $request->get('email'),
                'password'      => str_random(20),
                'temp_password' => Hash::make(str_random(20)),
                'is_active'     => 1,
                'created_at'    => Carbon::now()
            ];

            $response = [
                'status'    => 1,
                'data'      => [
                        'user'      => $user_param,
                        'profile'   => $profile_param
                    ]
                ];
        }
        

        return $response;

    }

    public function update(Request $request)
    {
        //
    }
}