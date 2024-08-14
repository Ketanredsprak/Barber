<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use App\Models\Pagies;
use App\Models\Banners;
use App\Models\Services;
use App\Models\Subjects;
use App\Models\ContactUS;
use App\Models\MyFavorite;
use App\Models\Testimonial;
use App\Models\BarberRating;
use Illuminate\Http\Request;
use App\Models\BarberServices;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{
    //
    public function index()
    {

        $response = checkUserType();
        if ($response instanceof RedirectResponse) {
            return $response;
        }


        // get top 3 barber based on rating
        $topBarbers = User::with('barber_service','barber_schedule')->where([
                ['user_type', 3],
                ['is_approved', "2"],
                ['is_delete', 0]
            ])
            ->withAvg('barberRatings', 'rating')
            ->orderByDesc('barber_ratings_avg_rating')
            ->take(3)
            ->get()
            ->each(function ($barber) {
                $barber['encrypt_id'] = Crypt::encryptString($barber->id);
            });


        $banners = Banners::with('barber_info','barber_info.barber_service','barber_info.barber_schedule')->where("status", 1)->where("is_delete", 0)->get()->each(function ($banner) {
            $banner['encrypt_id'] = Crypt::encryptString($banner->barber_id);
        });

        $data = Pagies::with("meta_content", "cms_content")->find(1);
        $testimonials = Testimonial::where("status", 1)->where("is_delete", 0)->get();
        $services = Services::where('parent_id', 0)->where('is_delete', 0)->take(6)->get();
        return view('Frontend.home', compact('banners', 'data', 'testimonials', 'services','topBarbers'));
    }

    public function AboutUs()
    {
        $subjects = Subjects::where('status', 1)->where('is_delete', 0)->get();
        $data = Pagies::with("meta_content", "cms_content")->find(1);
        $data1 = Pagies::with("meta_content", "cms_content")->find(2);
        $testimonials = Testimonial::where("status", 1)->where("is_delete", 0)->get();
        return view('Frontend.about-us', compact('data', 'testimonials', 'data1', 'subjects'));
    }

    public function services()
    {
        $data = Pagies::with("meta_content", "cms_content")->find(21);
        $services = Services::where('parent_id', '!=', 0)
        ->where('is_delete', 0)
        ->with('parent')
        ->paginate(9);

        return view('Frontend.services-list', compact('data','services'));
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
        $subjects = Subjects::where('status', 1)->where('is_delete', 0)->get();
        $data = Pagies::with("meta_content", "cms_content")->find(11);
        return view('Frontend.contact-us', compact('data', 'subjects'));
    }

    public function privacyPolicy()
    {
        $data = Pagies::with("meta_content", "cms_content")->find(3);
        return view('Frontend.privacy-policy', compact('data'));
    }

    public function termsAndCondition()
    {
        $data = Pagies::with("meta_content", "cms_content")->find(4);
        return view('Frontend.terms-and-condition', compact('data'));
    }

    public function barberList()
    {
        $data = Pagies::with("meta_content", "cms_content")->find(13);
        return view('Frontend.Barber.barber-list', compact('data'));
    }


    public function barberListFilter(Request $request)
{
    $barber = User::with('barber_service', 'barber_rating')
        ->where('user_type', 3)
        ->where('is_approved', "2")
        ->where('is_delete', 0);

    // Filter by gender
    if ($request->gender) {
        $barber->where('gender', $request->gender);
    }

    // Filter by barber name
    if ($request->barber_name) {
        $names = explode(' ', $request->barber_name);

        $barber->where(function ($query) use ($names) {
            foreach ($names as $name) {
                $query->orWhere('first_name', 'like', '%' . $name . '%')
                      ->orWhere('last_name', 'like', '%' . $name . '%');
            }
        });
    }

    // Filter by salon name
    if ($request->salon_name) {
        $barber->where('salon_name', 'like', '%' . $request->salon_name . '%');
    }

    // Filter by state name
    if ($request->state_name) {
        $barber->where('state_name', 'like', '%' . $request->state_name . '%');
    }

    // Filter by city name
    if ($request->city_name) {
        $barber->where('city_name', 'like', '%' . $request->city_name . '%');
    }

    // Filter by service ID
    if ($request->service_id) {
        $barber->whereHas('barber_service', function ($query) use ($request) {
            $query->where('sub_service_id', $request->service_id);
        });
    }

    $barber_list = $barber->paginate(4);

    // Encrypt IDs and calculate average ratings
    foreach ($barber_list as $barbers) {
        $barbers->average_rating = $barbers->averageRating();
        $barbers['encrypt_id'] = Crypt::encryptString($barbers->id);
    }

    return response()->json(view('Frontend.Barber.barber-list-response', compact('barber_list'))->render());
}

    public function barberDetail($id)
    {
        $id = Crypt::decryptString($id);
        $barber_data = User::with('barber_schedule', 'barber_rating')->find($id);
        $barber_data->encrypt_id = Crypt::encryptString($barber_data->id);
        $barber_data['barber_services'] = BarberServices::with('service_detail', 'sub_service_detail')->where('special_service',1)->where('barber_id', $id)->get();
        $barber_data->average_rating = $barber_data->averageRating();
        if (!empty((Auth::user()))) {
            $check_favorite_list = MyFavorite::where('barber_id', $barber_data->id)->where('user_id', Auth::user()->id)->first();
        } else {
            $check_favorite_list = "";
        }

        $data = Pagies::with("meta_content", "cms_content")->find(14);
        return view('Frontend.Barber.barber-detail', compact('data', 'barber_data', 'check_favorite_list'));

    }

    public function getCmsContent($id)
    {
        $numberArray = explode('-', $id);
        $data = Pagies::with('meta_content', 'cms_content')->where('key', $numberArray[0])->first();
        if ($data) {
            $language = $numberArray[1];
            return view('Frontend.app-content-provider', compact('data', 'language'));
        } else {
            return redirect('404');
        }
    }

    public function saveUserLocation(Request $request)
    {


        $userLatitude = $request->latitude;
        $userLongitude = $request->longitude;

        $topNearbyBarbers = User::with(['barber_service', 'barberRatings:barber_id,rating'])
        ->where([
            ['user_type', 3],
            ['is_approved', "2"],
            ['is_delete', 0]
        ])
        ->whereNotNull('users.latitude')
        ->whereNotNull('users.longitude')
        ->select('users.*', DB::raw("
            ( 6371 * acos( cos( radians($userLatitude) )
            * cos( radians( users.latitude ) )
            * cos( radians( users.longitude ) - radians($userLongitude) )
            + sin( radians($userLatitude) )
            * sin( radians( users.latitude ) ) ) )
            AS distance
        "))
        ->withAvg('barberRatings', 'rating') // Include average rating
        ->orderBy('distance')
        ->take(3)
        ->get()
        ->each(function ($barber) {
            $barber['encrypt_id'] = Crypt::encryptString($barber->id);
            $barber['average_rating'] = $barber->barberRatings_avg_rating; // Add average rating to the array
        });


        return response()->json(view('Frontend.location-wise-barber-response', compact('topNearbyBarbers'))->render());

    }





}
