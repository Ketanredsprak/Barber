<?php

namespace App\Http\Controllers\Front;

use App\Models\Pagies;
use App\Models\Banners;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    //
    public function home()
    {
        $banners = Banners::where("status",1)->where("is_delete",0)->get();
        $data = Pagies::with("meta_content", "cms_content")->find(1);
        $testimonials = Testimonial::where("status",1)->where("is_delete",0)->get();
        return view('Frontend.home',compact('banners','data','testimonials'));
    }
}
