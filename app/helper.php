<?php

use App\Models\BarberRating;
use App\Models\Booking;
use App\Models\Countries;
use App\Models\CountryCode;
use App\Models\LoyalClient;
use App\Models\Module;
use App\Models\Notification;
use App\Models\PointSystem;
use App\Models\Services;
use App\Models\Subscription;
use App\Models\SubscriptionPermission;
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\UserSubscriptionPermission;
use App\Models\Wallet;
use App\Models\WebsiteConfig;
use Carbon\Carbon;
use Google\Auth\CredentialsLoader;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;

if (!function_exists('static_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function static_asset($path, $secure = null)
    {
        return app('url')->asset('public/' . $path, $secure);
    }
}

//get getuser
if (!function_exists('getuser')) {
    function getuser($id)
    {
        $User = User::where("id", $id)->get();
        return $User;
    }
}

if (!function_exists('getcountries')) {
    function getcountries()
    {
        $countrys = Countries::where("is_delete", 0)->where('status', 1)->get();
        return $countrys;
    }
}

if (!function_exists('getmodules')) {
    function getmodules()
    {
        $module = Module::get();
        return $module;
    }
}

if (!function_exists('getPermission')) {
    function getPermission()
    {
        $permission_group = Permission::get()->groupBy('module_name');
        return $permission_group;
    }
}

//get compressImage
if (!function_exists('compressImage')) {
    function compressImage($source, $destination)
    {
        // Get image info
        //for $quality change 1 -100
        $quality = 60;
        $imgInfo = getimagesize($source);
        $mime = $imgInfo['mime'];

        // Check image size
        $fileSize = filesize($source); // in bytes
        $quality = ($fileSize > 1024 * 1024) ? $quality : 100; // Check if size is greater than 1 MB

        // Create a new image from file
        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($source);
                break;
            default:
                $image = imagecreatefromjpeg($source);
        }

        // Save image
        imagejpeg($image, $destination, $quality);

        // Return compressed image
        return $destination;
    }

}

//get raferal code
if (!function_exists('generate_rederal_code')) {
    function generate_rederal_code()
    {
        $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        return $referral_code = substr(str_shuffle($str_result), 0, 10);
    }
}

if (!function_exists('getbarbers')) {
    function getbarbers()
    {
        $barbers = User::where('user_type', 3)->where('is_approved', "2")->get();
        return $barbers;
    }
}

if (!function_exists('getServices')) {
    function getServices()
    {
        $services = Services::where('parent_id', 0)->where('status', 1)->get();
        return $services;
    }
}

if (!function_exists('getWebsiteConfig')) {
    function getWebsiteConfig()
    {
        $data = WebsiteConfig::first();
        return $data;
    }
}

if (!function_exists('getauthdata')) {
    function getauthdata()
    {
        $profile_data = Auth::user();
        return $profile_data;
    }
}

if (!function_exists('country_code')) {
    function country_code()
    {
        $phonecodes = CountryCode::get();
        return $phonecodes;
    }
}

if (!function_exists('getSubscription')) {
    function getSubscription($subscription_type)
    {
        $data = Subscription::where('subscription_type', $subscription_type)->where('status', 1)->where('is_delete', 0)->get();

        // Encrypt the 'id' field for each subscription
        foreach ($data as $subscription) {
            $subscription['encrypt_id'] = Crypt::encryptString($subscription->id);
        }

        return $data;
    }
}

if (!function_exists('getSubServices')) {
    function getSubServices()
    {
        $services = Services::where('parent_id', '!=', 0)->where('status', 1)->get();
        return $services;
    }
}

if (!function_exists('getFirstTenWords')) {
    function getFirstTenWords($string)
    {
        // Split the string into an array of words
        $words = preg_split('/\s+/', $string);

        // Check if there are more than 10 words
        $moreThanTenWords = count($words) > 10;

        // Get the first 10 words
        $firstTenWords = array_slice($words, 0, 10);

        // Join the words back into a string
        $result = implode(' ', $firstTenWords);

        // Add "......." if there are more than 10 words
        if ($moreThanTenWords) {
            $result .= ' .......';
        }

        return $result;
    }
}

