<?php

use App\Models\Module;
use App\Models\Countries;
use Spatie\Permission\Models\Permission;

if (!function_exists('static_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function static_asset($path, $secure = null)
    {
        return app('url')->asset('public/' . $path, $secure);
    }
}


if (!function_exists('getcountries')) {
    function getcountries()
    {
          $countrys = Countries::where("is_delete",0)->where('status',1)->get();
          return $countrys;
    }
}


if (!function_exists('getmodules')) {
    function getmodules()
    {
          $module = Module::get();
          return $module;
    }
}



if (!function_exists('getPermission')) {
    function getPermission()
    {
        $permission_group = Permission::get()->groupBy('module_name');
          return $permission_group;
    }
}


//get compressImage
if (!function_exists('compressImage')) {
    function compressImage($source, $destination) {
        // Get image info
        //for $quality change 1 -100
        $quality = 60;
        $imgInfo = getimagesize($source);
        $mime = $imgInfo['mime'];

         // Check image size
         $fileSize = filesize($source); // in bytes
         $quality = ($fileSize > 1024 * 1024) ? $quality : 100; // Check if size is greater than 1 MB

        // Create a new image from file
        switch($mime){
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($source);
                break;
            default:
                $image = imagecreatefromjpeg($source);
        }

        // Save image
        imagejpeg($image, $destination, $quality);

        // Return compressed image
        return $destination;
    }

}




