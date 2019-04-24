<?php
/** 
 * @author Arvin Jay Sumalbag <ajsumalbag14@gmail.com>
 * VS Code
 * PHP Version 7.2.1
 * 2019-04-24 00:04
 */
namespace App\Modules\User\Profile\Services;

use Image;

use Illuminate\Support\Facades\Storage;

/**
 * Generate photo upload
 * 
 * @return void
 */
class ProfilePhotoService
{
    public function __construct()
    {
        //
    }

    /**
     * Handle image processing
     * 
     * @return array
     */
    public function handle($base64Img, $fileName)
    {
        $response = [];

        // write file
        $writer = $this->_writeToFile($base64Img, $fileName);

        if ($writer) {

            // save to database

            $response = [
                'status'    => 1,
                'data'      => [
                    'path'      => public_path().'\avatar',
                    'filename'  => $fileName
                ]
            ];
        } else {
            $response = [
                'status'    => 3,
                'message'   => 'Image processing error'
            ];
        }

        return $response;
    }

    /**
     * Writing to dir
     * 
     * @return object
     */
    private function _writeToFile($encoded_string, $fileName)
    {
        // declare image path
        $profileImg= Image::make(base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $encoded_string)))->stream();
        
        $writer = Storage::disk('public')->put('avatar/'.$fileName, $profileImg);

        return $writer;
    }
}