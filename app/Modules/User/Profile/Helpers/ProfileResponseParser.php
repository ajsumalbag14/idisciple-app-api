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
                    'room_number'       => $multiArray['profile']['room_number'],
                    'img_name'          => $multiArray['profile']['img_name'],
                    'img_path'          => $multiArray['profile']['img_path']
            ]   
        ];

        return $responseParam;
    }

    public function allUsers($multiArray)
    {
        $responseParam = [];
        $pathFile = ENV('ASSETS_PATH_URL');
        $pathFileHeader = $pathFile.'/profile_header.json';
        $pathFileFooter = $pathFile.'/footer.json';
        $pathFileBody = $pathFile.'/profile_body.json';
        if (file_exists($pathFileBody)) {
            unlink($pathFileBody);
        }
        $pathFileResult = $pathFile.'/profile.json';

        // api callback
        foreach ($multiArray['profile'] as $val) {
            
            $responseParam[] = [
                'id'                =>  $val['user_id'],
                'name'              =>  $val['firstname'].' '.$val['lastname'],
                'nickname'          =>  $val['nickname'],
                'firstname'         =>  $val['firstname'],
                'middlename'        =>  $val['middlename'],
                'lastname'          =>  $val['lastname'],
                'gender'            =>  $val['gender'],
                'country'           =>  $val['country'],
                'fg_id'             =>  $val['family_group_id'],
                'workshop_number_1' =>  $val['workshop_id_1'],
                'workshop_number_2' =>  $val['workshop_id_2'],
                'img_path'          =>  $val['img_path'],
                'img_name'          =>  $val['img_name'] 
            ];

            $data = [
                'id'                =>  $val['user_id'],
                'name'              =>  $val['firstname'].' '.$val['lastname'],
                'nickname'          =>  $val['nickname'],
                'firstname'         =>  $val['firstname'],
                'middlename'        =>  $val['middlename'],
                'lastname'          =>  $val['lastname'],
                'gender'            =>  $val['gender'],
                'country'           =>  $val['country'],
                'fg_id'             =>  $val['family_group_id'],
                'workshop_number_1' =>  $val['workshop_id_1'],
                'workshop_number_2' =>  $val['workshop_id_2'],
                'img_path'          =>  $val['img_path'],
                'img_name'          =>  $val['img_name'] 
            ];

            if (file_exists($pathFileBody)) {
                file_put_contents($pathFileBody, ','.json_encode($data), FILE_APPEND);
            } else {
                file_put_contents($pathFileBody, json_encode($data));
            }
        }

        // create json file
        if (file_exists($pathFileResult)) {
            unlink($pathFileResult);
        }
        file_put_contents($pathFileResult, file_get_contents($pathFileHeader));
        file_put_contents($pathFileResult, file_get_contents($pathFileBody), FILE_APPEND);
        file_put_contents($pathFileResult, file_get_contents($pathFileFooter), FILE_APPEND);
        // end create

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

    public function updated($array)
    {
        // api callback
        $responseParam = [
            'profile'       => [
                    'firstname'     => $array['firstname'],
                    'lastname'      => $array['lastname'],
                    'middlename'    => $array['middlename'],
                    'nickname'      => $array['nickname'],
                    'mobile_no'     => $array['mobile_no'],
                    'birthdate'     => $array['birthdate'],
                    'gender'        => $array['gender'],
                    'country'       => $array['country'],
                    'updated_at'    => $array['created_at']
            ],
            'event_details'       => [
                    'workshop_id_1'     => $array['workshop_id_1'],
                    'workshop_id_2'     => $array['workshop_id_2'],
                    'family_group_id'   => $array['family_group_id'],
                    'tshirt_size'       => $array['tshirt_size'],
                    'device'            => $array['device'],
                    'city_tour'         => $array['city_tour'],
                    'room_number'       => $array['room_number'],
                    'img_name'          => $array['img_name'],
                    'img_path'          => $array['img_path']
            ]   
        ];

        return $responseParam;
    }
}