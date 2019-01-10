<?php
namespace App\Modules\Contents\Main\Controllers;

use App\Http\Controllers\Controller;
use App\Contracts\ResponseFormatterInterface;

class ContentsController extends Controller 
{
    protected $response;
    protected $responseFormatter;

    public function __construct(ResponseFormatterInterface $responseFormatter)
    {
        $this->responseFormatter = $responseFormatter;
    }

    public function getContent()
    {
        $response = [
            'assets'    => [    
                'speakers'  => [
                    'update_now'        => false,
                    'path_file'         => ENV('ASSETS_URL').'/speakers.json'
                ],
                'workshops' => [
                    'update_now'        => false,
                    'path_file'         => ENV('ASSETS_URL').'/workshops.json'
                ],
                'schedule'  => [
                    'update_now'        => false,
                    'path_file'         => ENV('ASSETS_URL').'/schedule.json'
                ],
                'profile'   => [
                    'update_now'        => false,
                    'path_file'         => ENV('ASSETS_URL').'/profile.json'
                ],
                'family_groups'   => [
                    'update_now'        => false,
                    'path_file'         => ENV('ASSETS_URL').'/family_groups.json'
                ]
            ]
        ];
        
        $this->response = $this->responseFormatter->prepareSuccessResponseBody($response);

        return $this->response;
    }
}