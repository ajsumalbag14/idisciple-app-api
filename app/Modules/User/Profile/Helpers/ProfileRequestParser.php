<?php
/** 
 * @author Arvin Jay Sumalbag <ajsumalbag14@gmail.com>
 * VS Code
 * PHP Version 7.2.1
 * 2018-10-11 12:38
 */
namespace App\Modules\User\Profile\Helpers;

use Hash;
use Validator;
use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Contracts\RequestValidatorInterface;
use App\Modules\User\Profile\Contracts\ProfileRequestParserInterface;

class ProfileRequestParser implements ProfileRequestParserInterface
{

    protected $temp_password;

    protected $current_date;

    protected $validator;

    protected $isValidRequest = true;

    public $resultArray = [];

    public function __construct(RequestValidatorInterface $validator)
    {
        $this->validator        = $validator;
        $this->temp_password    = str_random(20); // 20 alpha numeric characters
        $this->current_date     = Carbon::now();
    }

    protected function setResultArray($param = [])
    {
        $result = [];
        // check validator result
        if ($this->isValidRequest) {
            $result = [
                'status'    => 1,
                'data'      => $param
            ];
        } else {
            $result = [
                'status'    => 2,
                'message'   => 'Invalid input'
            ];
        }   

        $this->resultArray = $result;
    }

    public function getParsedParameters()
    {
        return $this->resultArray;
    }

    public function setAddUserParam(Request $request)
    {
        $param = [];
        $filter = [
            'firstname'         => 'required|string:max=50',
            'lastname'          => 'required|string:max=50',
            'nickname'          => 'string:max=50',
            'email'             => 'required|email',
            'mobile_no'         => 'string:max=13'
        ]; 
        
        if ($this->validator->validateRequest($request, $filter)->fails()) {
            $this->isValidRequest = false;
        } else {
            // exact resource array parameters to be sent to database
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
                'created_at'    => $this->current_date
            ];

            $user_param = [
                'name'          => $request->get('firstname').' '.$request->get('lastname'),
                'email'         => $request->get('email'),
                'password'      => $this->temp_password,
                'temp_password' => Hash::make($this->temp_password),
                'is_active'     => 1,
                'created_at'    => $this->current_date
            ];

            $param = [
                'user'      => $user_param,
                'profile'   => $profile_param                   
            ];
        }

        $this->setResultArray($param);
    }

    public function setUpdatePasswordParam(Request $request)
    {
        $param = [];
        $filter = [
            'new_password'      => 'required|string:max=100'
        ];

        if ($this->validator->validateRequest($request, $filter)->fails()) {
            $this->isValidRequest = false;
        } else {
            // prepare resource parameters to be sent to database
            $param = [
                'password'          => Hash::make($request->get('new_password')),
                'first_time_user'   => 1,
                'temp_password'     => null,
                'updated_at'        => $this->current_date
            ];
        }

        $this->setResultArray($param);
    }

    public function setValidateEmailParam(Request $request)
    {
        $param = [];
        $filter = [ 
            'email'     => 'required|email'
        ];

        if ($this->validator->validateRequest($request, $filter)->fails()) {
            $this->isValidRequest = false;
        } else {
            // prepare resource parameters to be sent to database
            $param = [
                'password'          => $this->temp_password,
                'first_time_user'   => 0,
                'temp_password'     => Hash::make($this->temp_password),
                'updated_at'        => $this->current_date
            ];
        }

        $this->setResultArray($param);
    }

    
    public function setUpdateProfileParam(Request $request)
    {
        //
    }
}