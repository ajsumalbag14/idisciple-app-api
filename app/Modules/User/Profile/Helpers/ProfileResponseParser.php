<?php

namespace App\Modules\User\Profile\Helpers;

use App\Modules\User\Profile\Contracts\ProfileResponseParserInterface;

class ProfileResponseParser implements ProfileResponseParserInterface
{
    public function created($multiArray)
    {
        // api callback
        $responseParam = [
            'user_access'   => [
                    'user_id'       => $multiArray['user']['user_id'],
                    'username'      => $multiArray['user']['email'],
                    'password'      => $multiArray['user']['password'],
                    'fcm_token'     => $multiArray['user']['fcm_token']
            ],
            'profile'       => [
                    'firstname'     => $multiArray['profile']['firstname'],
                    'lastname'      => $multiArray['profile']['lastname'],
                    'middlename'    => $multiArray['profile']['middlename'],
                    'nickname'      => $multiArray['profile']['nickname'],
                    'mobile_no'     => $multiArray['profile']['mobile_no'],
                    'birthdate'     => $multiArray['profile']['birthdate'],
                    'gender'        => $multiArray['profile']['gender'],
                    'country'       => $multiArray['profile']['country'],
                    'is_pwd'        => $multiArray['profile']['is_pwd'],
                    'created_at'    => $multiArray['profile']['created_at']
            ]   
        ];

        return $responseParam;
    }

    public function updated($multiArray)
    {
        //
    }
}