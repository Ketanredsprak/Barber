<?php

namespace App\Http\Controllers\Customer;

use App\Models\User;
use App\Models\Pagies;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\Frontend\CustomerRegisterRequest;

class CustomerAccountController extends Controller
{
    //

    public function getLoginPage()
    {

        if (!empty((Auth::user()))) {
            if (Auth::user()->user_type == 4) {
                return redirect('/index');
            }
        }

        $data = Pagies::with("meta_content", "cms_content")->find(5);
        return view('Frontend.Auth.login', compact('data'));
    }

    public function register()
    {
        if (!empty((Auth::user()))) {
            if (Auth::user()->user_type == 4) {
                return redirect('/index');
            }
        }
        $data = Pagies::with("meta_content", "cms_content")->find(6);
        return view('Frontend.Auth.register', compact('data'));
    }

    public function registerSubmit(CustomerRegisterRequest $request)
    {

        try {
            $referral_code = generate_rederal_code();
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->gender = $request->gender;
            $user->country_code = $request->country_code;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->user_type = 4;
            $user->is_approved = "1";
            $user->register_type = 1;
            $user->register_method = 1;
            $user->password = Hash::make($request->password);
            $user->referral_code = $referral_code;
            $user->save();

            if (!empty($user)) {
                return response()->json(['status' => 1, 'message' => __('message.Regiter successfully')]);
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }

    }

    public function forgotPassword()
    {
        $data = Pagies::with("meta_content", "cms_content")->find(7);
        return view('Frontend.Auth.forgot-password', compact('data'));

    }

    public function forgotPasswordSubmit(Request $request)
    {

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
                    ),
                    function ($message) use ($email) {
                        $message->from(env('MAIL_USERNAME'), 'Ehjez');
                        $message->to($email);
                        $message->subject("Verify your OTP");
                    }
                );
                return response()->json(
                    [
                        'status' => 1,
                        'userId' => $userId,
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

    public function verifyOTP($id)
    {
        $data = Pagies::with("meta_content", "cms_content")->find(8);
        $id = Crypt::decryptString($id);
        $user = User::find($id);
        $email = $user->email;
        return view('Frontend.Auth.verify-otp', compact('id', 'email', 'data'));

    }

    public function verifyOtpSubmit(Request $request)
    {
        $validated = [];
        $validated['otp'] = "required|array|min:4";
        $validated['otp.*'] = "required|digits:1";

        $customMessages = [
            'otp.required' => __('error.The otp must be exactly 4 digits.'),
            'otp.array' => __('error.The otp must be exactly 4 digits.'),
            'otp.min' => __('error.The otp must be exactly 4 digits.'),
            'otp.1' => __('error.The otp must be exactly 4 digits.'),
            'otp.2' => __('error.The otp must be exactly 4 digits.'),
            'otp.3' => __('error.The otp must be exactly 4 digits.'),
            'otp.4' => __('error.The otp must be exactly 4 digits.'),
        ];

        $request->validate($validated, $customMessages);

        try {

            $request['otp'] = $request->otp[0] . '' . $request->otp[1] . '' . $request->otp[2] . '' . $request->otp[3];
            $email = User::where('email', $request->email)->first();
            $user = User::where('email', $request->email)->where('otp', $request['otp'])->first();
            if (empty($user)) {
                return response()->json(['status' => 0, 'message' => __('message.Otp verify failed')], 200);
            } else {
                $userId = Crypt::encryptString($user->id);
                return response()->json(
                    ['status' => 1, 'userId' => $userId, 'message' => __('message.Otp verify successfully'),
                    ], 200);
            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    public function resetPassword($id)
    {
        $data = Pagies::with("meta_content", "cms_content")->find(9);
        $id = Crypt::decryptString($id);
        $user = User::find($id);
        $email = $user->email;
        return view('Frontend.Auth.reset-password', compact('id', 'email', 'data'));

    }

    public function resetPasswordSubmit(Request $request)
    {
        $validated = [];
        $validated['password'] = "required";
        $validated['confirm_password'] = "same:password";

        $customMessages = [
            'password.required' => __('error.The password field is required.'),
            'confirm_password.required' => __('error.The confirm password field is required.'),
            'confirm_password.same' => __('error.The confirm password must match the password.'),
        ];

        $request->validate($validated, $customMessages);

        try {

            $user = User::find($request->id);
            $user->password = Hash::make($request->password);
            $user->update();

            return response()->json(['status' => 1, 'message' => __('message.Password changed successfully.')], 200);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }
    }

    public function storeLogin(Request $request)
    {
        $validated['email_or_phone'] = "required";
        $validated['password'] = "required";

        $customMessages = [
            'email_or_phone.required' => __('error.The email or phone field is required'),
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
                $array = Auth::user();
                return response()->json(
                    [
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

    public function myAccount()
    {
        $data = Pagies::with("meta_content", "cms_content")->find(10);
        return view('Frontend.Auth.my_account', compact('data'));
    }

    public function editMyAccount(Request $request)
    {

        $id = Auth::user()->id;
        $validated = [];
        $validated['first_name'] = "required";
        $validated['last_name'] = "required";
        $validated['email'] = "required|email|unique:users,email," . $id;
        $validated['country_code'] = "required|numeric";
        $validated['phone'] = "required|min:9|max:11|unique:users,phone," . $id;
        $validated['gender'] = "required";

        $customMessages = [
            'first_name.required' =>  __('error.The first name field is required.'),
            'last_name.required' => __('error.The last name field is required.'),
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
            $user = User::find(Auth::user()->id);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->country_code = $request->country_code;
            $user->gender = $request->gender;

            if ($request->hasFile('profile_image')) {
                $source = $_FILES['profile_image']['tmp_name'];
                if ($source) {
                    $destinationFolder = public_path('profile_image'); // Specify the destination folder
                    $image = $request->file('profile_image');
                    $filename = time() . '_profile_image.' . $image->getClientOriginalExtension();
                    if (!file_exists($destinationFolder)) {
                        mkdir($destinationFolder, 0777, true);
                    }
                    $destination = $destinationFolder . '/' . $filename;
                    $profile_image = compressImage($source, $destination);
                    $user->profile_image = $filename;
                }
            }

            $user->update();

            return response()->json(
                [
                    'status' => 1,
                    'message' => __('message.Profile update successfully'),
                ], 200);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

        public function  changePassword()
        {
            $data = Pagies::with("meta_content", "cms_content")->find(12);
            return view('Frontend.Auth.change-password', compact('data'));
        }



        public function  changePasswordSubmit(Request $request)
        {
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

}
