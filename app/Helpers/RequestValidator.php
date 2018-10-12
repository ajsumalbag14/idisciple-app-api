<?php
/** 
 * @author Arvin Jay Sumalbag <ajsumalbag14@gmail.com>
 * VS Code
 * PHP Version 7.2.1
 * 2018-10-11 12:38
 */
namespace App\Helpers;

use Validator;

use Illuminate\Http\Request;
use App\Contracts\RequestValidatorInterface;
/**
 * Request Validator Class
 * 
 */
class RequestValidator implements RequestValidatorInterface
{   
    /**
     * Validate Request Funtion
     * 
     * @return Object
     */
    public function validateRequest(Request $request, $filter = [])
    {
        return Validator::make($request->all(), $filter);
    }
}