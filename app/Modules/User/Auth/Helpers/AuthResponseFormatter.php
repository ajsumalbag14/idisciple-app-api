<?php

namespace App\Modules\User\Auth\Helpers;

use App\Modules\User\Auth\Contracts\AuthResponseFormatterInterface;

class AuthResponseFormatter implements AuthResponseFormatterInterface
{
	public function prepare($objectData)
	{
		$responseFormat = [
			'user_id'			=> $objectData->user_id,
			'name'				=> $objectData->name,
			'email'				=> $objectData->email,
			'token'				=> $objectData->token,
			'first_time_user'	=> $objectData->first_time_user,
			'created_at'		=> $objectData->created_at
		];

		return $responseFormat;
	}
}