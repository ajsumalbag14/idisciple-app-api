<?php

namespace App\Modules\User\Profile\Helpers;

use App\Modules\User\Profile\Contracts\ProfileResponseParserInterface;

class ProfileResponseParser implements ProfileResponseParserInterface
{
    public function created($multiArray)
    {
        // api callback
        $responseParam[] = [
            'user_access'   => [
                    'user_id'       => $multiArray['user']['user_id'],
                    'username'      => $multiArray['user']['email'],
                    'password'      => $multiArray['user']['password'],
                    'api_token'     => $multiArray['user']['token'],
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
            ],
            'event_details'       => [
                    'workshop_id_1'     => $multiArray['profile']['workshop_id_1'],
                    'workshop_id_2'     => $multiArray['profile']['workshop_id_2'],
                    'family_group_id'   => $multiArray['profile']['family_group_id'],
                    'tshirt_size'       => $multiArray['profile']['tshirt_size'],
                    'device'            => $multiArray['profile']['device'],
                    'city_tour'         => $multiArray['profile']['city_tour'],
                    'room_number'       => $multiArray['profile']['room_number']
            ]   
        ];

        return $responseParam;
    }

    public function updatedPassword($array)
    {
        // api callback
        $responseParam = [
            'user_id'       => $array['user_id'],
            'username'      => $array['email'],
            'api_token'     => $array['token'],
            'fcm_token'     => $array['fcm_token']
        ];

        return $responseParam;
    }

    public function updated($multiArray)
    {
        //
    }
}