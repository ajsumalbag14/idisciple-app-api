<?php

namespace App\Modules\User\Profile\Contracts;

interface ProfileServiceInterface 
{

    public function add($array);
    public function edit($array, $user_id);
    public function delete($user_id);

}