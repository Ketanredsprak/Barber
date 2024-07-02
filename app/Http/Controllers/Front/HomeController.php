<?php

namespace App\Http\Controllers\Front;

use App\Models\Pagies;
use App\Models\Banners;
use App\Models\Services;
use App\Models\ContactUS;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContactSubmitRequest;

class HomeController extends Controller
{
    //
    public function index()
    {
        $banners = Banners::where("status",1)->where("is_delete",0)->get();
        $data = Pagies::with("meta_content", "cms_content")->find(1);
        $testimonials = Testimonial::where("status",1)->where("is_delete",0)->get();
        $services = Services::where('parent_id',0)->where('is_delete', 0)->take(6)->get();
        return view('Frontend.home',compact('banners','data','testimonials','services'));
    }

    public function AboutUs()
    {
        $data = Pagies::with("meta_content", "cms_content")->find(1);
        $data1 = Pagies::with("meta_content", "cms_content")->find(2);
        $testimonials = Testimonial::where("status",1)->where("is_delete",0)->get();
        return view('Frontend.about-us',compact('data','testimonials','data1'));
    }


    public function contactSubmit(Request $request)
    {


        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'subject' => 'required',
            'email' => 'required|email',
            'note' => 'required',
        ], [
            'first_name.required' => __('error.The first name field is required.'),
            'last_name.required' => __('error.The last name field is required.'),
            'subject.required' => __('error.The subject field is required.'),
            'note.required' => __('error.The note field is required.'),
            'email.required' => __('error.The email field is required.'),
            'email.email' => __('error.Please enter a valid email address.'),
        ]);

        $contact = new ContactUS();

        if ($request->hasFile('contact_file')) {
            $source = $_FILES['contact_file']['tmp_name'];
            if ($source) {
                $destinationFolder = public_path('contact_file'); // Specify the destination folder
                $image = $request->file('contact_file');
                $filename = time() . '_contact_file.' . $image->getClientOriginalExtension();
                if (!file_exists($destinationFolder)) {
                    mkdir($destinationFolder, 0777, true);
                }
                $destination = $destinationFolder . '/' . $filename;
                $contact_file = compressImage($source, $destination);
                $contact->contact_file = $filename;
            }
        }


        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->email = $request->email;
        $contact->subject = $request->subject;
        $contact->note = $request->note;
        $contact->save();

        return response()->json(['status' => 1, 'message' => __('message.Thanks For Contact Us')]);


    }


    public function contactUs()
    {
        $data = Pagies::with("meta_content", "cms_content")->find(11);
        return view('Frontend.contact-us',compact('data'));
    }

    public function privacyPolicy()
    {
        $data = Pagies::with("meta_content", "cms_content")->find(3);
        return view('Frontend.privacy-policy',compact('data'));
    }

    public function temrsAndCondition()
    {
        $data = Pagies::with("meta_content", "cms_content")->find(4);
        return view('Frontend.temrs-and-condition',compact('data'));
    }





}
