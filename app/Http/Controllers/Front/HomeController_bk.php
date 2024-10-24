<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Banners;
use App\Models\BarberServices;
use App\Models\Booking;
use App\Models\ContactUS;
use App\Models\MyFavorite;
use App\Models\Pagies;
use App\Models\Services;
use App\Models\Subjects;
use App\Models\Testimonial;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

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
        $topBarbers = User::with('barber_service', 'barber_schedule')->where([
            ['user_type', 3],
            ['is_approved', "2"],
            ['is_delete', 0],
        ])
            ->withAvg('barberRatings', 'rating')
            ->orderByDesc('barber_ratings_avg_rating')
            ->take(3)
            ->get()
            ->each(function ($barber) {
                $barber['encrypt_id'] = Crypt::encryptString($barber->id);
            });

        $banners = Banners::with('barber_info', 'barber_info.barber_service', 'barber_info.barber_schedule')->where("status", 1)->where("is_delete", 0)->get()->each(function ($banner) {
            $banner['encrypt_id'] = Crypt::encryptString($banner->barber_id);
        });

        $data = Pagies::with("meta_content", "cms_content")->find(1);
        $testimonials = Testimonial::where("status", 1)->where("is_delete", 0)->get();
        $services = Services::where('is_special_service', 1)->where('is_delete', 0)->take(6)->get();
        return view('Frontend.home', compact('banners', 'data', 'testimonials', 'services', 'topBarbers'));
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

        return view('Frontend.services-list', compact('data', 'services'));
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

        $barber_list = User::query()
            ->select('users.*')
            ->with('barber_service', 'barber_rating')
            ->where('user_type', 3)
            ->where('is_approved', "2")
            ->where('is_delete', 0)
            ->whereHas('barber_service') // Ensure barber_service is not null
            ->whereHas('barber_schedule') // Ensure barber_schedule is not null
            ->get();

        // Initialize the rating count array
        $ratingCounts = [
            '0' => 0,
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
        ];

        // Calculate the average rating and count the barbers for each rating
        foreach ($barber_list as $barber) {
            $barber->average_rating = $barber->averageRating();

            // Round the average rating to the nearest whole number
            $rounded_rating = floor($barber->average_rating);

            // Ensure the rounded rating is within the range of 0 to 5
            if ($rounded_rating >= 0 && $rounded_rating <= 5) {
                $ratingCounts[$rounded_rating]++;
            }
        }

        $data = Pagies::with("meta_content", "cms_content")->find(13);
        return view('Frontend.Barber.barber-list', compact('data', 'ratingCounts'));
    }

    public function barberListFilter(Request $request)
    {

        $customer_lat = Cookie::get('user_latitude');
        $customer_long = Cookie::get('user_longitude');
        $currentDateFormatted = now()->format('Y-m-d');
        $currentHourFormatted = now()->format('H:i:s');
        $dayName = strtolower(Carbon::now()->format('l'));
        $currentDateTime = Carbon::now();
        $currentDateFormatted = $currentDateTime->format('Y-m-d');
        $currentHourFormatted = $currentDateTime->format('H:i:s');
        $endTime = $currentDateTime->copy()->addHours(3); // End time 3 hours from now

        // Initialize the query builder
        $query = User::query()
            ->select('users.*')
            ->with('barber_service', 'barber_rating', 'barber_schedule')
            ->where('user_type', 3)
            ->where('is_approved', "2")
            ->where('is_delete', 0)
            ->whereHas('barber_service') // Ensure barber_service is not null
            ->whereHas('barber_schedule'); // Ensure barber_schedule is not null

        // Apply distance calculation if coordinates are available
        if (!empty($customer_lat) && !empty($customer_long)) {
            $query->selectRaw("
                    ( 6371 * acos( cos( radians(?) ) * cos( radians( users.latitude ) )
                    * cos( radians( users.longitude ) - radians(?) ) + sin( radians(?) )
                    * sin( radians( users.latitude ) ) ) ) AS distance
                ", [$customer_lat, $customer_long, $customer_lat])
                ->whereNotNull('latitude') // Ensure latitude is set
                ->whereNotNull('longitude'); // Ensure longitude is set

            // Optionally, order by distance
            $query->orderBy('distance', 'asc');
        }

        // Apply filters if provided
        if ($request->gender) {
            $query->where('gender', $request->gender);
        }

        if ($request->barber_name) {
            $names = explode(' ', $request->barber_name);
            $query->where(function ($query) use ($request) {
                $query->whereRaw(
                    'CONCAT(first_name, " ", last_name) LIKE ?',
                    ['%' . $request->barber_name . '%']
                );
            });

        }

        if ($request->salon_name) {
            $query->where('salon_name', 'like', '%' . $request->salon_name . '%');
        }

        if ($request->state_name) {
            $query->where('state_name', 'like', '%' . $request->state_name . '%');
        }

        if ($request->city_name) {
            $query->where('city_name', 'like', '%' . $request->city_name . '%');
        }

        if ($request->service_id) {
            $query->whereHas('barber_service', function ($query) use ($request) {
                $query->where('sub_service_id', $request->service_id);
            });
        }

        // // Apply rating filter
        if ($request->rating != null) {
            $query->withAvg('barber_rating', 'rating');
            $rating = ($request->rating == 0) ? null : $request->rating;
            if ($rating == 0) {
                $query->havingNull('barber_rating_avg_rating');
            } else {
                $query->having('barber_rating_avg_rating', '>=', $rating)->having('barber_rating_avg_rating', '<', $rating + 1);
            }
        }

        // Paginate results
        $barber_list = $query->paginate(10);

        // new code check
        foreach ($barber_list as $barber) {

            $barber->average_rating = $barber->averageRating();
            $barber['encrypt_id'] = Crypt::encryptString($barber->id);
            if (!empty($customer_lat) || !empty($customer_long)) {
                $barber['distance'] = round($barber->distance, 2); // Round distance to 2 decimal places
            }

            $dayName = strtolower(Carbon::now()->format('l')); // Get current day in lowercase
            $holiday = $dayName . "_is_holiday";
            $start_time = $dayName . "_start_time";
            $end_time = $dayName . "_end_time";

            if ($barber->barber_schedule) {
                // If today is a holiday for the barber, set all parameters to 0
                if ($barber->barber_schedule->$holiday == 0) {

                    ///checking current time and start time and checking current time + 3 and edn_time
                    if ($barber->barber_schedule->$start_time < $currentHourFormatted && $barber->barber_schedule->$end_time > $endTime->format('H:i:s')) {

                        $barber_id = $barber->id;

                        // Query for upcoming bookings and waitlist
                        $hasUpcomingBooking = Booking::where('barber_id', $barber_id)
                            ->where('booking_type', "booking")
                            ->where('booking_date', $currentDateFormatted)
                            ->whereBetween('start_time', [$currentHourFormatted, $endTime->format('H:i:s')])
                            ->exists();

                        $hasUpcomingWaitlist = Booking::where('barber_id', $barber_id)
                            ->where('booking_type', "waitlist")
                            ->where('booking_date', $currentDateFormatted)
                            ->exists();

                        // Check if the barber is fully booked for the next 3 hours
                        $bookings = Booking::where('barber_id', $barber_id)
                            ->where('booking_type', 'booking')
                            ->where('booking_date', $currentDateFormatted)
                            ->whereBetween('start_time', [$currentHourFormatted, $endTime->format('H:i:s')])
                            ->orderBy('start_time')
                            ->get();

                        $fullBooked = true;
                        $previousEndTime = $currentHourFormatted;

                        foreach ($bookings as $booking) {
                            // Check for gaps between bookings
                            if ($previousEndTime < $booking->start_time) {
                                $fullBooked = false; // There is a gap, so not fully booked
                                break;
                            }
                            $previousEndTime = $booking->end_time;
                        }

                        // Check for a gap after the last booking
                        if ($previousEndTime < $endTime->format('H:i:s')) {
                            $fullBooked = false; // There is a gap, so not fully booked
                        }

                        // Set the parameters
                        $barber['has_upcoming_waitlist'] = $hasUpcomingWaitlist ? 1 : 0;
                        $barber['has_upcoming_booking'] = $hasUpcomingBooking ? 1 : 0;
                        $barber['full_booked'] = $fullBooked ? 1 : 0;
                        $barber['is_holiday'] = 0;
                    }else
                    {
                        $barber['is_holiday'] = 1;
                    }
                } else {
                    $barber['is_holiday'] = 1;
                }
            } else {
                $barber['is_holiday'] = 1;
            }

        }
        return response()->json(view('Frontend.Barber.barber-list-response', compact('barber_list'))->render());

    }

    public function barberDetail($id)
    {
        $id = Crypt::decryptString($id);
        $barber_data = User::with('barber_schedule', 'barber_rating')->find($id);
        $barber_data->encrypt_id = Crypt::encryptString($barber_data->id);
        $barber_data['barber_services'] = BarberServices::with('service_detail', 'sub_service_detail')->where('barber_id', $id)->get();
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

        // Store coordinates in a cookie
        Cookie::queue('user_latitude', $userLatitude, 60 * 24 * 7); // 1 week
        Cookie::queue('user_longitude', $userLongitude, 60 * 24 * 7); // 1 week

        $topNearbyBarbers = User::with(['barber_service', 'barberRatings:barber_id,rating'])
            ->where([
                ['user_type', 3],
                ['is_approved', "2"],
                ['is_delete', 0],
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

    public function demoPdf()
    {

        $html = view('demo_pdf')->render();

        // Load the HTML and generate PDF
        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'portrait');

        // Return the PDF as a download or display it in the browser
        // return $pdf->stream('demo_pdf.pdf'); // For viewing in browser

        // Load the view and pass the data to it
        $pdf = Pdf::loadView('demo_pdf');

        // Optionally stream the PDF back to the browser
        // return $pdf->stream('demo_pdf');
        $pdfContent = $pdf->output();

        // Convert the PDF content to base64
        $pdfBase64 = base64_encode($pdfContent);

        return response()->json([
            'status' => 1,
            'pdf_base64' => $pdfBase64,
            'message' => __('PDF generated successfully.'),
        ], 200);

        // Or download the PDF
        // return $pdf->download('demo_pdf');
    }

}
