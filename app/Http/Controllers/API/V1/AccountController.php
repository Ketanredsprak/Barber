<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Http\Resources\Api\AccountResource;
use App\Http\Resources\Api\Barber\BarberAccount;
use App\Http\Resources\Api\Customer\CustomerAccount;

class AccountController extends Controller
{

    public function login(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'email_or_phone' => 'required',
            'password' => 'required',
        ]);

        try {
            // Determine if the input is an email or a phone number
            $loginType = filter_var($request->email_or_phone, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
            $credentials = [
                $loginType => $request->email_or_phone,
                'password' => $request->password,
            ];

            // Attempt to authenticate the user
            if (auth()->attempt($credentials)) {
                $token = auth()->user()->createToken('checking')->accessToken;
                $array = Auth::user();
                $array['token'] = $token;
                $user = auth()->user();
                $user->token = $token;
                $user->save();

                if (Auth::user()->user_type == 3) {
                    $data = new BarberAccount($array);
                } else {
                    $data = new CustomerAccount($array);
                }

                return response()->json(
                    [
                        'data' => $data,
                        'status' => 1,
                        'message' => "Login Successfully",
                    ], 200);
            } else {
                return response()->json(
                    [
                        'message' => 'Incorrect Email/Phone Number and Password.',
                        'status' => 0,
                    ], 200);
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }
    }

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
                'is_approved' => 1,
                'register_type' => 1,
                'register_method' => 1,
                'password' => Hash::make($request->password),
                'referral_code' => $referral_code ?? '',
                'token' => '',
            ]);

            $data = new CustomerAccount($user);
            if ($data) {
                return response()->json(
                    [
                        'data' => $data,
                        'status' => 1,
                        'message' => "regiter_successfully",
                    ], 200);
            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }
    }

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
        $validated['expiration_date'] = "required|date";
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

        $request->validate($validated);
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
                'expiration_date' => $request->expiration_date,
                'salon_name' => $request->salon_name,
                'location' => $request->location,
                'country_name' => $request->country_name,
                'state_name' => $request->state_name,
                'city_name' => $request->city_name,
                'about_you' => $request->about_you,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'user_type' => 3,
                'is_approved' => 1,
                'register_type' => 1,
                'register_method' => 1,
                'password' => Hash::make($request->password),
                'referral_code' => $referral_code ?? '',
                'token' => '',
            ]);

            $data = new BarberAccount($user);
            if ($data) {
                return response()->json(
                    [
                        'data' => $data,
                        'status' => 1,
                        'message' => "regiter_successfully",
                    ], 200);
            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }
    }

    //get profile
    public function profile(Request $request)
    {
        try {
            $language_code = $request->header('language');

            $user = User::find(Auth::user()->id);
            if (!empty($user)) {
                if ($user->user_type == 4) {
                    $data = new CustomerAccount($user);
                } else {
                    $data = new BarberAccount($user);
                }
                return response()->json(
                    [
                        'data' => $data,
                        'status' => 1,
                        'message' => "profile_get_successfully",
                    ], 200);
            } else {
                return response()->json(
                    [
                        'message' => "profile_not_found",
                        'status' => 0,
                    ]
                    , 200);
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    public function changePassword(Request $request)
    {

        $language_code = $request->header('language');

        $validated = [];
        $user_id = Auth::user()->id;

        $validated['current_password'] = "required";
        $validated['password'] = "required";
        $validated['confirm_password'] = "same:password|required";

        $customMessages = [
            'user_id.required' => "the_user_id_field_is_required",
            'current_password.required' => "the_current_password_field_is_required",
            'password.required' => "the_password_field_is_required",
            'confirm_password.same' => "the_confirm_password_must_match_the_password",
            'confirm_password.required' => "the_confirm_password_field_is_required",
        ];

        $request->validate($validated, $customMessages);

        try {
            $auth = User::find($user_id);

            // The passwords matches
            if (!Hash::check($request->current_password, $auth->password)) {
                return response()->json(
                    [
                        'status' => 0,
                        'message' => "current_password_is_invalid",
                    ], 200);
            }

            // Current password and new password same
            if (strcmp($request->current_password, $request->password) == 0) {
                return response()->json(
                    [
                        'status' => 0,
                        'message' => "new_password_cannot_be_same_as_your_current_password",
                    ], 200);
            }

            $auth->password = Hash::make($request->password);
            $auth->update();
            return response()->json(
                [
                    'status' => 1,
                    'message' => "password_changed_successfully",
                ], 200);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    public function logout(Request $request)
    {

        $language_code = $request->header('language');

        if ($request->user()) {
            $request->user()->token()->revoke();
            return response()->json(
                [
                    'status' => 1,
                    'message' => "logout_successfully",
                ], 200);
        } else {
            return response()->json(
                [
                    'status' => 0,
                    'message' => "somthing_went_wrong",
                ], 200);
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
        $validated['phone'] = "required|unique:users,phone," . $id;
        $validated['gender'] = "required";
        $validated['country_name'] = "required";
        $validated['state_name'] = "required";
        $validated['city_name'] = "required";
        $validated['profile_image'] = "required|file|mimes:jpeg,png,jpg";

        $customMessages = [
            'first_name.required' => "the_first_name_field_is_required",
            'first_name.min' => "the_first_name_must_be_at_least_4_characters",
            'last_name.required' => "the_last_name_field_is_required",
            'last_name.min' => "the_last_name_must_be_at_least_4_characters",
            'phone.required' => "the_phone_field_is_required",
            'phone.unique' => "this_phone_is_already_take",
            'phone.min' => "the_phone_number_must_be_at_least_8_characters",
            'email.required' => "the_email_field_is_required",
            'email.email' => "the_email_must_be_a_valid_email_address",
            'email.unique' => "this_email_is_already_take",
            'country_name.required' => "the_country_name_field_is_required",
            'state_name.required' => "the_state_name_field_is_required",
            'city_name.required' => "the_city_name_field_is_required",
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
            $auth->country_name = $request->country_name;
            $auth->state_name = $request->state_name;
            $auth->city_name = $request->city;

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
                        'message' => "profile_update_successfully",
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
        $validated['phone'] = "required|unique:users,phone," . $id;
        $validated['gender'] = "required";
        $validated['profile_image'] = "required|file|mimes:jpeg,png,jpg";
        $validated['salon_name'] = "required";
        $validated['health_license'] = "required";
        $validated['expiration_date'] = "required|date";
        $validated['location'] = "required";
        $validated['country_name'] = "required";
        $validated['state_name'] = "required";
        $validated['city_name'] = "required";
        $validated['nationality'] = "required";
        $validated['iqama_no'] = "required";
        $validated['about_you'] = "required";
        $validated['latitude'] = "required";
        $validated['longitude'] = "required";
        $validated['store_registration'] = "required";

        $customMessages = [
            'first_name.required' => "the_first_name_field_is_required",
            'first_name.min' => "the_first_name_must_be_at_least_4_characters",
            'last_name.required' => "the_last_name_field_is_required",
            'last_name.min' => "the_last_name_must_be_at_least_4_characters",
            'phone.required' => "the_phone_field_is_required",
            'phone.unique' => "this_phone_is_already_take",
            'phone.min' => "the_phone_number_must_be_at_least_8_characters",
            'email.required' => "the_email_field_is_required",
            'email.email' => "the_email_must_be_a_valid_email_address",
            'email.unique' => "this_email_is_already_take",
            'salon_name.required' => "the_salon_name_field_is_required",
            'health_license.required' => "the_health_license_field_is_required",
            'expiration_date.required' => "the_expiration_date_field_is_required",
            'location.required' => "the_location_field_is_required",
            'country_name.required' => "the_country_name_field_is_required",
            'state_name.required' => "the_state_name_field_is_required",
            'city_name.required' => "the_city_name_field_is_required",
            'nationality.required' => "the_nationality_field_is_required",
            'iqama_no.required' => "the_iqama_no_field_is_required",
            'store_registration.required' => "the_store_registration_field_is_required",
            'about_you.required' => "the_about_you_field_is_required",
            'latitude.required' => "the_latitude_field_is_required",
            'longitude.required' => "the_longitude_field_is_required",
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
            $auth->expiration_date = $request->expiration_date;
            $auth->location = $request->location;
            $auth->country_name = $request->country_name;
            $auth->state_name = $request->state_name;
            $auth->city_name = $request->city_name;
            $auth->nationality = $request->nationality;
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
            $destinationPath ="";
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
            $destinationPath ="";
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
                        'message' => "profile_update_successfully",
                    ], 200);
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }
    }


    public function forgotPassword(Request $request)
    {

        $language_code = $request->header('language');
        $validated = [];
        $validated['email'] = "required|email";

        $customMessages = [
            'email.required' =>  "the_email_field_is_required",
            'email.email' =>  "the_email_must_be_a_valid_email_address",
        ];

       $request->validate($validated, $customMessages);


        try {
            $email = $request->email;
            $user = User::where('email', $email)->first();
            if ($user != null || $user != "") {

             $otp = mt_rand(100000, 999999);
                // $otp = 123456;
                $user->otp = $otp;
                $user->update();
                $userId = Crypt::encryptString($user->id);


               $data_email =  Mail::send(
                    ['html' => 'email.forget_password_template'],
                    array(
                        'otp' => $otp,
                        'email' => $email,
                    ),
                    function ($message) use ($email) {
                        $message->from(env('MAIL_USERNAME'), 'Ehjez');
                        $message->to($email);
                        $message->subject("Verify your OTP");
                    }
                );

                $data = new AccountResource($user);
                $user['token'] = null;
                return response()->json(
                    [
                        'data' => $data,
                        'status' => 1,
                        'message' =>  "otp_send_successfully",
                    ], 200);

            } else {

                return response()->json(
                    [
                        'status' => 0,
                        'message' => "email_or_account_not_found",
                    ], 200);

            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }
    }

    public function verifyOTP(Request $request)
    {

         $language_code = $request->header('language');

        $validated = [];
        $validated['user_id'] = "required";
        $validated['otp'] = "required|min:6|max:6";

        $customMessages = [
            'user_id.required' => "the_user_id_field_is_required",
            'otp.required' =>  "the_otp_field_is_required",
            'otp.min' => "the_otp_must_be_exactly_6_digits",
            'otp.max' => "the_otp_must_be_exactly_6_digits",
        ];

       $request->validate($validated, $customMessages);

        try {
            $user = User::find($request->user_id)->first();
            $userotp = User::where('id', $request->user_id)->where('otp', $request->otp)->first();
            if (!empty($userotp)) {
                $user['token'] = null;
                $data = new AccountResource($user);
                return response()->json(
                    [
                        'data' => $data,
                        'status' => 1,
                        'message' => "otp_verify_successfully",
                    ], 200);
            } else {
                return response()->json(
                    [
                        'status' => 0,
                        'message' =>  "otp_not_match",
                    ], 200);

            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }


    public function resetPassword(Request $request)
    {

        $language_code = $request->header('language');
        $validated = [];
        $validated['user_id'] = "required";
        $validated['password'] = "required";
        $validated['confirm_password'] = "same:password|required";

        $customMessages = [
            'user_id.required' => "the_user_id_field_is_required",
            'password.required' => "the_password_field_is_required",
            'confirm_password.same' => "the_confirm_password_must_match_the_password",
            'confirm_password.required' =>  "the_confirm_password_field_is_required",
        ];

       $request->validate($validated, $customMessages);

        try {

            $data = User::where('id', $request['user_id'])->first();
            $data->update(['password' => Hash::make($request['password'])]);

            if (!empty($data)) {
                return response()->json(
                    [
                        'status' => 1,
                        'message' => "password_reset_successfully",
                    ], 200);
            } else {
                return response()->json(
                    [
                        'status' => 0,
                        'message' => "password_not_reset",
                    ], 200);

            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }




}
