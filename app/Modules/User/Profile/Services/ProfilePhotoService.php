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

use Symfony\Component\HttpFoundation\Request as RequestApi; 

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

    protected $randString;

    /**
     * Init services and database connection
     * 
     * @return void
     */
    public function __construct()
    {
        $this->currentDate      = Carbon::now();
        $this->repoUserProfile  = new UserProfile;
        $this->randString       = str_random(6);
    }

    /**
     * Handle image processing
     * 
     * @return array
     */
    public function handle(Request $request)
    {
        $response = [];

        $path = ENV('AVATAR_DOWNLOAD_PATH');
        $filename = $request->get('user_id').'_'.$this->randString.'_'.$request->file->getClientOriginalName();

        // get user record
        $userProfile = $this->repoUserProfile::where('user_id', $request->get('user_id'))->first();

        if ($userProfile) {
            // save image to directory
            $request->file->storeAs('public/avatar', $filename);
            

            // update to database
            if ($userProfile) {        
                $userProfile->update(
                    [
                        'updated_at'    => $this->currentDate,
                        'img_name'      => $filename,
                        'img_path'      => $path.$filename
                    ]
                );
            }

            // update assets json
            self::_updateAssetsJson();

            $newUserProfile = $this->repoUserProfile::where('user_id', $request->get('user_id'))->first();

            $response = [
                'status'    => 1,
                'data'      => [
                    'id'                => $newUserProfile->user_id,
                    'name'              => $newUserProfile->firstname.' '.$newUserProfile->lastname,
                    'nickname'          => $newUserProfile->nickname,
                    'firstname'         => $newUserProfile->firstname,
                    'middlename'        => $newUserProfile->middlename,
                    'lastname'          => $newUserProfile->lastname,
                    'gender'            => $newUserProfile->gender,
                    'country'           => $newUserProfile->country,
                    'fg_id'             => $newUserProfile->family_group_id,
                    'workshop_number_1' => $newUserProfile->workshop_id_1,
                    'workshop_number_2' => $newUserProfile->workshop_id_2,
                    'img_path'          => $newUserProfile->img_path,
                    'img_name'          => $newUserProfile->img_name
                ]
            ];
        } else {
            $response = [
                'status'    => 2,
                'message'   => 'User not found'
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

    private function _updateAssetsJson() {
        // Create your request to your API
        $request = RequestApi::create('/user/all', 'GET');
        // Dispatch your request instance with the router
        app()->handle($request);

        \Log::info('Trigger assets update');
    }
}