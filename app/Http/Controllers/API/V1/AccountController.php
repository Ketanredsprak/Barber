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

        $validated['email_or_phone'] = "required";
        $validated['password'] = "required";

        $customMessages = [
            'email_or_phone.required' =>  __('error.The email or phone field is required'),
            'password.required' => __('error.The password field is required.'),
        ];

        $request->validate($validated, $customMessages);

        try {
            // Determine if the input is an email or a phone number
            $loginType = filter_var($request->email_or_phone, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
            $credentials = [
                $loginType => $request->email_or_phone,
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

                if (Auth::user()->user_type == 3) {
                    $data = new BarberAccount($array);
                } else {
                    $data = new CustomerAccount($array);
                }

                return response()->json(
                    [
                        'data' => $data,
                        'status' => 1,
                        'message' => __('message.Login successfully'),
                    ], 200);
            } else {
                return response()->json(
                    [
                        'message' => __('message.Incorrect Email/Phone Number and Password.'),
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
                'is_approved' => "1",
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
                        'message' => __('message.Register successfully'),
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

        $customMessages = [
        'first_name.required' =>  __('error.The first name field is required.'),
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
        ];

        $request->validate($validated,$customMessages);
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
                'health_license_expiration_date' => $request->health_license_expiration_date,
                'store_registration_expiration_date' => $request->store_registration_expiration_date,
                'salon_name' => $request->salon_name,
                'location' => $request->location,
                'country_name' => $request->country_name,
                'state_name' => $request->state_name,
                'city_name' => $request->city_name,
                'about_you' => $request->about_you,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'user_type' => 3,
                'is_approved' => "1",
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
                        'message' => __('message.Register successfully'),
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
                        'message' => __('message.Profile get successfully'),
                    ], 200);
            } else {
                return response()->json(
                    [
                        'message' => __('message.Profile not found'),
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
            'current_password.required' => __('error.The current password field is required.'),
            'password.required' => __('error.The password field is required.'),
            'confirm_password.same' => __('error.The confirm password must match the password.'),
            'confirm_password.required' => __('error.The confirm password field is required.'),
        ];

        $request->validate($validated, $customMessages);

        try {
            $auth = User::find($user_id);

            // The passwords matches
            if (!Hash::check($request->current_password, $auth->password)) {
                return response()->json(
                    [
                        'status' => 0,
                        'message' => __('error.Current password is invalid.'),
                    ], 200);
            }

            // Current password and new password same
            if (strcmp($request->current_password, $request->password) == 0) {
                return response()->json(
                    [
                        'status' => 0,
                        'message' => __('error.New password cannot be same as your current password.'),
                    ], 200);
            }

            $auth->password = Hash::make($request->password);
            $auth->update();
            return response()->json(
                [
                    'status' => 1,
                    'message' => __('message.Password changed successfully.'),
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
                    'message' =>  __('message.Logout successfully'),
                ], 200);
        } else {
            return response()->json(
                [
                    'status' => 0,
                    'message' => __('message.Somthing went wrong'),
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
        $validated['phone'] = "required|min:9|max:11|unique:users,phone," . $id;
        $validated['gender'] = "required";
        $validated['country_name'] = "required";
        $validated['state_name'] = "required";
        $validated['city_name'] = "required";
        $validated['profile_image'] = "required|file|mimes:jpeg,png,jpg";

        $customMessages = [
            'first_name.required' =>  __('error.The first name field is required.'),
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
                        'message' => __('message.Profile update successfully'),
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
        $validated['profile_image'] = "required|file|mimes:jpeg,png,jpg";
        $validated['salon_name'] = "required";
        $validated['health_license'] = "required";
        $validated['health_license_expiration_date'] = "required|date";
        $validated['store_registration_expiration_date'] = "required|date";
        $validated['location'] = "required";
        $validated['country_name'] = "required";
        $validated['state_name'] = "required";
        $validated['city_name'] = "required";
        $validated['nationality'] = "required";
        $validated['iqama_no'] = "required:numeric";
        $validated['about_you'] = "required";
        $validated['latitude'] = "required";
        $validated['longitude'] = "required";
        $validated['store_registration'] = "required";

        $customMessages = [
            'first_name.required' =>  __('error.The first name field is required.'),
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
                        'message' => __('message.Profile update successfully'),
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
            'email.required' => __('error.The email field is required.'),
            'email.email' =>  __('error.The email must be a valid email address.'),
        ];

       $request->validate($validated, $customMessages);


        try {
            $email = $request->email;
            $user = User::where('email', $email)->first();
            if ($user != null || $user != "") {

             $otp = mt_rand(1000, 9999);
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
                        'message' => __('message.Otp send successfully'),
                    ], 200);

            } else {

                return response()->json(
                    [
                        'status' => 0,
                        'message' => __('message.Email or account not found'),
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
        $validated['otp'] = "required|min:4|max:4";

        $customMessages = [
            'user_id.required' => __('error.The user id field is required.'),
            'otp.required' =>  __('error.The otp field is required.'),
            'otp.min' => __('error.The otp must be exactly 4 digits.'),
            'otp.max' => __('error.The otp must be exactly 4 digits.'),
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
                        'message' => __('message.Otp verify successfully'),
                    ], 200);
            } else {
                return response()->json(
                    [
                        'status' => 0,
                        'message' =>  __('message.Otp not match'),
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
            'user_id.required' => __('error.The user id field is required.'),
            'password.required' => __('error.The password field is required.'),
            'confirm_password.same' => __('error.The confirm password must match the password.'),
            'confirm_password.required' => __('error.The confirm password field is required.'),
        ];

       $request->validate($validated, $customMessages);

        try {

            $data = User::where('id', $request['user_id'])->first();
            $data->update(['password' => Hash::make($request['password'])]);

            if (!empty($data)) {
                return response()->json(
                    [
                        'status' => 1,
                        'message' => __('message.Password reset successfully'),
                    ], 200);
            } else {
                return response()->json(
                    [
                        'status' => 0,
                        'message' => __('message.Password not reset'),
                    ], 200);

            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }


    public function socialLogin(Request $request)
    {
        $validated = [];
        $validated['first_name'] = "required|min:4";
        $validated['last_name'] = "required|min:4";
        $validated['email'] = "required|email";
        $validated['gender'] = "required";
        $validated['social_login_type'] = "required";


        $customMessages = [
            'first_name.required' =>  __('error.The first name field is required.'),
            'first_name.min' => __('error.The first name must be at least 4 characters.'),
            'last_name.required' => __('error.The last name field is required.'),
            'last_name.min' => __('error.The last name must be at least 4 characters.'),
            'gender.required' => __('error.The gender field is required.'),
            'email.required' => __('error.The email field is required.'),
            'email.email' => __('error.Please enter a valid email address.'),
            'social_login_type.required' =>  __('error.The social login type field is required.'),
        ];

        $request->validate($validated, $customMessages);

        try {
                    $referral_code = generate_rederal_code();

                    $data = User::where('email',$request->email)->first();
                    if(empty($data)){

                        $user = User::create([
                            'first_name' => $request->first_name,
                            'last_name' => $request->last_name,
                            'email' => $request->email,
                            'gender' => $request->gender,
                            'user_type' => 4,
                            'is_approved' => "1",
                            'register_type' => 1,
                            'register_method' => $request->social_login_type,
                            'password' => Hash::make("123456"),
                            'referral_code' => $referral_code ?? '',
                            'token' => '',
                        ]);

                        $credentials = [
                            'email' => $request->email,
                            'password' => "123456",
                        ];

                        // Attempt to authenticate the user
                        if (auth()->attempt($credentials)) {
                            $token = auth()->user()->createToken('checking')->accessToken;
                            $array = Auth::user();
                            $array['token'] = $token;
                            $user = auth()->user();
                            $user->token = $token;
                            $user->save();

                            if (Auth::user()->user_type == 4) {
                               $data = new CustomerAccount($array);
                               return response()->json(
                                        [
                                            'data' => $data,
                                            'status' => 1,
                                            'message' => __('message.Login successfully'),
                                        ], 200);

                            }
                        }


                     }
                     else
                     {
                        if ($data) {
                            $token = $data->createToken('Auth Login')->accessToken;
                            $data['token'] = $token;
                            $data->update();

                            if ($data)
                            {
                                $user = new CustomerAccount($data);
                                return response()->json(
                                         [
                                             'data' => $user,
                                             'status' => 1,
                                             'message' => __('message.Login successfully'),
                                         ], 200);

                             }
                        }

                    }




        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }



    }



    public function language()
    {
        $message = __('message.welcome');
        return response()->json(['message' => $message]);
    }




}
