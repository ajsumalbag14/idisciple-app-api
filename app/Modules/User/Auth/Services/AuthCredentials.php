<?php

namespace App\Modules\User\Auth\Services;

use Hash;

use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Modules\User\Profile\Models\User;
use App\Modules\User\Profile\Models\UserProfile;

use App\Modules\User\Auth\Contracts\AuthCredentialsInterface;

class AuthCredentials implements AuthCredentialsInterface
{
    protected $userObject;

    protected $profileObject;

    protected $response;

    protected $loadedAssets; 

    public function __construct()
    {
        $this->userObject = new User;
        $this->profileObject = new UserProfile;
    }

    public function verify(Request $request)
    {
        // token parameters
        $update_param = [
            'token'             => str_random(100),
            'token_expiry'      => Carbon::now()->addYear(1),
            'login_datetime'    => Carbon::now()
        ];

        $proceed = 0;

        // get user details
        $user = $this->userObject->whereEmail($request->get('email'))->first();
        if ($user) {
            // check if user is first time user
            if ($user->first_time_user == 1) {
                if (Hash::check($request->get('password'), $user->temp_password)) {
                    $proceed = 1;
                } 
            } else {
                // returning user    
                if (Hash::check($request->get('password'), $user->password)) {
                    $proceed = 1;
                }
            }

            // prepare success response
            if ($proceed == 1) {
                $user_id = $user->user_id;
                // create and update api/session token
                $user->update($update_param);
                // retrieve all assets and session values
                $this->setSessionAssets($user_id);

                $this->response = [
                    'status'    => 1,
                    'data'      => $this->sessionAssets
                ];
            } else {
                $this->response = [
                    'status'    => 2,
                    'message'   => 'Invalid password'
                ];
            }

        } else {
            $this->response = [
                'status'    => 2,
                'message'   => 'Invalid email'
            ];
        }

        return $this->response;

    }

    public function setSessionAssets($user_id)
    {
        //load user account
        $user = $this->userObject::find($user_id);

        //load user profile
        $profile = $this->profileObject->whereUser_id($user_id)->first();

        //load conference details
        $tshirt = array("XS", "S", "M", "L", "XL", "2XL", "3XL");

        $device = array("Android", "iOS");

        $tour = array("Yes", "No");

        $details = [
            'workshop_id_1'     => rand(1, 10),
            'workshop_id_2'     => rand(1, 10),
            'family_group_id'   => rand(1, 10),
            'tshirt_size'       => $tshirt[rand(0, 6)],
            'device'            => $device[rand(0, 1)],
            'city_tour'         => $tour[rand(0, 1)],
            'room_number'       => 'Room '.rand(1, 100)

        ];

        $this->sessionAssets = [
            'user'      => $user,
            'profile'   => $profile,
            'event'     => $details
        ];

    }
}