if (!function_exists('setUserPermissionBaseOnSubscription')) {
    function setUserPermissionBaseOnSubscription($user_id, $subscription_id)
    {

        //checking old subscription
        $data_old_subs = UserSubscription::where('user_id', $user_id)->where('status', 'active')->get();
        foreach ($data_old_subs as $subscription_ex) {
            $subscription_cancelled = UserSubscription::find($subscription_ex->id);
            $subscription_cancelled->status = "inactive";
            $subscription_cancelled->update();
        }
        //checking old subscription

        //assing basic subscription
        $currentDateTime = Carbon::now();
        $currentDate = $currentDateTime->format('Y-m-d H:i:s');
        $subscription = Subscription::find($subscription_id);
        $endDate = $currentDateTime->addDays($subscription->duration_in_months * 30);
        $subscription_end_date = $endDate->format('Y-m-d H:i:s');
        $user_subscription = new UserSubscription();
        $user_subscription->user_id = $user_id;
        $user_subscription->transaction_id = "1";
        $user_subscription->subscription_id = $subscription->id;
        $user_subscription->subscription_duration = $subscription->duration_in_months * 30;
        $user_subscription->status = "active";
        $user_subscription->availble_booking = $subscription->number_of_booking ?? 0;
        $user_subscription->start_date_time = $currentDate;
        $user_subscription->end_date_time = $subscription_end_date;
        $user_subscription->save();
        //assing basic subscription

        //assing basic  permission to user subscription
        //
        if ($subscription->id == 1) {
            $input_value = "basic_input_value";
        }
        if ($subscription->id == 2) {
            $input_value = "silver_input_value";
        }
        if ($subscription->id == 3) {
            $input_value = "bronz_input_value";
        }
        if ($subscription->id == 4) {
            $input_value = "gold_input_value";
        }
        if ($subscription->id == 5) {
            $input_value = "basic_input_value";
        }
        if ($subscription->id == 6) {
            $input_value = "silver_input_value";
        }
        if ($subscription->id == 7) {
            $input_value = "bronz_input_value";
        }
        if ($subscription->id == 8) {
            $input_value = "gold_input_value";
        }

        $all_permission = SubscriptionPermission::whereJsonContains('subscription_array', $subscription->id)->get();
        if ($all_permission) {
            foreach ($all_permission as $permission) {
                $UserSubscriptionPermission = new UserSubscriptionPermission();
                $UserSubscriptionPermission->user_id = $user_id;
                $UserSubscriptionPermission->subscription_id = $subscription->id;
                $UserSubscriptionPermission->permission_id = $permission->id;
                $UserSubscriptionPermission->permission_name = $permission->permission_name;
                $UserSubscriptionPermission->is_input_box = $permission->is_input_box;
                $UserSubscriptionPermission->input_value = $permission->$input_value;
                $UserSubscriptionPermission->status = "active";
                $UserSubscriptionPermission->save();
            }
        }

        return "success";

        //assing basic  permission to user subscription
    }
}

if (!function_exists('getCurrentSubscription')) {
    function getCurrentSubscription($user_id)
    {
        $data = UserSubscription::where("user_id", $user_id)->where('status', "active")->first();
        if (!empty($data)) {
            $data->encrypt_id = Crypt::encryptString(@$data->id);
        }
        return $data;
    }
}

if (!function_exists('checkUserType')) {
    function checkUserType()
    {
        if (Auth::check()) {
            $userType = Auth::user()->user_type;
            if ($userType == 1 || $userType == 2) {
                return redirect('admin/dashboard');
            } elseif ($userType == 3) {
                return redirect('404');
            } else {

            }
        }
    }
}

if (!function_exists('decrypt_string')) {
    function decrypt_string($encryptedString)
    {
        return $encryptedString;
    }
}

