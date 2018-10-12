<?php
/** 
 * @author Arvin Jay Sumalbag <ajsumalbag14@gmail.com>
 * VS Code
 * PHP Version 7.2.1
 * 2018-10-11 12:49
 */
namespace App\Modules\User\Profile\Contracts;

interface ProfileServiceInterface 
{
    public function add($array);
    public function editWithUserId($array, $user_id);
    public function editWithEmail($array, $email);
    public function delete($user_id);
}