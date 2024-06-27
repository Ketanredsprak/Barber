<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\WebsiteConfig;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WebsiteConfigRequest;

class WebsiteConfigController extends Controller
{

    public function getWebsiteConfig()
    {
        //
        $data = WebsiteConfig::first();
        return view('Admin.website-config',compact('data'));

    }



    public function websiteConfigUpdate(WebsiteConfigRequest $request)
    {
        //
        $data = WebsiteConfig::first();
        $data->location_en = $request->location_en;
        $data->location_ar = $request->location_ar;
        $data->location_ur = $request->location_ur;
        $data->location_tr = $request->location_tr;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->facebook_link = $request->facebook_link;
        $data->twitter_link = $request->twitter_link;
        $data->linkedin_link = $request->linkedin_link;
        $data->youtube_link = $request->youtube_link;

         // for Profile Image
         if ($request->hasFile('header_logo')) {
            $image = $request->file('header_logo');
            $header_logo_name = time() . '_header_logo.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/website-config');
            $image->move($destinationPath, $header_logo_name);
            $data->header_logo = $header_logo_name;
        }


         // for Profile Image
         if ($request->hasFile('footer_logo')) {
            $image = $request->file('footer_logo');
            $footer_logo_name = time() . '_footer_logo.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/website-config');
            $image->move($destinationPath, $footer_logo_name);
            $data->footer_logo = $footer_logo_name;
        }

        $data->update();


        if (!empty($data)) {
            return redirect()->route('get-website-config');
        }


    }


}
