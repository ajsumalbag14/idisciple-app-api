<?php

namespace App\Modules\User\Profile\Controllers;

use Response;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Contracts\ResponseFormatterInterface;

use App\Modules\User\Profile\Contracts\ProfileServiceInterface;
use App\Modules\User\Profile\Contracts\ProfileRequestParserInterface;
use App\Modules\User\Profile\Contracts\ProfileResponseParserInterface;

class UserProfileController extends Controller
{

    protected $response;

    protected $responseFormatter;

    protected $requestParser;

    protected $responseParser;

    protected $service;

    public function __construct(
        ResponseFormatterInterface $responseFormatter,
        ProfileServiceInterface $service,
        ProfileRequestParserInterface $request,
        ProfileResponseParserInterface $response
    )
    {
        $this->responseFormatter    = $responseFormatter;
        $this->service              = $service;
        $this->requestParser        = $request;
        $this->responseParser       = $response;
    }

    public function addUser(Request $request)
    {
        $paramParser = $this->requestParser->create($request);
        if ($paramParser['status'] == 1) {
            $user_account = $this->service->add($paramParser['data']);
            if ($user_account['status'] == 1) {
                $responseFormat = $this->responseParser->created($user_account['data']);
                $this->response = $this->responseFormatter->prepareSuccessResponseBody($responseFormat);
            } else if ($user_account['status'] == 2) { 
                $this->response = $this->responseFormatter->prepareUnprocessedResponseBody($user_account['message']);
            } else {
                // error saving resource
                \Log::debug($user_account['message']); 
                $this->response = $this->responseFormatter->prepareErrorResponseBody($user_account['message']);
            }
        } else {
            $this->response = $this->responseFormatter->prepareUnprocessedResponseBody($paramParser['message']);
        }
        
        return Response::json($this->response, $this->response['code']);

    }

    public function editUser(Request $request, $user_id)
    {
        //
    }

    public function deleteUser($user_id)
    {
        //
    }

}