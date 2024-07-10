<?php

use App\Models\User;
use App\Models\Module;
use App\Models\Services;
use App\Models\Countries;
use App\Models\Subscription;
use App\Models\WebsiteConfig;
use Illuminate\Support\Facades\Auth;
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



//get raferal code
if (!function_exists('generate_rederal_code')) {
    function generate_rederal_code() {
            $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                return $referral_code =  substr(str_shuffle($str_result), 0, 10);
    }
}


if (!function_exists('getbarbers')) {
    function getbarbers()
    {
        $barbers = User::where('user_type',3)->where('is_approved',"2")->get();
        return $barbers;
    }
}


if (!function_exists('getServices')) {
    function getServices()
    {
        $services = Services::where('parent_id',0)->where('status',1)->get();
        return $services;
    }
}


if (!function_exists('getWebsiteConfig')) {
    function getWebsiteConfig()
    {
        $data = WebsiteConfig::first();
        return $data;
    }
}


if (!function_exists('getauthdata')) {
    function getauthdata()
    {
        $profile_data = Auth::user();
        return $profile_data;
    }
}




if (!function_exists('country_code')) {
    function country_code()
    {
         return ['1','91','93','355','213'];
    }
}


if (!function_exists('getSubscription')) {
    function getSubscription($subscription_type)
    {
        // dd($subscription_type);
        $data = Subscription::where('subscription_type',$subscription_type)->get();
        return $data;
    }
}


if (!function_exists('getSubServices')) {
    function getSubServices()
    {
        $services = Services::where('parent_id', '!=', 0)->where('status',1)->get();
        return $services;
    }
}