if (!function_exists('sendEmail')) {
    function sendEmail($user_id, $user_type, $booking_id)
    {

        $data = User::find($user_id);
        $name = $data->first_name . ' ' . $data->last_name;
        $email = $data->email;
        $phone = $data->phone;

        $admin_data = User::where('user_type', 1)->first();
        $admin_email = $admin_data->email;

        //customer
        if (!empty($email)) {
            if ($user_type == "customer") {

                //customer mail
                Mail::send(
                    ['html' => 'email.customer-register-template'],
                    array(
                        'name' => $name,
                    ),
                    function ($message) use ($email) {
                        $message->from(env('MAIL_USERNAME'), 'Ehjez');
                        $message->to($email);
                        $message->subject("Thank For Joinning..");
                    }
                );

                //customer register mail to admin

                Mail::send(
                    ['html' => 'email.customer-register-mail-to-admin-template'],
                    array(
                        'name' => $name,
                        'email' => $email,
                        'phone' => $phone,
                    ),
                    function ($message) use ($admin_email) {
                        $message->from(env('MAIL_USERNAME'), 'Ehjez');
                        $message->to($admin_email);
                        $message->subject("New Customer Registered..");
                    }
                );

            }
        }

        // barber
        if (!empty($email)) {
            if ($user_type == "barber") {

                //barber mail
                $data_email = Mail::send(
                    ['html' => 'email.barber-register-template'],
                    array(
                        'name' => $name,
                    ),
                    function ($message) use ($email) {
                        $message->from(env('MAIL_USERNAME'), 'Ehjez');
                        $message->to($email);
                        $message->subject("Thank For Joinning..");
                    }
                );

                $data_email_1 = Mail::send(
                    ['html' => 'email.barber-register-mail-to-admin-template'],
                    array(
                        'name' => $name,
                        'email' => $email,
                        'phone' => $phone,
                    ),
                    function ($message) use ($admin_email) {
                        $message->from(env('MAIL_USERNAME'), 'Ehjez');
                        $message->to($admin_email);
                        $message->subject("New barber Registered..");
                    }
                );

                return true;

            }
        }

        if (!empty($email)) {
            // customer suspend  by admin mail send to customer
            if ($user_type == "account-suspend") {

                //barber mail
                $data_email = Mail::send(
                    ['html' => 'email.account-suspend-email-template'],
                    array(
                        'name' => $name,
                        'admin_email' => $admin_email,
                    ),
                    function ($message) use ($email) {
                        $message->from(env('MAIL_USERNAME'), 'Ehjez');
                        $message->to($email);
                        $message->subject("Your Account is suspend..");
                    }
                );
            }
        }

        if (!empty($email)) {
            // customer approved by admin mail send to customer
            if ($user_type == "account-approved") {

                //barber mail
                $data_email = Mail::send(
                    ['html' => 'email.account-approved-email-template'],
                    array(
                        'name' => $name,
                        'admin_email' => $admin_email,
                    ),
                    function ($message) use ($email) {
                        $message->from(env('MAIL_USERNAME'), 'Ehjez');
                        $message->to($email);
                        $message->subject("Your Account is approved..");
                    }
                );
            }
        }

        // booking main to  customer
        if ($user_type == "booking") {

            $booking_data = Booking::with('barber_detail', 'customer_detail', 'booking_service_detailss.main_service', 'booking_service_detailss.sub_service')->find($booking_id);
            $barber_email = $booking_data->barber_detail->email;
            $customer_email = $booking_data->customer_detail->email;
            //mail customer

            // Path to the file you want to attach
            $filePath = public_path('booking-policy.txt'); // Example file path

            if (!empty($customer_email)) {
                $data_email = Mail::send(
                    ['html' => 'email.customer-booking-info-to-customer-template'],
                    array(
                        'name' => $name,
                        'booking' => $booking_data,
                    ),
                    function ($message) use ($customer_email,$filePath) {
                        $message->from(env('MAIL_USERNAME'), 'Ehjez');
                        $message->to($customer_email);
                        $message->subject("New Appointment..");

                        // Attach the file
                        $message->attach($filePath, [
                            'as' => 'booking-policy.txt', // Optional custom file name for the attachment
                            'mime' => 'application/txt', // MIME type of the file
                        ]);

                    }
                );
            }

            //barber mail
            if (!empty($barber_email)) {
                $data_email = Mail::send(
                    ['html' => 'email.barber-booking-info-to-barber-template'],
                    array(
                        'name' => $name,
                        'booking' => $booking_data,
                    ),
                    function ($message) use ($barber_email) {
                        $message->from(env('MAIL_USERNAME'), 'Ehjez');
                        $message->to($barber_email);
                        $message->subject("New Appointment..");
                    }
                );
            }

        }

        if ($user_type == "barber-booking-status-chnage") {

            $booking_data = Booking::with('barber_detail', 'customer_detail', 'booking_service_detailss.main_service', 'booking_service_detailss.sub_service')->find($booking_id);
            $customer_email = $booking_data->customer_detail->email;

            //mail customer
            if (!empty($customer_email)) {
                $data_email = Mail::send(
                    ['html' => 'email.customer-booking-status-change-to-customer-template'],
                    array(
                        'booking' => $booking_data,
                    ),
                    function ($message) use ($customer_email) {
                        $message->from(env('MAIL_USERNAME'), 'Ehjez');
                        $message->to($customer_email);
                        $message->subject("Barber responde on Appointment..");
                    }
                );
            }

        }

        if ($user_type == "barber-send-proposal-to-customer") {

            $booking_data = Booking::with('barber_detail', 'customer_detail', 'barber_proposal')->find($booking_id);

            $customer_email = $booking_data->customer_detail->email;

            if (!empty($customer_email)) {
                if ($booking_data->barber_proposal->slots) {
                    // Loop through the array

                    foreach ($booking_data->barber_proposal->slots as $index => $slot) {
                        // Split the time range by " - "
                        list($start, $end) = explode('-', $slot);

                        // Set the first start time
                        if ($index === 0) {
                            $startTime = $start;
                        }

                        // Always update the last end time
                        $endTime = $end;
                    }

                    $booking_data->barber_proposal->start_time = $startTime;
                    $booking_data->barber_proposal->end_time = $endTime;
                }

                //mail customer
                $data_email = Mail::send(
                    ['html' => 'email.barber-proposal-for-booking-to-customer-template'],
                    array(
                        'booking' => $booking_data,
                    ),
                    function ($message) use ($customer_email) {
                        $message->from(env('MAIL_USERNAME'), 'Ehjez');
                        $message->to($customer_email);
                        $message->subject("Barber Propersal For JoinWait List Request..");
                    }
                );
            }

        }

        if ($user_type == "customer-chnage-status-for-barber-proposal") {

            $booking_data = Booking::with('barber_detail', 'customer_detail', 'booking_service_detailss.main_service', 'booking_service_detailss.sub_service')->find($booking_id);
            $barber_email = $booking_data->barber_detail->email;

            //mail customer
            if (!empty($barber_email)) {
                $data_email = Mail::send(
                    ['html' => 'email.customer-chnage-status-for-barber-proposal-to-barber-template'],
                    array(
                        'booking' => $booking_data,
                    ),
                    function ($message) use ($barber_email) {
                        $message->from(env('MAIL_USERNAME'), 'Ehjez');
                        $message->to($barber_email);
                        $message->subject("Customer respond on your Appointment Proposal..");
                    }
                );
            }

        }

        if ($user_type == "customer-rating-to-barber") {

            $booking_data = Booking::with('barber_detail', 'customer_detail', 'booking_service_detailss.main_service', 'booking_service_detailss.sub_service')->find($booking_id);
            $barber_email = $booking_data->barber_detail->email;
            $rating = BarberRating::where('booking_id', $booking_data->id)->where('user_id', $booking_data->user_id)->first();
            if (!empty($barber_email)) {
                //mail customer
                if ($rating != "") {
                    $data_email = Mail::send(
                        ['html' => 'email.customer-rating-to-barber-to-barber-template'],
                        array(
                            'booking' => $booking_data,
                            'rating' => $rating,
                        ),
                        function ($message) use ($barber_email) {
                            $message->from(env('MAIL_USERNAME'), 'Ehjez');
                            $message->to($barber_email);
                            $message->subject("Rating Received..");
                        }
                    );
                }
            }

        }

        //

    }

    if (!function_exists('finished_booking')) {
        function finished_booking($booking_id)
        {
            $booking_data = Booking::with('barber_detail', 'customer_detail', 'booking_service_detailss.main_service', 'booking_service_detailss.sub_service')->find($booking_id);

            $customer_email = $booking_data->customer_detail->email;
            $barber_email = $booking_data->barber_detail->email;

            //customer mail
            $data_email = Mail::send(
                ['html' => 'email.booking-finished-email-to-customer-templete'],
                array(
                    'booking_data' => $booking_data,
                ),
                function ($message) use ($customer_email) {
                    $message->from(env('MAIL_USERNAME'), 'Ehjez');
                    $message->to($customer_email);
                    $message->subject("Your Appointment is finished..");
                }
            );

            //barber mail
            $data_email_barber = Mail::send(
                ['html' => 'email.booking-finished-email-to-barber-templete'],
                array(
                    'booking_data' => $booking_data,
                ),
                function ($message) use ($barber_email) {
                    $message->from(env('MAIL_USERNAME'), 'Ehjez');
                    $message->to($barber_email);
                    $message->subject("Your Appointment is finished..");
                }
            );

        }
    }

    if (!function_exists('resechedule_booking')) {
        function resechedule_booking($old_booking_id, $new_booking_id)
        {

            $old_booking_data = Booking::with('barber_detail', 'customer_detail')->find($old_booking_id);
            $new_booking_data = Booking::find($new_booking_id);

            $customer_email = $old_booking_data->customer_detail->email;
            $barber_email = $old_booking_data->barber_detail->email;

            //customer mail
            $data_email = Mail::send(
                ['html' => 'email.booking-reschedule-from-customer-info-to-customer-template'],
                array(
                    'old_booking_data' => $old_booking_data,
                    'new_booking_data' => $new_booking_data,
                ),
                function ($message) use ($customer_email) {
                    $message->from(env('MAIL_USERNAME'), 'Ehjez');
                    $message->to($customer_email);
                    $message->subject("Your Appointment Resechedule Succesfully..");
                }
            );

            //barber mail
            $data_email_barber = Mail::send(
                ['html' => 'email.booking-reschedule-from-customer-info-to-barber-template'],
                array(
                    'old_booking_data' => $old_booking_data,
                    'new_booking_data' => $new_booking_data,
                ),
                function ($message) use ($barber_email) {
                    $message->from(env('MAIL_USERNAME'), 'Ehjez');
                    $message->to($barber_email);
                    $message->subject("Your Appointment Resechedule By Customer..");
                }
            );

        }
    }

    if (!function_exists('cancel_booking')) {
        function cancel_booking($booking_id)
        {

            $booking_data = Booking::with('customer_detail', 'barber_detail')->find($booking_id);

            $customer_email = $booking_data->customer_detail->email;
            if ($customer_email) {
                $data_email_barber = Mail::send(
                    ['html' => 'email.cancel-booking-when-barber-not-respond-mail-to-customer-template'],
                    array(
                        'booking_data' => $booking_data,
                    ),
                    function ($message) use ($customer_email) {
                        $message->from(env('MAIL_USERNAME'), 'Ehjez');
                        $message->to($customer_email);
                        $message->subject("Your Appointment Cancel due to a barber busy schedule..");
                    }
                );
            }
        }
    }

    if (!function_exists('chat_unique_key')) {
        function chat_unique_key()
        {
            $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            return $referral_code = substr(str_shuffle($str_result), 0, 10);
        }
    }

    if (!function_exists('creditPoint')) {
        function creditPoint($credit_type, $user_id)
        {
            $lastDateOfMonth = Carbon::now()->endOfMonth()->toDateString();
            $point = PointSystem::first();
            if ($credit_type == "booking") {
                $data = new Wallet();
                $data->user_id = $user_id;
                $data->amount = $point->per_booking_points;
                $data->status = 0;
                $data->expiry_date = $lastDateOfMonth;
                $data->type = "credit";
                $data->credit_type = "booking";
                $data->save();
            }

            // barber active rafer to customer
            if ($credit_type == "active_referral") {

                $booking = Booking::where('user_id', $user_id)->count();
                if ($booking == 1) {

                    $user = User::find($user_id);
                    $barber = User::where('referral_code', $user->submit_referral_code)->first();
                    // booking first time
                    if ($barber != "") {
                        $data = new Wallet();
                        $data->user_id = $barber->id;
                        $data->amount = $point->per_active_referral_points;
                        $data->status = 0;
                        $data->expiry_date = $lastDateOfMonth;
                        $data->type = "credit";
                        $data->credit_type = "referral";
                        $data->save();
                    }
                }

            }

            return true;
        }
    }

    // get point point
    if (!function_exists('get_user_point')) {
        function get_user_point($user_id)
        {

            $credits = Wallet::where('user_id', $user_id)
                ->where('type', 'credit')
                ->where('status', 0)
                ->sum('amount');

            $debits = Wallet::where('user_id', $user_id)
                ->where('type', 'debit')
                ->where('status', 0)
                ->sum('amount');

            $balance = $credits - $debits;
            return $balance;

        }
    }

    if (!function_exists('loyalClient')) {
        function loyalClient($user_id, $barber_id)
        {
            $data = LoyalClient::where('user_id', $user_id)->where('barber_id', $barber_id)->first();
            if (empty($data)) {
                //checking booking
                $checking = Booking::where('user_id', $user_id)->where('barber_id', $barber_id)->count();
                if ($checking >= 3) {
                    $create_loyal_client = new LoyalClient();
                    $create_loyal_client->user_id = $user_id;
                    $create_loyal_client->barber_id = $barber_id;
                    $create_loyal_client->save();
                }
            }

            return true;
        }
    }

// =====================================================

    function getAccessToken()
    {
        // $serviceAccountPath = config_path('firebase_credentials.json');
        // $scopes = ['https://www.googleapis.com/auth/cloud-platform'];
        // $credentials = CredentialsLoader::makeCredentials($scopes, json_decode(file_get_contents($serviceAccountPath), true));
        // $httpHandler = HttpHandlerFactory::build(new Client());
        // $credentials->fetchAuthToken($httpHandler);
        // return $credentials->getLastReceivedToken()['access_token'];

        $serviceAccountPath = config_path('firebase_credentials.json');
        $scopes = ['https://www.googleapis.com/auth/cloud-platform'];
        $credentials = CredentialsLoader::makeCredentials($scopes, json_decode(file_get_contents($serviceAccountPath), true));

        // Create a custom HTTP handler with SSL verification disabled
        $httpHandler = function ($request) {
            $client = new Client([
                'verify' => false, // Disable SSL verification
            ]);
            return $client->send($request);
        };

        $credentials->fetchAuthToken($httpHandler);
        return $credentials->getLastReceivedToken()['access_token'];
    }

    function sendPushNotification($user_id, $notificationType, $title, $description)
    {
        $availble_booking = "";
        if ($notificationType == "remaining-booking") {
            $user_sub = UserSubscription::where("user_id", $user_id)->where('status', 'active')->first();
            $availble_booking = $user_sub->availble_booking;
        }

        // Retrieve access token
        $SERVER_API_KEY = getAccessToken();
        if (!$SERVER_API_KEY) {
            throw new Exception('Failed to obtain access token.');
        }
        // dd($SERVER_API_KEY);
        $PROJECT_KEY = env('FCM_PROJECT_KEY');
        try {
            $userInfo = User::find($user_id);
            $deviceType = $userInfo->device_type;
            $deviceToken = $userInfo->fcm_token;
            $notifications = new Notification();
            $notifications->user_id = $user_id;
            $notifications->device_type = $userInfo->device_type;
            $notifications->notification_type = $notificationType;
            $notifications->notification_data = $availble_booking ?? "";
            $notifications->notification_message = $description;
            $notifications->is_read = 0;
            $notifications->save();
            // Prepare the data for the notification
            $notificationData = [
                "message" => [
                    "token" => $deviceToken,
                    "notification" => [
                        "title" => $title,
                        "body" => $description,
                    ],
                    "data" => [
                        "title" => $title,
                        "body" =>  $description,
                        "notification_type" => $notificationType,
                        "description" =>  $description,
                        // "sender_id" =>  $data->sender_id,
                        // "receiver_id" => $data->receiver_id,
                        // "custom_message_type" =>  $data->message_type,
                        // "message_file" =>   URL::to('/public') . '/file/' .$data->file,
                        // "message_custom" =>  $data->message,
                        // "chat_unique_key" => $data->chat_unique_key,
                        // "is_read" => $data->is_read,

                    ],
                ],

            ];

            $dataString = json_encode($notificationData);
            $header = array('Content-Type: application/json', "Authorization: Bearer $SERVER_API_KEY");
            // Initialize cURL session
            $ch = curl_init("https://fcm.googleapis.com/v1/projects/" . $PROJECT_KEY . "/messages:send");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

            // Execute cURL request and get the response
            $response = curl_exec($ch);

            // Check for cURL errors
            if (curl_errno($ch)) {
                throw new \Exception(curl_error($ch));
            }

            // Close cURL session
            curl_close($ch);
            // Return success message
            return true;
            // } else {
            //     return false;
            // }
        } catch (\Exception $e) {
            // Return error message
            return $e->getMessage();
        }
    }

// =====================================================

    if (!function_exists('calculateDistance')) {
        function calculateDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
        {

            $earthRadiusKm = 6371;

            $latFrom = deg2rad($latitudeFrom);
            $lonFrom = deg2rad($longitudeFrom);
            $latTo = deg2rad($latitudeTo);
            $lonTo = deg2rad($longitudeTo);

            $latDelta = $latTo - $latFrom;
            $lonDelta = $lonTo - $lonFrom;

            $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

            return $angle * $earthRadiusKm;
        }
    }

}

