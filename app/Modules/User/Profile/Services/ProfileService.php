<?php

namespace App\Modules\User\Profile\Services;

use App\Modules\User\Profile\Models\User;
use App\Modules\User\Profile\Models\UserProfile;

use App\Modules\User\Profile\Contracts\ProfileServiceInterface;

class ProfileService implements ProfileServiceInterface
{
    protected $userObject;

    protected $profileObject;

    public function __construct() 
    {
        $this->userObject       = new User;
        $this->profileObject    = new UserProfile;
    }

    public function add($array)
    {
        $response = [];

        try {
            // check if email already exists
            if ($this->userObject::whereEmail($array['user']['email'])->first()) {

                $response = [
                    'status'    => 2,
                    'message'   => 'Email address already exists'
                ];
                
            } else {
                // create user
                $user   = $this->userObject::create($array['user']);

                // assign user id
                $profile_param = $array['profile'];
                $profile_param['user_id'] = $user->user_id;
                
                // create profile
                $profile = $this->profileObject::create($profile_param);
                
                $response = [
                    'status'    => 1,
                    'data'      => [
                        'user'      => $user,
                        'profile'   => $profile
                    ]
                ];
            }

        } catch (\Illuminate\Database\QueryException $ex) {
            $response = [
                'status'    => 3,
                'message'   => $ex->getMessage()
            ];
        }

        return $response;
    }

    public function editPassword($array, $id)
    {
        $response = [];

        try {
            // update user
            $this->userObject::whereUser_id($id)->update($array);
            
            // retrieve updated account
            $user = $this->userObject::whereUser_id($id)->first();

            $response = [
                'status'    => 1,
                'data'      => $user
            ];

        } catch (\Illuminate\Database\QueryException $ex) {
            $response = [
                'status'    => 3,
                'message'   => $ex->getMessage()
            ];
        }

        return $response;
    }

    public function edit($array, $user_id)
    {
        //
    }

    public function delete($user_id)
    {
        //
    }
}