<?php

namespace App\Modules\User\Auth\Controllers;

use Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Contracts\ResponseFormatterInterface;

use App\Modules\User\Auth\Contracts\AuthCredentialsInterface;
use App\Modules\User\Auth\Contracts\AuthResponseFormatterInterface;

class AuthController extends Controller 
{
    protected $response;

    protected $responseFormatter;

    protected $authCredentials;

    protected $authResponseFormatter;

    public function __construct(
        ResponseFormatterInterface $responseFormatter,
        AuthResponseFormatterInterface $authResponseFormat,
        AuthCredentialsInterface $authCred
    ) 
    {
        $this->responseFormatter        = $responseFormatter;
        $this->authResponseFormatter    = $authResponseFormat;
        $this->authCredentials          = $authCred;
    }

    /**
     * Verify user login credential.
     *
     * @param  Request  $request
     * @return Response
     */
    public function handle(Request $request)
    {
        // verify login credentials
        $authResult = $this->authCredentials->verify($request);

        // process response
        if ($authResult['status'] == 1) {
            // if login is successful
            $responseFormat = $this->authResponseFormatter->prepare($authResult['data']);
            $this->response = $this->responseFormatter->prepareSuccessResponseBody($responseFormat);
        } else if ($authResult['status'] == 2) {
            // if login credentials is invalid
            $this->response = $this->responseFormatter->prepareUnprocessedResponseBody($authResult['message']);
        } else {
            // if login is unsuccessful
            $this->response = $this->responseFormatter->prepareErrorResponseBody('Something went wrong');
        }

        return Response::json($this->response, $this->response['code']);
    }
}