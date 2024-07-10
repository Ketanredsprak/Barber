<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Banners;
use App\Models\ContactUS;
use App\Models\MyFavorite;
use App\Models\Pagies;
use App\Models\Services;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{
    //
    public function index()
    {
        $banners = Banners::where("status", 1)->where("is_delete", 0)->get();
        $data = Pagies::with("meta_content", "cms_content")->find(1);
        $testimonials = Testimonial::where("status", 1)->where("is_delete", 0)->get();
        $services = Services::where('parent_id', 0)->where('is_delete', 0)->take(6)->get();
        return view('Frontend.home', compact('banners', 'data', 'testimonials', 'services'));
    }

    public function AboutUs()
    {
        $data = Pagies::with("meta_content", "cms_content")->find(1);
        $data1 = Pagies::with("meta_content", "cms_content")->find(2);
        $testimonials = Testimonial::where("status", 1)->where("is_delete", 0)->get();
        return view('Frontend.about-us', compact('data', 'testimonials', 'data1'));
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
        return view('Frontend.contact-us', compact('data'));
    }

    public function privacyPolicy()
    {
        $data = Pagies::with("meta_content", "cms_content")->find(3);
        return view('Frontend.privacy-policy', compact('data'));
    }

    public function temrsAndCondition()
    {
        $data = Pagies::with("meta_content", "cms_content")->find(4);
        return view('Frontend.temrs-and-condition', compact('data'));
    }

    public function barberList()
    {
        $data = Pagies::with("meta_content", "cms_content")->find(13);
        return view('Frontend.Barber.barber-list', compact('data'));
    }

    public function barberListFilter(Request $request)
    {

        $barber = User::with('barber_service')->where('user_type', 3)->where('is_approved', "2")->where('is_delete', 0);

        if ($request->gender) {
            $barber->where('gender', $request->gender);
        }

        if ($request->barber_name) {
            $names = explode(' ', $request->barber_name);
            $firstName = $names[0] ?? '';
            $lastName = $names[1] ?? '';

            $barber->where(function ($query) use ($firstName, $lastName) {
                $query->where('first_name', 'like', '%' . $firstName . '%')
                    ->orWhere('last_name', 'like', '%' . $lastName . '%');
            });
        }

        if ($request->salon_name) {
            $barber->where('salon_name', 'like', '%' . $request->salon_name . '%');
        }

        if ($request->state_name) {
            $barber->where('state_name', 'like', '%' . $request->state_name . '%');
        }

        if ($request->city_name) {
            $barber->where('city_name', 'like', '%' . $request->city_name . '%');
        }

        if ($request->service_id) {
            $barber->whereHas('barber_service', function ($query) use ($request) {
                $query->where('sub_service_id', $request->service_id);
            });
        }

        $barber_list = $barber->paginate(4);

        foreach ($barber_list as $barbers) {
            $barbers['encrypt_id'] = Crypt::encryptString($barbers->id);
        }

        return response()->json(view('Frontend.Barber.barber-list-response', compact('barber_list'))->render());

    }

    public function barberDetail($id)
    {
        $id = Crypt::decryptString($id);
        $data = User::with('barber_service')->find($id);

        if (!empty((Auth::user()))) {
            $check_favorite_list = MyFavorite::where('barber_id', $data->id)->where('user_id', Auth::user()->id)->first();
        } else {
            $check_favorite_list = "";
        }

        $page_data = Pagies::with("meta_content", "cms_content")->find(14);
        return view('Frontend.Barber.barber-detail', compact('data', 'page_data', 'check_favorite_list'));

    }

}
