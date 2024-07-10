<?php

namespace App\Http\Controllers\Admin;

use App\Models\PointSystem;
use Illuminate\Http\Request;
use App\Models\WebsiteConfig;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WebsiteConfigRequest;
use App\Http\Requests\Admin\WebsitePointSystemRequest;

class WebsiteConfigController extends Controller
{


    function __construct()
    {
        $this->middleware('permission:website-config-list', ['only' => ['getWebsiteConfig']]);
        $this->middleware('permission:website-config-edit', ['only' => ['websiteConfigUpdate']]);
        $this->middleware('permission:point-system-edit', ['only' => ['pointSystemUpdate']]);
    }

    public function getWebsiteConfig()
    {
        //
        $data = WebsiteConfig::first();
        $pointSystem = PointSystem::first();
        return view('Admin.website-config',compact('data','pointSystem'));

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
        $data->whatsapp = $request->whatsapp;
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
            return response()->json(['status' => 1, 'message' => __('message.Website config update successfully')]);
        }


    }


    public function pointSystemUpdate(WebsitePointSystemRequest $request)
    {
        //
        $data = PointSystem::first();
        $data->per_booking_points = $request->per_booking_points;
        $data->per_active_referral_points = $request->per_active_referral_points;
        $data->how_many_point_equal_sr = $request->how_many_point_equal_sr;
        $data->update();


        if (!empty($data)) {
            return response()->json(['status' => 1, 'message' => __('message.Website point system update successfully')]);
        }


    }


}
