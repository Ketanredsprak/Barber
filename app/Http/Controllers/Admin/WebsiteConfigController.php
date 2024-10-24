<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AppConfigRequest;
use App\Http\Requests\Admin\WebsiteConfigRequest;
use App\Http\Requests\Admin\WebsitePointSystemRequest;
use App\Models\PointSystem;
use App\Models\WebsiteConfig;

class WebsiteConfigController extends Controller
{

    public function __construct()
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
        return view('Admin.website-config', compact('data', 'pointSystem'));

    }

    public function websiteConfigUpdate(WebsiteConfigRequest $request)
    {
        //
        $data = WebsiteConfig::first();
        $data->location_en = $request->location_en;
        $data->location_ar = $request->location_ar;
        $data->location_ur = $request->location_ur;
        $data->location_tr = $request->location_tr;
        $data->website_link = $request->website_link;
        $data->phone = $request->phone;
        $data->whatsapp = $request->whatsapp;
        $data->email = $request->email;
        $data->tiktok_link = $request->tiktok_link;
        $data->twitter_link = $request->twitter_link;
        $data->linkedin_link = $request->linkedin_link;
        $data->youtube_link = $request->youtube_link;
        $data->play_store_link = $request->play_store_link;
        $data->app_store_link = $request->app_store_link;

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
        $data = WebsiteConfig::first();
        $data->per_booking_points = $request->per_booking_points;
        $data->per_active_referral_points = $request->per_active_referral_points;
        $data->how_many_point_equal_sr = $request->how_many_point_equal_sr;
        $data->update();

        if (!empty($data)) {
            return response()->json(['status' => 1, 'message' => __('message.Website point system update successfully')]);
        }

    }

    public function appConfigUpdate(AppConfigRequest $request)
    {

        //
        $data = WebsiteConfig::first();


        // for Profile Image
        if ($request->hasFile('customer_app_login_image')) {
            $image = $request->file('customer_app_login_image');
            $customer_app_login_image_name = time() . '_customer_app_login_image.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/website-config');
            $image->move($destinationPath, $customer_app_login_image_name);
            $data->customer_app_login_image = $customer_app_login_image_name;
        }

         // for Profile Image
         if ($request->hasFile('barber_app_login_image')) {
            $image = $request->file('barber_app_login_image');
            $barber_app_login_image_name = time() . '_barber_app_login_image.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/website-config');
            $image->move($destinationPath, $barber_app_login_image_name);
            $data->barber_app_login_image = $barber_app_login_image_name;
        }


        $data->customer_app_title_en = $request->customer_app_title_en;
        $data->customer_app_title_ar = $request->customer_app_title_ar;
        $data->customer_app_title_ur = $request->customer_app_title_ur;
        $data->customer_app_title_tr = $request->customer_app_title_tr;
        $data->customer_app_content_en = $request->customer_app_content_en;
        $data->customer_app_content_ar = $request->customer_app_content_ar;
        $data->customer_app_content_ur = $request->customer_app_content_ur;
        $data->customer_app_content_tr = $request->customer_app_content_tr;
        $data->barber_app_title_en = $request->barber_app_title_en;
        $data->barber_app_title_ar = $request->barber_app_title_ar;
        $data->barber_app_title_ur = $request->barber_app_title_ur;
        $data->barber_app_title_tr = $request->barber_app_title_tr;
        $data->barber_app_content_en = $request->barber_app_content_en;
        $data->barber_app_content_ar = $request->barber_app_content_ar;
        $data->barber_app_content_ur = $request->barber_app_content_ur;
        $data->barber_app_content_tr = $request->barber_app_content_tr;
        $data->update();

        if (!empty($data)) {
            return response()->json(['status' => 1, 'message' => __('message.App Config update successfully')]);
        }

    }

}
