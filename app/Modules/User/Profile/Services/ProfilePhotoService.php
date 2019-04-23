<?php
/** 
 * @author Arvin Jay Sumalbag <ajsumalbag14@gmail.com>
 * VS Code
 * PHP Version 7.2.1
 * 2019-04-24 00:04
 */

 namespace App\Modules\User\Profile\Services;

 class ProfilePhotoService
 {
     public function __construct()
     {
         //
     }

     public function handle($base64Img, $fileName)
     {
         // decode base64
         $decoded_string = base64_decode($base64Img);

         // write file
         $writer = $this->_writeToFile($decoded_string, $fileName);
     }

     private function _writeToFile($decoded_string, $fileName)
     {
         // declare image path

         // write image

         // return
     }
 }