if (!function_exists('getNotificationCount')) {
    function getNotificationCount()
    {
        $numbeof_notification = Notification::where("user_id", Auth::user()->id)->where('is_read', 0)->count();
        $data_list = Notification::where("user_id", Auth::user()->id)->where('is_read', 0)->get();
        $ids = $data_list->pluck('id')->toArray(); // Extract IDs from the list
        // foreach ($ids as $id) {
        //     $notification = Notification::where('id', $id)->first();
        //     $notification->is_read = "1";
        //     $notification->save();
        // }
        return $numbeof_notification ?? 0;
    }
}

if (!function_exists('checkingUserAccount')) {
    function checkingUserAccount($user_id)
    {
        // Retrieve the user from the 'users' table with the specified conditions
        $user = \App\Models\User::where('id', $user_id)
            ->where('is_approved', "2")
            ->where('is_delete', 0)
            ->first();

        // If the user does not exist or does not match the conditions
        if (!$user) {
            // Log out the user
            Auth::logout();
            // Redirect to the login page
            return redirect()->route('admin/login')->send();
        }

        // If the user exists and matches the conditions, return true
        return true;
    }
}

if (!function_exists('checkUserStatus')) {
    function checkUserStatus($user_id)
    {

        $user = User::find($user_id);

        $status = 0;
        $message = "";

        if (!$user) {
            $message = __('message.Account not found');
            $status = 1;
        }

        if ($user->is_approved == 0) {
            $message = __('message.Waiting for admin approved account');
            $status = 1;
        }

        if ($user->is_approved == 1) {
            $message = __('message.Waiting for admin approved account');
            $status = 1;
        }

        if ($user->is_approved == 3) {
            $message = __('message.Temporary your account suspended please contact to admin');
            $status = 1;
        }

        if ($user->is_delete == 1) {
            $message = __('message.Account not found');
            $status = 1;
        }

        // Add any additional status checks as needed
        return ['status' => $status, 'message' => $message];

    }



    function sendPushNotificationChatNotification($user_id, $notificationType, $title, $description, $data)
    {

        // Retrieve access token
        $SERVER_API_KEY = getAccessToken();
        if (!$SERVER_API_KEY) {
            throw new Exception('Failed to obtain access token.');
        }
        // dd($SERVER_API_KEY);
        $PROJECT_KEY = env('FCM_PROJECT_KEY');
        try {
            $userInfo = User::find($user_id);
            $deviceType = $userInfo->device_type;
            $deviceToken = $userInfo->fcm_token;
            $notifications = new Notification();
            $notifications->user_id = $user_id;
            $notifications->device_type = $userInfo->device_type;
            $notifications->notification_type = $notificationType;
            $notifications->notification_data = $data->message ?? "";
            $notifications->notification_message = $description;
            $notifications->is_read = 0;
            $notifications->save();
            // Prepare the data for the notification
            $notificationData = [
                "message" => [
                    "token" => $deviceToken,
                    "notification" => [
                        "title" => $title,
                        "body" => $description,
                    ],
                    "data" => [
                        "title" => $title ?? "",
                        "body" =>  $description ?? "",
                        "notification_type" => $notificationType ?? "",
                        "description" =>  $description ?? "",
                        "sender_id" =>  strval($data->sender_id) ?? "",
                        "receiver_id" => strval($data->receiver_id) ?? "",
                        "custom_message_type" =>  strval($data->message_type) ?? "",
                        "message_file" =>   URL::to('/public') . '/file/' .strval($data->file),
                        "message_custom" =>  strval($data->message) ?? "",
                        "chat_unique_key" => strval($data->chat_unique_key) ?? "",
                        "is_read" => strval($data->is_read) ?? "",
                    ],
                ],

            ];

            $dataString = json_encode($notificationData);
            $header = array('Content-Type: application/json', "Authorization: Bearer $SERVER_API_KEY");
            // Initialize cURL session
            $ch = curl_init("https://fcm.googleapis.com/v1/projects/" . $PROJECT_KEY . "/messages:send");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

            // Execute cURL request and get the response
            $response = curl_exec($ch);

            // Check for cURL errors
            if (curl_errno($ch)) {
                throw new \Exception(curl_error($ch));
            }

            // Close cURL session
            curl_close($ch);
            // Return success message
            return true;
            // } else {
            //     return false;
            // }
        } catch (\Exception $e) {
            // Return error message
            return $e->getMessage();
        }
    }
}
