<?php

namespace App\Http\Controllers\API\V1\Customer;

use App\Models\User;
use App\Models\Banners;
use App\Models\Services;
use Illuminate\Http\Request;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Api\BannerResource;
use App\Http\Resources\Api\ServiceResource;
use App\Http\Resources\Api\NearetBarberResource;
use App\Http\Resources\Api\TopRatingBarberResource;
use App\Http\Resources\Api\Customer\CustomerAccount;

class CustomerAccountController extends Controller
{
//customer  api

    public function customerRegister(Request $request)
    {
        $validated = [];
        $validated['first_name'] = "required|min:4";
        $validated['last_name'] = "required|min:4";
        $validated['country_code'] = "required|numeric";
        $validated['phone'] = "required|min:9|max:11|unique:users,phone";
        $validated['gender'] = "required";
        $validated['email'] = "required|email|unique:users,email";
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
            'password.required' => __('error.The password field is required.'),
            'confirm_password.same' => __('error.The confirm password must match the password.'),
            'confirm_password.required' => __('error.The confirm password field is required.'),
            'fcm_token.required' => __('error.The fcm token field is required.'),
        ];

        $request->validate($validated, $customMessages);

        $request->validate($validated);
        try {
            $referral_code = generate_rederal_code();
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender,
                'country_code' => $request->country_code,
                'phone' => $request->phone,
                'email' => $request->email,
                'user_type' => 4,
                'is_approved' => "2",
                'register_type' => 1,
                'register_method' => 1,
                'password' => Hash::make($request->password),
                'referral_code' => $referral_code ?? '',
                'submit_referral_code' => $request->referral_code ?? '',
                'fcm_token' => $request->fcm_token,
                'token' => '',
            ]);

            $subscription_id = 1;

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
                $data = new CustomerAccount($array);

                sendEmail($data->id,'customer','');


            }

            // $data = new CustomerAccount($user);


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
        $language_code = $request->header('language');

        $id = Auth::user()->id;
        $validated = [];
        $validated['first_name'] = "required|min:4";
        $validated['last_name'] = "required|min:4";
        $validated['email'] = "required|email|unique:users,email," . $id;
        $validated['country_code'] = "required|numeric";
        $validated['phone'] = "required|min:9|max:11|unique:users,phone," . $id;
        $validated['gender'] = "required";

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
                        $data['customer_detail']['customer_name'] = $user->first_name . " " . $user->last_name;
                        $data['customer_detail']['customer_profile_url'] = URL::to('/public') . '/profile_image/' . ($user->profile_image ? $user->profile_image : "user.png");
                        if($user_sub) {
                        $data['customer_detail']['customer_current_subscription'] = $user_sub->subscription_detail->$subscript_name ?? "";
                        $data['customer_detail']['customer_available_bookings'] = $user_sub->availble_booking;
                        }
                        else
                        {
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
            $services = Services::where('is_special_service', 1)->where('status', 1)->where('is_delete', 0)->get();


             // get top 3 barber based on rating
            $topBarbers = User::with('barber_service','barber_schedule')->where([
                ['user_type', 3],
                ['is_approved', "2"],
                ['is_delete', 0]
            ])->select('id','first_name','last_name','gender','salon_name','location','country_name','state_name','city_name','profile_image','email','about_you','latitude','longitude')
            ->withAvg('barberRatings', 'rating')
            ->orderByDesc('barber_ratings_avg_rating')
            ->take(5)
            ->get();

            // get top 5 barber based on rating



            // get nearet barber
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
            ->take(5)
            ->get();





            // get nearet barber
            $data['advertisement_detail'] =   BannerResource::collection($banners);
            $data['services_detail'] = ServiceResource::collection($services);
            $data['top_barbers_based_on_rating'] = TopRatingBarberResource::collection($topBarbers);
            $data['nearet_barbers_based_location'] = NearetBarberResource::collection($topNearbyBarbers);

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
