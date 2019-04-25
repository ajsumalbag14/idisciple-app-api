<?php
/** 
 * @author Arvin Jay Sumalbag <ajsumalbag14@gmail.com>
 * VS Code
 * PHP Version 7.2.1
 * 2019-04-24 00:04
 */
namespace App\Modules\User\Profile\Services;

use Image;

use Carbon\Carbon;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use App\Modules\User\Profile\Models\UserProfile;

/**
 * Generate photo upload
 * 
 * @return void
 */
class ProfilePhotoService
{
    protected $currentDate;

    protected $repoUserProfile;

    /**
     * Init services and database connection
     * 
     * @return void
     */
    public function __construct()
    {
        $this->currentDate      = Carbon::now();
        $this->repoUserProfile  = new UserProfile;
    }

    /**
     * Handle image processing
     * 
     * @return array
     */
    public function handle(Request $request)
    {
        $response = [];

        // write file
        $writer = $this->_writeToFile($request->get('base64_image'), $request->get('filename'));

        if ($writer) {
            $path = ENV('AVATAR_DOWNLOAD_PATH');
            $filename = $request->get('filename');

            // update to database
            $userProfile = $this->repoUserProfile::where('user_id', $request->get('user_id'))->first();
            if ($userProfile) {
                $userProfile->update(
                    [
                        'updated_at'    => $this->currentDate,
                        'img_name'      => $filename,
                        'img_path'      => $path.$filename
                    ]
                );
            }

            $newUserProfile = $this->repoUserProfile::where('user_id', $request->get('user_id'))->first();

            $response = [
                'status'    => 1,
                'data'      => [
                    'user_profile_id'   => $newUserProfile->user_profile_id,
                    'user_id'           => $newUserProfile->user_id,
                    'name'              => $newUserProfile->firstname.' '.$newUserProfile->lastname,
                    'profile_picture'   => $newUserProfile->img_path,
                    'updated_at'        => $newUserProfile->updated_at
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