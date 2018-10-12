<?php
/** 
 * @author Arvin Jay Sumalbag <ajsumalbag14@gmail.com>
 * VS Code
 * PHP Version 7.2.1
 * 2018-10-11 12:38
 */
namespace App\Modules\User\Profile\Contracts;

use Illuminate\Http\Request;

interface ProfileRequestParserInterface
{
    public function setAddUserParam(Request $request);
    public function setUpdatePasswordParam(Request $request);
    public function setValidateEmailParam(Request $request);
    public function setUpdateProfileParam(Request $request);
}