<?php

namespace App\Modules\User\Auth\Helpers;

use App\Modules\User\Auth\Contracts\AuthResponseFormatterInterface;

class AuthResponseFormatter implements AuthResponseFormatterInterface
{
	public function prepare($objectData)
	{
		$responseFormat[] = [
			'user_account'	=> [
				'user_id'			=> $objectData['user']['user_id'],
				'username'			=> $objectData['user']['email'],
				'token'				=> $objectData['user']['token'],
				'first_time_user'	=> $objectData['user']['first_time_user'] == 0 ? 'No' : 'Yes',
				'login_timestamp'	=> $objectData['user']['login_datetime']
			],
			'profile'		=> [
				'firstname'     	=> $objectData['profile']['firstname'],
				'lastname'      	=> $objectData['profile']['lastname'],
				'middlename'    	=> $objectData['profile']['middlename'],
				'nickname'      	=> $objectData['profile']['nickname'],
				'mobile_no'     	=> $objectData['profile']['mobile_no'],
				'birthdate'     	=> $objectData['profile']['birthdate'],
				'gender'        	=> $objectData['profile']['gender'],
				'country'       	=> $objectData['profile']['country'],
				'is_pwd'        	=> $objectData['profile']['is_pwd'],
				'created_at'    	=> $objectData['profile']['created_at'],
				'updated_at'    	=> $objectData['profile']['updated_at']
			],
			'event_details'	=> $objectData['event']
		];

		return $responseFormat;
	}
}