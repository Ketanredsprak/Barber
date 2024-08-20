<?php

namespace App\Http\Controllers\API\V1\Barber;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Barber\BarberAccount;
use App\Http\Resources\Api\Barber\BarberBookingDashboardResource;
use App\Models\Booking;
use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class BarberAccountController extends Controller
{
//barber  api
    public function barberRegister(Request $request)
    {
        $validated = [];
        $validated['first_name'] = "required|min:4";
        $validated['last_name'] = "required|min:4";
        $validated['country_code'] = "required|numeric";
        $validated['phone'] = "required|min:9|max:11|unique:users,phone";
        $validated['gender'] = "required";
        $validated['email'] = "required|email|unique:users,email";
        $validated['nationality'] = "required";
        $validated['iqama_no'] = "required|numeric";
        $validated['iqama_no_expiration_date'] = "required|date";
        $validated['health_license_expiration_date'] = "required|date";
        $validated['store_registration_expiration_date'] = "required|date";
        $validated['health_license'] = "required";
        $validated['store_registration'] = "required";
        $validated['salon_name'] = "required";
        $validated['location'] = "required";
        $validated['country_name'] = "required";
        $validated['state_name'] = "required";
        $validated['city_name'] = "required";
        $validated['about_you'] = "required";
        $validated['latitude'] = "required";
        $validated['longitude'] = "required";
        $validated['profile_image'] = "required|file|mimes:jpeg,png,jpg";
        $validated['password'] = "required";
        $validated['confirm_password'] = "same:password|required";
        $validated['fcm_token'] = "required";

        $customMessages = [
            'first_name.required' => __('error.The first name field is required.'),
            'first_name.min' => __('error.The first name must be at least 4 characters.'),
            'last_name.required' => __('error.The last name field is required.'),
            'last_name.min' => __('error.The last name must be at least 4 characters.'),
            'country_code.required' => __('error.The country code field is required.'),
            'country_code.numeric' => __('error.The country code must be a number.'),
            'phone.required' => __('error.The phone number field is required.'),
            'phone.min' => __('error.The phone number must be at least 9 characters.'),
            'phone.max' => __('error.The phone number may not be greater than 11 characters.'),
            'phone.unique' => __('error.The phone number has already been taken.'),
            'gender.required' => __('error.The gender field is required.'),
            'email.required' => __('error.The email field is required.'),
            'email.email' => __('error.Please enter a valid email address.'),
            'email.unique' => __('error.The email has already been taken.'),
            'nationality.required' => __('error.The nationality field is required.'),
            'iqama_no.required' => __('error.The iqama number field is required.'),
            'iqama_no.numeric' => __('error.The iqama number must be a number.'),
            'iqama_no_expiration_date.required' => __('error.The expiration date field is required.'),
            'iqama_no_expiration_date.date' => __('error.The expiration date must be a valid date'),
            'store_registration_expiration_date.required' => __('error.The expiration date field is required.'),
            'store_registration_expiration_date.date' => __('error.The expiration date must be a valid date.'),
            'health_license_expiration_date.required' => __('error.The expiration date field is required.'),
            'health_license_expiration_date.date' => __('error.The expiration date must be a valid date.'),
            'health_license.required' => __('error.The health license field is required.'),
            'store_registration.required' => __('error.The store registration field is required.'),
            'salon_name.required' => __('error.The salon name field is required.'),
            'location.required' => __('error.The location field is required.'),
            'country_name.required' => __('error.The country name field is required.'),
            'state_name.required' => __('error.The state name field is required.'),
            'city_name.required' => __('error.The city name field is required.'),
            'about_you.required' => __('error.The about you field is required.'),
            'latitude.required' => __('error.The latitude field is required.'),
            'longitude.required' => __('error.The longitude field is required.'),
            'profile_image.required' => __('error.The profile image field is required.'),
            'profile_image.file' => __('error.The profile image must be a file.'),
            'profile_image.mimes' => __('error.The profile image must be a file of type: jpeg, png, jpg.'),
            'password.required' => __('error.The password field is required.'),
            'confirm_password.same' => __('error.The confirm password must match the password.'),
            'confirm_password.required' => __('error.The confirm password field is required.'),
            'fcm_token.required' => __('error.The fcm token field is required.'),
        ];

        $request->validate($validated, $customMessages);
        try {
            $referral_code = generate_rederal_code();

            // for Profile Image
            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $profile_image_name = time() . '_profile_image.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/profile_image');
                $image->move($destinationPath, $profile_image_name);
            }

            // for Health License
            if ($request->hasFile('health_license')) {
                $image = $request->file('health_license');
                $health_license_name = time() . '_health_license.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/health_license');
                $image->move($destinationPath, $health_license_name);
            }

            // for Store Registration
            if ($request->hasFile('store_registration')) {
                $image = $request->file('store_registration');
                $store_registration_name = time() . '_store_registration.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/store_registration');
                $image->move($destinationPath, $store_registration_name);
            }

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender,
                'country_code' => $request->country_code,
                'phone' => $request->phone,
                'email' => $request->email,
                'profile_image' => $profile_image_name,
                'health_license' => $health_license_name,
                'store_registration' => $store_registration_name,
                'nationality' => $request->nationality,
                'iqama_no' => $request->iqama_no,
                'iqama_no_expiration_date' => $request->iqama_no_expiration_date,
                'health_license_expiration_date' => $request->health_license_expiration_date,
                'store_registration_expiration_date' => $request->store_registration_expiration_date,
                'salon_name' => $request->salon_name,
                'location' => $request->location,
                'country_name' => $request->country_name ?? "",
                'state_name' => $request->state_name ?? "",
                'city_name' => $request->city_name ?? "",
                'about_you' => $request->about_you,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'user_type' => 3,
                'is_approved' => "1",
                'register_type' => 1,
                'register_method' => 1,
                'password' => Hash::make($request->password),
                'referral_code' => $referral_code ?? '',
                'fcm_token' => $request->fcm_token ?? '',
                'token' => '',
            ]);

            $subscription_id = 5;

            $user_permission = setUserPermissionBaseOnSubscription($user->id, $subscription_id);

            $credentials = [
                'email' => $request->email,
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
                $data = new BarberAccount($array);

                sendEmail($user->id, 'barber', '');

            }

            // $data = new BarberAccount($user);
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

    public function barberEditProfile(Request $request)
    {
        $id = Auth::user()->id;
        $validated = [];
        $validated['first_name'] = "required|min:4";
        $validated['last_name'] = "required|min:4";
        $validated['email'] = "required|email|unique:users,email," . $id;
        $validated['country_code'] = "required|numeric";
        $validated['phone'] = "required|min:9|max:11|unique:users,phone," . $id;
        $validated['gender'] = "required";
        // $validated['profile_image'] = "required|file|mimes:jpeg,png,jpg";
        $validated['salon_name'] = "required";
        // $validated['health_license'] = "required";
        $validated['iqama_no_expiration_date'] = "required|date";
        $validated['health_license_expiration_date'] = "required|date";
        $validated['store_registration_expiration_date'] = "required|date";
        $validated['location'] = "required";
        // $validated['country_name'] = "required";
        // $validated['state_name'] = "required";
        // $validated['city_name'] = "required";
        // $validated['nationality'] = "required";
        $validated['iqama_no'] = "required:numeric";
        // $validated['about_you'] = "required";
        $validated['latitude'] = "required";
        $validated['longitude'] = "required";
        // $validated['store_registration'] = "required";

        $customMessages = [
            'first_name.required' => __('error.The first name field is required.'),
            'first_name.min' => __('error.The first name must be at least 4 characters.'),
            'last_name.required' => __('error.The last name field is required.'),
            'last_name.min' => __('error.The last name must be at least 4 characters.'),
            'country_code.required' => __('error.The country code field is required.'),
            'country_code.numeric' => __('error.The country code must be a number.'),
            'phone.required' => __('error.The phone number field is required.'),
            'phone.min' => __('error.The phone number must be at least 9 characters.'),
            'phone.max' => __('error.The phone number may not be greater than 11 characters.'),
            'phone.unique' => __('error.The phone number has already been taken.'),
            'gender.required' => __('error.The gender field is required.'),
            'email.required' => __('error.The email field is required.'),
            'email.email' => __('error.Please enter a valid email address.'),
            'email.unique' => __('error.The email has already been taken.'),
            'country_name.required' => __('error.The country name field is required.'),
            'state_name.required' => __('error.The state name field is required.'),
            'city_name.required' => __('error.The city name field is required.'),
            'profile_image.required' => __('error.The profile image field is required.'),
            'profile_image.file' => __('error.The profile image must be a file.'),
            'profile_image.mimes' => __('error.The profile image must be a file of type: jpeg, png, jpg.'),
            'salon_name.required' => __('error.The salon name field is required.'),
            'health_license.required' => __('error.The health license field is required.'),
            'store_registration_expiration_date.required' => __('error.The expiration date field is required.'),
            'store_registration_expiration_date.date' => __('error.The expiration date must be a valid date.'),
            'health_license_expiration_date.required' => __('error.The expiration date field is required.'),
            'health_license_expiration_date.date' => __('error.The expiration date must be a valid date.'),
            'iqama_no_expiration_date.required' => __('error.The expiration date field is required.'),
            'iqama_no_expiration_date.date' => __('error.The expiration date must be a valid date.'),
            'location.required' => __('error.The location field is required.'),
            'nationality.required' => __('error.The nationality field is required.'),
            'iqama_no.required' => __('error.The iqama number field is required.'),
            'iqama_no.numeric' => __('error.The iqama number must be a number.'),
            'store_registration.required' => __('error.The store registration field is required.'),
            'about_you.required' => __('error.The about you field is required.'),
            'latitude.required' => __('error.The latitude field is required.'),
            'longitude.required' => __('error.The longitude field is required.'),
        ];

        $request->validate($validated, $customMessages);

        try {

            $auth = User::find($id);
            $auth->first_name = $request->first_name;
            $auth->last_name = $request->last_name;
            $auth->gender = $request->gender;
            $auth->gender = $request->gender;
            $auth->email = $request->email;
            $auth->country_code = $request->country_code;
            $auth->phone = $request->phone;
            $auth->salon_name = $request->salon_name;
            $auth->health_license_expiration_date = $request->health_license_expiration_date;
            $auth->store_registration_expiration_date = $request->store_registration_expiration_date;
            $auth->iqama_no_expiration_date = $request->iqama_no_expiration_date;
            $auth->location = $request->location;
            $auth->country_name = $request->country_name ?? "";
            $auth->state_name = $request->state_name ?? "";
            $auth->city_name = $request->city_name ?? "";
            $auth->nationality = $request->nationality ?? "";
            $auth->iqama_no = $request->iqama_no;
            $auth->about_you = $request->about_you;
            $auth->latitude = $request->latitude;
            $auth->longitude = $request->longitude;

            // for Image
            if ($request->hasFile('health_license')) {
                File::delete(public_path('health_license/' . $auth->health_license));
                $image = $request->file('health_license');
                $uploaded = time() . '_health_license.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/health_license');
                $image->move($destinationPath, $uploaded);
                $auth->health_license = $uploaded;
            }

            // for Image
            $uploaded = "";
            $image = "";
            $destinationPath = "";
            if ($request->hasFile('store_registration')) {
                File::delete(public_path('store_registration/' . $auth->store_registration));
                $image = $request->file('store_registration');
                $uploaded = time() . '_store_registration.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/store_registration');
                $image->move($destinationPath, $uploaded);
                $auth->store_registration = $uploaded;
            }

            // for Image
            $uploaded = "";
            $image = "";
            $destinationPath = "";
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
                $data = new BarberAccount($auth);
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

    public function barberDashboard(Request $request)
    {
        {
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

                    $user_sub = UserSubscription::with('subscription_detail')->where('user_id', $user->id)->where('status', 'active')->first();
                    $data['barber_detail']['barber_name'] = $user->first_name . " " . $user->last_name;
                    $data['barber_detail']['barber_profile_url'] = URL::to('/public') . '/profile_image/' . ($user->profile_image ? $user->profile_image : "user.png");
                    if ($user_sub) {
                        $data['barber_detail']['barber_current_subscription'] = $user_sub->subscription_detail->$subscript_name ?? "";

                    } else {
                        $data['barber_detail']['barber_current_subscription'] = __('message.Upgrad Subscription');

                    }
                } else {
                    $data['barber_detail']['barber_name'] = __('message.Upgrad Subscription');
                    $data['barber_detail']['barber_profile_url'] = URL::to('/public') . '/profile_image/user.png';
                    $data['barber_detail']['barber_current_subscription'] = __('message.Guest User');

                }

                $currentDate = Carbon::now()->toDateString(); // Current date
                $currentTime = Carbon::now()->toTimeString(); // Current time

                //barber uplcoming booking
                // dd($user->id);

                $total_booking = Booking::with('customer_detail')
                    ->where('barber_id', $user->id)
                    ->where('booking_type', 'booking')
                    ->whereIn('status', ['accept','finished'])->count();

                // Start building the query
                $query = Booking::with('customer_detail')
                    ->where('barber_id', $user->id)
                    ->where('booking_type', 'booking')
                    ->where('status', 'accept')
                    ->orderBy('id', 'DESC');

                if ($request->search) {
                    $nameParts = explode(' ', $request->search, 2);
                    $firstName = $nameParts[0] ?? null;
                    $lastName = $nameParts[1] ?? null;

                    $query->whereHas('customer_detail', function ($q) use ($firstName, $lastName) {
                        if ($firstName && $lastName) {
                            // Search by both first and last names
                            $q->where('first_name', 'LIKE', '%' . $firstName . '%')
                                ->where('last_name', 'LIKE', '%' . $lastName . '%');
                        } elseif ($firstName) {
                            // Search by first name only
                            $q->where('first_name', 'LIKE', '%' . $firstName . '%');
                        } elseif ($lastName) {
                            // Search by last name only
                            $q->where('last_name', 'LIKE', '%' . $lastName . '%');
                        }
                    });
                }

                $total_upcoming_booking = $query->count();
                $bookings = $query->get();

                // get nearet barber
                $data['total_points'] = 0;
                $data['total_loyal_client '] = 0;
                $data['total_upcoming_booking '] = $total_upcoming_booking;
                $data['total_booking'] = $total_booking;
                $data['bookings'] = BarberBookingDashboardResource::collection($bookings);

                return response()->json(
                    [
                        'data' => $data,
                        'status' => 1,
                        'message' => __('message.Barber dashboard get successfully.'),
                    ], 200);

            } catch (Exception $ex) {
                return response()->json(
                    ['success' => 0, 'message' => $ex->getMessage()], 401
                );
            }

        }
    }

}
