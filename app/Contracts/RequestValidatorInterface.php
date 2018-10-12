<?php

namespace App\Contracts;

use Illuminate\Http\Request;
/**
 * Request Validator
 * Class that validates API Request through pre-defined filters
 * Accepts (@request object, @array filter)
 * 
 * @author Arvin Jay Sumalbag <ajsumalbag14@gmail.com>
 * VS Code
 */
interface RequestValidatorInterface
{
    /**
     * Validate Request Funtion
     * 
     * @return Object
     */
    public function validateRequest(Request $request, $filter = []);
}