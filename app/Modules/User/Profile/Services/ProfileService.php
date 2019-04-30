<?php
/** 
 * @author Arvin Jay Sumalbag <ajsumalbag14@gmail.com>
 * VS Code
 * PHP Version 7.2.1
 * 2018-10-11 12:51
 */
namespace App\Modules\User\Profile\Services;

use Carbon\Carbon;

use App\Mail\ResetPassword;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Mail;

use App\Modules\User\Profile\Models\User;

use App\Modules\User\Profile\Models\UserProfile;

use App\Modules\User\Profile\Services\SendMailService;

use App\Modules\User\Profile\Contracts\ProfileServiceInterface;

use Symfony\Component\HttpFoundation\Request as RequestApi; 

class ProfileService implements ProfileServiceInterface
{
    protected $userObject;

    protected $profileObject;

    protected $currentDate;

    protected $sendMail;

    public function __construct(SendMailService $sendMail) 
    {
        $this->sendMail         = $sendMail;
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

                // update assets json
                self::_updateAssetsJson();
                
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
            $user = $this->userObject::whereEmail($email)->first();
            if (!$user) {
                return [
                    'status'    => 2,
                    'message'   => 'User not found'
                ];
            }

            $user->update($array);

            // retrieve updated account
            $user = $this->userObject::whereEmail($email)->first();

            // send email
            $data = [
                'name'      => $user->name,
                'password'  => $user->hint,
                'email'     => $user->email
            ];
    
            Mail::to($user->email)->send(new ResetPassword($user));

            // Mail gun service
            // $this->sendMail->handle($user);

            $response = [
                'status'    => 1,
                'data'      => $user->toArray()
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
                // update assets json
                self::_updateAssetsJson();

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

    public function createUserAccounts() {
        $response = [];

        try {
            // update profile
            $update = $this->profileObject::whereUser_id(0)->get();
            if ($update) {
                // insert new user profile
                foreach ($update as $val) {
                    $name = $val->firstname.' '.$val->lastname;
                    $temp_pwd = substr(md5($name), -6, 6);
                    $user_param = [
                        'name'          => $name,
                        'email'         => $val->email,
                        'password'      => Hash::make($temp_pwd),
                        'temp_password' => Hash::make($temp_pwd),
                        'hint'          => $temp_pwd,
                        'is_active'     => 1,
                        'first_time_user'   => 1,
                        'created_at'    => $this->currentDate,
                        'updated_at'    => $this->currentDate
                    ];

                    $user_id = 999999;
                    // check if there is an existing email recorded
                    $existing = $this->userObject::where('email', $val->email)->first();
                    if (!$existing) {
                        // insert new user account
                        $new_user = $this->userObject::create($user_param);
                        $user_id = $new_user->user_id;
                    }

                    // update user id in profile page
                    $this->profileObject::where('registration_no', $val->registration_no)
                        ->update(['user_id' => $user_id, 'updated_at' => $this->currentDate]);
                }

                // update assets json
                self::_updateAssetsJson();

                $response = [
                    'status'    => 1
                ];
            } else {
                $response = [
                    'status'    => 3,
                    'message'   => 'No user needs to be migrated'
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

    private function _updateAssetsJson() {
        // Create your request to your API
        $request = RequestApi::create('/user/all', 'GET');
        // Dispatch your request instance with the router
        app()->handle($request);

        \Log::info('Trigger assets update');
    }
}