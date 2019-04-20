<?php
/** 
 * @author Arvin Jay Sumalbag <ajsumalbag14@gmail.com>
 * VS Code
 * PHP Version 7.2.1
 * 2018-10-11 12:51
 */
namespace App\Modules\User\Profile\Services;

use Carbon\Carbon;

use App\Modules\User\Profile\Models\User;

use App\Modules\User\Profile\Models\UserProfile;

use App\Modules\User\Profile\Contracts\ProfileServiceInterface;

class ProfileService implements ProfileServiceInterface
{
    protected $userObject;

    protected $profileObject;

    protected $currentDate;

    public function __construct() 
    {
        $this->currentDate      = Carbon::now();
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

    public function editWithUserId($array, $user_id)
    {
        $response = [];

        try {
            // update user
            $this->userObject::whereUser_id($user_id)->update($array);
            
            // retrieve updated account
            $user = $this->userObject::whereUser_id($user_id)->first();

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

    public function editWithEmail($array, $email)
    {
        $response = [];

        try {
            // update user
            $this->userObject::whereEmail($email)->update($array);
            
            // retrieve updated account
            $user = $this->userObject::whereEmail($email)->first();

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

    public function getAllUsers()
    {
        $response = [];

        try {
            // get all users
            $profile    = $this->profileObject::all();
            
            $response = [
                'status'    => 1,
                'data'      => [
                    'profile'   => $profile
                ]
            ];

        } catch (\Illuminate\Database\QueryException $ex) {
            $response = [
                'status'    => 3,
                'message'   => $ex->getMessage()
            ];
        }

        return $response;
    }

    public function editUserViaUserId($array, $user_id)
    {
        $response = [];

        try {
            // update profile
            $update = $this->profileObject::whereUser_id($user_id)->update($array['profile']);

            if ($update) {
                // retrieve updated account
                $profile = $this->profileObject::whereUser_id($user_id)->first();

                $response = [
                    'status'    => 1,
                    'data'      => $profile
                ];
            } else {
                $response = [
                    'status'    => 3,
                    'message'   => 'User not found'
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

    public function logout($user_id)
    {
        $response = [];

        try {
            $params = [
                'token'             => null,
                'token_expiry'      => null,
                'updated_at'        => $this->currentDate,
                'logout_datetime'   => $this->currentDate
            ];

            // update profile
            $update = $this->userObject::whereUser_id($user_id)->update($params);

            if ($update) {
                $response = [
                    'status'    => 1
                ];
            } else {
                $response = [
                    'status'    => 3,
                    'message'   => 'User not found'
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
}