<?php

namespace App\Http\Controllers\API\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BannerResource;
use App\Http\Resources\Api\Customer\CustomerAccount;
use App\Http\Resources\Api\NearetBarberResource;
use App\Http\Resources\Api\ServiceResource;
use App\Http\Resources\Api\TopRatingBarberResource;
use App\Models\Banners;
use App\Models\Booking;
use App\Models\BookingServiceDetail;
use App\Models\Notification;
use App\Models\PointSystem;
use App\Models\Services;
use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class CustomerAccountController extends Controller
{
//customer  api

    public function customerRegister(Request $request)
    {
        $validated = [];
        $validated['first_name'] = "required";
        // $validated['last_name'] = "required";
        $validated['country_code'] = "required|numeric";
        $validated['phone'] = "required|min:9|max:9|unique:users,phone";
        // $validated['gender'] = "required";
        // $validated['email'] = "required|email|unique:users,email";
        $validated['password'] = "required";
        $validated['confirm_password'] = "same:password|required";
        $validated['fcm_token'] = "required";
        $validated['device_type'] = "required";

        $customMessages = [
            'first_name.required' => __('error.The first name field is required.'),
            // 'last_name.required' => __('error.The last name field is required.'),
            'country_code.required' => __('error.The country code field is required.'),
            'country_code.numeric' => __('error.The country code must be a number.'),
            'phone.required' => __('error.The phone number field is required.'),
            'phone.min' => __('error.The phone number must be at least 9 characters.'),
            'phone.max' => __('error.The phone number may not be greater than 9 characters.'),
            'phone.unique' => __('error.The phone number has already been taken.'),
            // 'gender.required' => __('error.The gender field is required.'),
            // 'email.required' => __('error.The email field is required.'),
            // 'email.email' => __('error.Please enter a valid email address.'),
            // 'email.unique' => __('error.The email has already been taken.'),
            'password.required' => __('error.The password field is required.'),
            'confirm_password.same' => __('error.The confirm password must match the password.'),
            'confirm_password.required' => __('error.The confirm password field is required.'),
            'fcm_token.required' => __('error.The fcm token field is required.'),
            'device_type.required' => __('error.The device type field is required.'),
        ];

        $request->validate($validated, $customMessages);

        try {
            $referral_code = generate_rederal_code();
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name ?? "",
                'gender' => $request->gender ?? "",
                'country_code' => $request->country_code,
                'phone' => $request->phone,
                'email' => $request->email ?? "",
                'user_type' => 4,
                'is_approved' => "2",
                'register_type' => 1,
                'register_method' => 1,
                'password' => Hash::make($request->password),
                'referral_code' => $referral_code ?? '',
                'submit_referral_code' => $request->referral_code ?? '',
                'fcm_token' => $request->fcm_token,
                'token' => '',
                'device_type' => $request->device_type,
            ]);

            $subscription_id = 1;

            $user_permission = setUserPermissionBaseOnSubscription($user->id, $subscription_id);

            $credentials = [
                'phone' => $request->phone,
                'password' => $request->password,
            ];

            // Attempt to authenticate the user
            if (auth()->attempt($credentials)) {

                $token = auth()->user()->createToken('Auth Login')->accessToken;
                $array = Auth::user();
                $array['token'] = $token;
                $user = auth()->user();

                $user->token = $token;
                $user->save();
                $data = "";
                $data = new CustomerAccount($array);

                sendEmail($user->id, 'customer', '');

            }

            $data = new CustomerAccount($user);

            if ($data) {
                return response()->json(
                    [
                        'data' => $data,
                        'status' => 1,
                        'message' => __('message.Register successfully'),
                    ], 200);
            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }
    }

    public function customerEditProfile(Request $request)
    {

        // account delete,suspend and wiating for approved
        $response = checkUserStatus(Auth::user()->id);
        if ($response['status'] == 1) {
            return response()->json(
                [
                    'status' => 2,
                    'message' => $response['message'],
                ], 200);
        }
        // account delete,suspend and wiating for approved

        $language_code = $request->header('language');

        $id = Auth::user()->id;
        $validated = [];
        $validated['first_name'] = "required|min:4";
        // $validated['last_name'] = "required|min:4";
        $validated['email'] = "required|email|unique:users,email," . $id;
        $validated['country_code'] = "required|numeric";
        $validated['phone'] = "required|min:9|max:9|unique:users,phone," . $id;
        $validated['gender'] = "required";

        $customMessages = [
            'first_name.required' => __('error.The first name field is required.'),
            'first_name.min' => __('error.The first name must be at least 4 characters.'),
            // 'last_name.required' => __('error.The last name field is required.'),
            // 'last_name.min' => __('error.The last name must be at least 4 characters.'),
            'country_code.required' => __('error.The country code field is required.'),
            'country_code.numeric' => __('error.The country code must be a number.'),
            'phone.required' => __('error.The phone number field is required.'),
            'phone.min' => __('error.The phone number must be at least 9 characters.'),
            'phone.max' => __('error.The phone number may not be greater than 9 characters.'),
            'phone.unique' => __('error.The phone number has already been taken.'),
            'gender.required' => __('error.The gender field is required.'),
            'email.required' => __('error.The email field is required.'),
            'email.email' => __('error.Please enter a valid email address.'),
            'email.unique' => __('error.The email has already been taken.'),
        ];

        $request->validate($validated, $customMessages);

        try {

            $auth = User::find($id);
            $auth->first_name = $request->first_name;
            $auth->last_name = $request->last_name ?? "";
            $auth->gender = $request->gender;
            $auth->email = $request->email;
            $auth->country_code = $request->country_code;
            $auth->phone = $request->phone;
            $auth->country_name = $request->country_name ?? "";
            $auth->state_name = $request->state_name ?? "";
            $auth->city_name = $request->city_name ?? "";
            $auth->location = $request->location ?? "";

            // for Image
            if ($request->hasFile('profile_image')) {
                File::delete(public_path('profile_image/' . $auth->profile_image));
                $image = $request->file('profile_image');
                $uploaded = time() . '_profile_image.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/profile_image');
                $image->move($destinationPath, $uploaded);
                $auth->profile_image = $uploaded;
            }

            $auth->save();
            if (!empty($auth)) {
                $data = new CustomerAccount($auth);
                return response()->json(
                    [
                        'data' => $data,
                        'status' => 1,
                        'message' => __('message.Profile update successfully'),
                    ], 200);
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    public function customerDashboard(Request $request)
    {

        // account delete,suspend and wiating for approved
        $response = checkUserStatus(Auth::user()->id);
        if ($response['status'] == 1) {
            return response()->json(
                [
                    'status' => 2,
                    'message' => $response['message'],
                ], 200);
        }
        // account delete,suspend and wiating for approved

        $language_code = $request->header('language');
        $subscript_name = "subscription_name_" . $language_code;
        $banner_title = "title_" . $language_code;
        $banner_content = "content_" . $language_code;
        try {
            $user = "";
            if (auth('api')->check()) {
                $user = auth('api')->user();
            }

            if (!empty($user)) {

                // account delete,suspend and wiating for approved
                $response = checkUserStatus($user->id);
                if ($response['status'] == 1) {
                    return response()->json(
                        [
                            'status' => 2,
                            'message' => $response['message'],
                        ], 200);
                }
                // account delete,suspend and wiating for approved

                $user_sub = UserSubscription::with('subscription_detail')->where('user_id', $user->id)->where('status', 'active')->first();
                $data['customer_detail']['customer_name'] = $user->first_name . " " . $user->last_name;
                $data['customer_detail']['customer_profile_url'] = URL::to('/public') . '/profile_image/' . ($user->profile_image ? $user->profile_image : "user.png");
                if ($user_sub) {
                    $data['customer_detail']['customer_current_subscription'] = $user_sub->subscription_detail->$subscript_name ?? "";
                    $data['customer_detail']['customer_available_bookings'] = $user_sub->availble_booking;
                } else {
                    $data['customer_detail']['customer_current_subscription'] = __('message.Upgrad Subscription');
                    $data['customer_detail']['customer_available_bookings'] = 0;
                }
            } else {
                $data['customer_detail']['customer_name'] = __('message.Upgrad Subscription');
                $data['customer_detail']['customer_profile_url'] = URL::to('/public') . '/profile_image/user.png';
                $data['customer_detail']['customer_current_subscription'] = __('message.Guest User');
                $data['customer_detail']['customer_available_bookings'] = 0;
            }

            $banners = Banners::where('status', 1)->where('status', 1)->where('is_delete', 0)->get();
            $services = Services::where('is_special_service', 1)->where('status', 1)->where('is_delete', 0)->take(10)->get();
            $notification_count = Notification::where('user_id', $user->id)->where('is_read', 0)->count();

            //user data
            $userLatitude = $request->latitude;
            $userLongitude = $request->longitude;
            $currentDateFormatted = now()->format('Y-m-d');
            $currentHourFormatted = now()->format('H:i:s');
            $dayName = strtolower(Carbon::now()->format('l'));
            $currentDateTime = Carbon::now();
            $currentDateFormatted = $currentDateTime->format('Y-m-d');
            $currentHourFormatted = $currentDateTime->format('H:i:s');
            $endTime = $currentDateTime->copy()->addHours(3); // End time 3 hours from now

            // get top 20 barber based on rating
            $topBarbers = User::with('barber_service', 'barber_schedule')->where([
                ['user_type', 3],
                ['is_approved', "2"],
                ['is_delete', 0],
            ])->select('id', 'first_name', 'last_name', 'gender', 'salon_name', 'location', 'country_name', 'state_name', 'city_name', 'profile_image', 'email', 'about_you', 'latitude', 'longitude')
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
                ->having('distance', '<=', 100)
                ->withAvg('barberRatings', 'rating')
                ->orderByDesc('barber_ratings_avg_rating')
                ->take(20)
                ->get();

            // new code check
            foreach ($topBarbers as $topBarber) {

                $topBarber->average_rating = $topBarber->averageRating();
                $topBarber['encrypt_id'] = Crypt::encryptString($topBarber->id);
                if (!empty($userLatitude) || !empty($userLongitude)) {
                    $topBarber['distance'] = round($topBarber->distance, 2); // Round distance to 2 decimal places
                }

                $dayName = strtolower(Carbon::now()->format('l')); // Get current day in lowercase
                $holiday = $dayName . "_is_holiday";
                $start_time = $dayName . "_start_time";
                $end_time = $dayName . "_end_time";

                if ($topBarber->barber_schedule) {
                    // If today is a holiday for the barber, set all parameters to 0
                    if ($topBarber->barber_schedule->$holiday == 0) {

                        ///checking current time and start time and checking current time + 3 and edn_time
                        if ($topBarber->barber_schedule->$start_time < $currentHourFormatted && $topBarber->barber_schedule->$end_time > $endTime->format('H:i:s')) {

                            $barber_id = $topBarber->id;

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
                            $slots = [];
                            $slotLimit = 6;
                            $slotDuration = 30 * 60; // 30 minutes in seconds

                            // Convert current time to timestamp
                            $startTime = strtotime($currentHourFormatted);

                            // Calculate the minutes part of the current time
                            $minutes = (int) date('i', $startTime);

                            // Calculate the next 30-minute mark
                            if ($minutes > 0 && $minutes <= 30) {
                                $nextSlotTime = strtotime(date('H', $startTime) . ":30:00");
                            } else {
                                // Round up to the next hour if minutes are above 30
                                $nextSlotTime = strtotime((date('H', $startTime) + 1) . ":00:00");
                            }

                            // Generate the slots
                            for ($i = 0; $i < $slotLimit; $i++) {
                                $slotFormatted = date("H:i:s", $nextSlotTime);
                                $slots[] = $slotFormatted;

                                // Check if the slot already exists in the database
                                $slotExists = BookingServiceDetail::whereHas('booking_detail', function ($query) use ($topBarber, $slotFormatted) {
                                    $query->where('barber_id', $topBarber->id);
                                })
                                    ->where('start_time', $slotFormatted)
                                    ->exists();

                                // Set a flag based on whether the slot exists
                                if ($slotExists) {
                                    $topBarber['full_booked'] = $slotExists ? 1 : 0;
                                } else {
                                    $topBarber['full_booked'] = $slotExists ? 1 : 0;
                                }

                                $nextSlotTime += $slotDuration; // Increment by 30 minutes
                            }
                            // Check if the barber is fully booked for the next 3 hours

                            // Set the parameters
                            $topBarber['has_upcoming_waitlist'] = $hasUpcomingWaitlist ? 1 : 0;
                            $topBarber['has_upcoming_booking'] = $hasUpcomingBooking ? 1 : 0;
                            $topBarber['is_holiday'] = 0;
                        } else {
                            $topBarber['is_holiday'] = 1;
                        }
                    } else {
                        $topBarber['is_holiday'] = 1;
                    }
                } else {
                    $topBarber['is_holiday'] = 1;
                }

            }

            // get top 5 barber based on rating

            // get nearet barber
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
                ->having('distance', '<=', 100)
                ->withAvg('barberRatings', 'rating') // Include average rating
                ->orderBy('distance')
                ->take(20)
                ->get();

            // new code check
            foreach ($topNearbyBarbers as $topNearbyBarber) {

                $topNearbyBarber->average_rating = $topNearbyBarber->averageRating();
                $topNearbyBarber['encrypt_id'] = Crypt::encryptString($topNearbyBarber->id);
                if (!empty($userLatitude) || !empty($userLongitude)) {
                    $topNearbyBarber['distance'] = round($topNearbyBarber->distance, 2); // Round distance to 2 decimal places
                }

                $dayName = strtolower(Carbon::now()->format('l')); // Get current day in lowercase
                $holiday = $dayName . "_is_holiday";
                $start_time = $dayName . "_start_time";
                $end_time = $dayName . "_end_time";

                if ($topNearbyBarber->barber_schedule) {
                    // If today is a holiday for the barber, set all parameters to 0
                    if ($topNearbyBarber->barber_schedule->$holiday == 0) {

                        ///checking current time and start time and checking current time + 3 and edn_time
                        if ($topNearbyBarber->barber_schedule->$start_time < $currentHourFormatted && $topNearbyBarber->barber_schedule->$end_time > $endTime->format('H:i:s')) {

                            $barber_id = $topNearbyBarber->id;

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
                            $slots = [];
                            $slotLimit = 6;
                            $slotDuration = 30 * 60; // 30 minutes in seconds

                            // Convert current time to timestamp
                            $startTime = strtotime($currentHourFormatted);

                            // Calculate the minutes part of the current time
                            $minutes = (int) date('i', $startTime);

                            // Calculate the next 30-minute mark
                            if ($minutes > 0 && $minutes <= 30) {
                                $nextSlotTime = strtotime(date('H', $startTime) . ":30:00");
                            } else {
                                // Round up to the next hour if minutes are above 30
                                $nextSlotTime = strtotime((date('H', $startTime) + 1) . ":00:00");
                            }

                            // Generate the slots
                            for ($i = 0; $i < $slotLimit; $i++) {
                                $slotFormatted = date("H:i:s", $nextSlotTime);
                                $slots[] = $slotFormatted;

                                // Check if the slot already exists in the database
                                $slotExists = BookingServiceDetail::whereHas('booking_detail', function ($query) use ($topNearbyBarber, $slotFormatted) {
                                    $query->where('barber_id', $topNearbyBarber->id);
                                })
                                    ->where('start_time', $slotFormatted)
                                    ->exists();

                                // Set a flag based on whether the slot exists
                                if ($slotExists) {
                                    $topNearbyBarber['full_booked'] = $slotExists ? 1 : 0;
                                } else {
                                    $topNearbyBarber['full_booked'] = $slotExists ? 1 : 0;
                                }

                                $nextSlotTime += $slotDuration; // Increment by 30 minutes
                            }
                            // Check if the barber is fully booked for the next 3 hours

                            // Set the parameters
                            $topNearbyBarber['has_upcoming_waitlist'] = $hasUpcomingWaitlist ? 1 : 0;
                            $topNearbyBarber['has_upcoming_booking'] = $hasUpcomingBooking ? 1 : 0;
                            $topNearbyBarber['is_holiday'] = 0;
                        } else {
                            $topNearbyBarber['is_holiday'] = 1;
                        }
                    } else {
                        $topNearbyBarber['is_holiday'] = 1;
                    }
                } else {
                    $topNearbyBarber['is_holiday'] = 1;
                }

            }

            // get nearet barber
            $data['advertisement_detail'] = BannerResource::collection($banners);
            $data['services_detail'] = ServiceResource::collection($services);
            $data['top_barbers_based_on_rating'] = TopRatingBarberResource::collection($topBarbers);
            $data['nearet_barbers_based_location'] = NearetBarberResource::collection($topNearbyBarbers);
            $data['point_system'] = PointSystem::select('per_booking_points', 'per_active_referral_points', 'how_many_point_equal_sr')->first();
            $data['unread_notification'] = $notification_count ?? 0;

            return response()->json(
                [
                    'data' => $data,
                    'status' => 1,
                    'message' => __('message.Customer dashboard get successfully.'),
                ], 200);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

}
