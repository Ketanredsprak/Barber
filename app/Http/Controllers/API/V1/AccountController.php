<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use App\Models\Wallet;
use App\Models\ContactUS;
use Illuminate\Http\Request;
use App\Models\WebsiteConfig;
use App\Models\BarberSchedule;
use App\Models\BarberServices;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Http\Resources\Api\AccountResource;
use App\Http\Resources\Api\MyPointResource;
use App\Http\Resources\Api\Barber\BarberAccount;
use App\Http\Resources\Api\Customer\CustomerAccount;

class AccountController extends Controller
{

    public function login(Request $request)
    {

        $validated['email_or_phone'] = "required";
        $validated['password'] = "required";
        $validated['user_type'] = "required";
        $validated['fcm_token'] = "required";

        $customMessages = [
            'email_or_phone.required' => __('error.The email or phone field is required'),
            'password.required' => __('error.The password field is required.'),
            'user_type.required' => __('error.The user type field is required.'),
            'fcm_token.required' => __('error.The fcm token field is required.'),
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

                 // Check user type
                if ($user->user_type != $request->user_type) {
                    auth()->logout();
                    return response()->json(
                        [
                            'message' => __('message.Unauthorized user type.'),
                            'status' => 0,
                        ], 401
                    );
                }


                $user->token = $token;
                $user->fcm_token = $request->fcm_token;
                $user->save();

                if (Auth::user()->user_type == 3) {
                          $check_service = BarberServices::where('barber_id',Auth::user()->id)->first();
                          if(!empty($check_service))
                          {
                                  $array['service_added_or_not_added'] = '1';
                          }
                          else
                          {
                              $array['service_added_or_not_added'] = '0';

                          }



                          $check_schedule = BarberSchedule::where('barber_id',Auth::user()->id)->first();
                          if(!empty($check_schedule))
                          {
                                  $array['schedule_added_or_not_added'] = '1';
                          }
                          else
                          {
                              $array['schedule_added_or_not_added'] = '0';

                          }



                }


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

    //get profile
    public function profile(Request $request)
    {
        try {
            $language_code = $request->header('language');

            $user = User::find(Auth::user()->id);
            $user['barber_schedule'] = BarberSchedule::where('barber_id', $user->id)->first();
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
                    'message' => __('message.Logout successfully'),
                ], 200);
        } else {
            return response()->json(
                [
                    'status' => 0,
                    'message' => __('message.Somthing went wrong'),
                ], 200);
        }

    }

    public function forgotPassword(Request $request)
    {

        $language_code = $request->header('language');
        $validated = [];
        $validated['email'] = "required|email";

        $customMessages = [
            'email.required' => __('error.The email field is required.'),
            'email.email' => __('error.The email must be a valid email address.'),
        ];

        $request->validate($validated, $customMessages);

        try {
            $email = $request->email;
            $user = User::where('email', $email)->first();
            if ($user != null || $user != "") {
                $name = $user->first_name . " " . $user->last_name;

                $otp = mt_rand(1000, 9999);
                // $otp = 123456;
                $user->otp = $otp;
                $user->update();
                $userId = Crypt::encryptString($user->id);

                $data_email = Mail::send(
                    ['html' => 'email.forget_password_template'],
                    array(
                        'otp' => $otp,
                        'email' => $email,
                        'name' => $name,

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
            'otp.required' => __('error.The otp field is required.'),
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
                        'message' => __('message.Otp not match'),
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
        // $validated['gender'] = "required";
        $validated['social_login_type'] = "required";

        $customMessages = [
            'first_name.required' => __('error.The first name field is required.'),
            'first_name.min' => __('error.The first name must be at least 4 characters.'),
            'last_name.required' => __('error.The last name field is required.'),
            'last_name.min' => __('error.The last name must be at least 4 characters.'),
            // 'gender.required' => __('error.The gender field is required.'),
            'email.required' => __('error.The email field is required.'),
            'email.email' => __('error.Please enter a valid email address.'),
            'social_login_type.required' => __('error.The social login type field is required.'),
        ];

        $request->validate($validated, $customMessages);

        try {
            $referral_code = generate_rederal_code();

            $data = User::where('email', $request->email)->first();
            if (empty($data)) {

                $user = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    // 'gender' => $request->gender,
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

            } else {
                if ($data) {
                    $token = $data->createToken('Auth Login')->accessToken;
                    $data['token'] = $token;
                    $data->update();

                    if ($data) {
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

    public function contactUsSubmit(Request $request)
    {
        $validated = [];
        $validated['subject'] = "required";
        $validated['message'] = "required";

        $customMessages = [
            'subject.required' => __('error.The subject field is required.'),
            'message.required' => __('error.The message field is required.'),
        ];

        $request->validate($validated, $customMessages);

        try {

            $user = User::find(Auth::user()->id);


            // for Image
            if ($request->hasFile('contact_file')) {
                $image = $request->file('contact_file');
                $uploaded = time() . '_contact_file.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/contact_file');
                $image->move($destinationPath, $uploaded);
            }
            $contact = new ContactUS();
            $contact->first_name = $user->first_name;
            $contact->last_name = $user->last_name;
            $contact->email = $user->email;
            $contact->subject = $request->subject;
            $contact->note = $request->message;
            $contact->contact_file = $uploaded ?? "";
            $contact->save();

            if ($contact) {
                return response()->json(
                    [
                        'status' => 1,
                        'message' => __('message.Thanks For Contact Us.'),
                    ], 200);
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }


     public function contactUsDetail()
     {
        try {

            $data = WebsiteConfig::find(1);
             if ($data) {
                return response()->json(
                    [
                        'data' => $data,
                        'status' => 1,
                        'message' => __('message.Data get successfully.'),
                    ], 200);
            }

            } catch (Exception $ex) {
                return response()->json(
                    ['success' => 0, 'message' => $ex->getMessage()], 401
                );
            }
     }



     public function myPoints()
     {
            try {

                $id = Auth::user()->id;
                $total_point = get_user_point($id);
                $query = Wallet::where("status",0)->where("user_id",$id);
                $total = $query->count();
                $data = $query->paginate(10);

                if($data)
                {
                    $result = MyPointResource::collection($data);
                    return response()->json(
                        [
                            'data' => $result,
                            'total' => $total,
                            'total_point' => $total_point,
                            'status' => 1,
                            'message' => __('message.Data get successfully.'),
                        ], 200);
                }



            } catch (Exception $ex) {
                return response()->json(
                    ['success' => 0, 'message' => $ex->getMessage()], 401
                );
            }
    }






}
