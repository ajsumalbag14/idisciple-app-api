<?php
/** 
 * @author Arvin Jay Sumalbag <ajsumalbag14@gmail.com>
 * VS Code
 * PHP Version 7.2.1
 * 2018-10-11 12:38
 */
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
        $this->requestParser->setAddUserParam($request);
        $parsedParam = $this->requestParser->getParsedParameters();
        
        if ($parsedParam['status'] == 1) {
            $user_account = $this->service->add($parsedParam['data']);
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
            $this->response = $this->responseFormatter->prepareUnprocessedResponseBody($parsedParam['message']);
        }
        
        return Response::json($this->response, $this->response['code']);

    }

    public function changePassword(Request $request, $user_id)
    {
        $this->requestParser->setUpdatePasswordParam($request);
        $parsedParam = $this->requestParser->getParsedParameters();
        if ($parsedParam['status'] == 1) {
            $user_account = $this->service->editWithUserId($parsedParam['data'], $user_id);
            if ($user_account['status'] == 1) {
                $responseFormat = $this->responseParser->updatedPassword($user_account['data']);
                $this->response = $this->responseFormatter->prepareSuccessResponseBody($responseFormat);
            } else {
                // error saving resource
                \Log::debug($user_account['message']); 
                $this->response = $this->responseFormatter->prepareErrorResponseBody($user_account['message']);
            }
        } else {
            $this->response = $this->responseFormatter->prepareUnprocessedResponseBody($parsedParam['message']);
        }
        
        return Response::json($this->response, $this->response['code']);
    }

    public function resetPasswordAndSendEmail(Request $request)
    {
        $this->requestParser->setValidateEmailParam($request);
        $parsedParam = $this->requestParser->getParsedParameters();
        
        if ($parsedParam['status'] == 1) {
            $user_account = $this->service->editWithEmail($parsedParam['data'], $request->get('email'));
            if ($user_account['status'] == 1) {
                $this->response = $this->responseFormatter->prepareSuccessResponseBody($user_account['data']);
            } else {
                // error saving resource
                \Log::debug($user_account['message']); 
                $this->response = $this->responseFormatter->prepareErrorResponseBody($user_account['message']);
            }
        } else {
            $this->response = $this->responseFormatter->prepareUnprocessedResponseBody($parsedParam['message']);
        }
        
        return Response::json($this->response, $this->response['code']);
    }

    public function fetchAll()
    {
        $parsedParam = $this->service->getAllUsers();
        if ($parsedParam['status'] == 1) {
            $responseFormat = $this->responseParser->allUsers($parsedParam['data']);
            $this->response = $this->responseFormatter->prepareSuccessResponseBody($responseFormat);
        } else {
            $this->response = $this->responseFormatter->prepareUnprocessedResponseBody($parsedParam['message']);
        }

        return Response::json($this->response, $this->response['code']);
    }

    public function editUser(Request $request, $user_id)
    {
        $this->requestParser->setUpdateProfileParam($request);
        $parsedParam = $this->requestParser->getParsedParameters();
        if ($parsedParam['status'] == 1) {
            $user_profile = $this->service->editUserViaUserId($parsedParam['data'], $user_id);
            if ($user_profile['status'] == 1) {
                $responseFormat = $this->responseParser->updated($user_profile['data']);
                $this->response = $this->responseFormatter->prepareSuccessResponseBody($responseFormat);
            } else {
                // error saving resource
                $this->response = $this->responseFormatter->prepareErrorResponseBody($user_profile['message']);
            }
        } else {
            $this->response = $this->responseFormatter->prepareUnprocessedResponseBody($parsedParam['message']);
        }
        
        return Response::json($this->response, $this->response['code']);
    }

    public function logout(Request $request)
    {
        $user_id = $request->get('user_id');
        $service = $this->service->logout($user_id);
        if ($service['status'] == 1) {
            $this->response = [
                'code'      => 200,
                'status'    => 'Success',
                'message'   => 'User has successfully logout.'
            ];
        } else {
            $this->response = $this->responseFormatter->prepareUnprocessedResponseBody($service['message']);
        }

        return Response::json($this->response, $this->response['code']);
    }

    public function createUserAccount()
    {
        $parsedParam = $this->service->createUserAccounts();
        if ($parsedParam['status'] == 1) {
            $this->response = [
                'code'      => 200,
                'status'    => 'Success',
                'message'   => 'Migration successful'
            ];
        } else {
            $this->response = $this->responseFormatter->prepareUnprocessedResponseBody($parsedParam['message']);
        }

        return Response::json($this->response, $this->response['code']);
    }

}