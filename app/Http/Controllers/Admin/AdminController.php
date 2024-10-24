<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\ContactUS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Admin\AdminProfileRequest;
use App\Models\Booking;
use App\Models\Services;
use App\Models\Subscription;

class AdminController extends Controller
{
    //

    public function adminLogin()
    {
        if (!empty((Auth::user()))) {
            if (Auth::user()->user_type  == 1) {
                return redirect('admin/dashboard');
            } elseif (Auth::user()->user_type  == 2) {
                return redirect('admin/dashboard');
            } elseif (Auth::user()->user_type  == 3) {
                return redirect('404');
            } else {
                return redirect('/');
            }
        } else {
            return  view('Admin.login');
        }
    }


    public function storeLogin(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::AdminHome);
    }




    public function dashboard()
    {
        $customers = User::where('user_type', 4)->where('is_delete', 0)->count();
        $barbers = User::where('user_type', 3)->where('is_delete', 0)->count();
        $subadmin = User::where('user_type', 2)->where('is_delete', 0)->count();
        $contactus = ContactUS::where('is_delete', 0)->count();

        $booking = Booking::count();
        $today_booking = Booking::where('booking_date', date('Y-m-d'))->count();

        $pending_booking = Booking::where('status', 'pending')->count();
        $reject_booking = Booking::where('status', 'reject')->count();
        $accept_booking = Booking::where('status', 'accept')->count();
        $finished_booking = Booking::where('status', 'finished')->count();
        $rescheduled_booking = Booking::where('status', 'rescheduled')->count();
        $cancel_booking = Booking::where('status', 'cancel')->count();

        $subscription = Subscription::count();
        $main_services = Services::where('parent_id', 0)->count();
        $sub_services = Services::where('parent_id', '!=', 0)->count();


        //booking details
        $todays_bookings = Booking::with(['barber_detail', 'customer_detail','booking_service_detailss'])
        ->orderBy('id', 'DESC')
        ->where('booking_date', date('Y-m-d'))
        ->get();

        // booking details

        // Initialize arrays to hold data
        $monthlyOrderCounts = array_fill(0, 12, 0);


        // Get the current year
        $currentYear = date('Y');

        // Fetch monthly booking counts and revenue
        $graph_bookings = Booking::selectRaw('MONTH(booking_date) as month, COUNT(*) as count')
            ->whereYear('booking_date', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        foreach ($graph_bookings as $graph_booking) {
            $monthIndex = $graph_booking->month - 1; // months are 1-based, but array indices are 0-based
            $monthlyOrderCounts[$monthIndex] = $graph_booking->count;
        }

        // Prepare labels for the months
        $monthlyLabels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        $orderCount = array_sum($monthlyOrderCounts); // Example value
        $monthlyOrderCounts = [
            'data' => $monthlyOrderCounts,
            'labels' => $monthlyLabels
        ];

        return view('Admin.dashboard', compact('orderCount', 'monthlyOrderCounts', 'customers', 'subadmin', 'barbers', 'contactus','todays_bookings' ,'booking', 'today_booking', 'pending_booking', 'reject_booking', 'cancel_booking', 'accept_booking', 'finished_booking', 'rescheduled_booking', 'subscription', 'main_services', 'sub_services'));
    }

    public function setting(Request $request)
    {

        return view('Admin.account_setting', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(AdminProfileRequest $request)
    {

        $user = Auth::user();
        $data = User::find($user->id);

        // for Image
        if ($request->hasFile('profile_image')) {
            if ($data->profile_image) {
                File::delete(public_path('profile_image/' . $data->profile_image));
            }
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
                $data->profile_image = $filename;
            }
        }


        $data->first_name = $request['first_name'];
        $data->last_name = $request['last_name'];
        $data->email = $request['email'];
        $data->phone = $request['phone'];
        $data->save();
        if (!empty($data)) {
            return redirect()->route('setting')->with('info', __('message.Profile edit Successfully'));
            // return redirect()->route('setting')->with('success',__('message.Profile edit Successfully'));
            // return response()->json(['status' => '1', 'success' => 'Profile edit Successfully']);
        }
    }

    public function getChangePassword(Request $request)
    {
        return view('Admin.change_password', [
            'user' => $request->user(),
        ]);
    }

    public function storeChangePassword(Request $request)
    {

        $request->validate([
            'current_password' => 'required',
            'password' => 'required',
            'password_confirmation' => ['required', 'same:password'],
        ], [
            'current_password.required' => __('error.This field is required'),
            'password.required' => __('error.This field is required'),
            'password_confirmation.required' => __('error.This field is required'),
            'password_confirmation.same' => __('error.The password confirmation does not match the new password.'),
        ]);

        $pass = Hash::make($request->password);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return redirect()->route('setting')->with("error", __('message.Old Password Does not match!'));
        } else {
            $data = User::find(Auth::id())->update(array('password' => $pass));
            if (!empty($data)) {


                $user_type = Auth::user()->user_type;

                Auth::guard('web')->logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();

                if ($user_type == 1) {
                    return redirect('admin/login')->with('info', __('message.Password updated successfully.'));
                } else {
                    return redirect('/')->with('info', __('message.Password updated successfully.'));
                }
            }
        }
    }

    public function languageChange(Request $request)
    {
        app()->setLocale($request->data);
        session()->put('locale', $request->data);
        return response()->json(['status' => 'success', 'success' => 'language change']);
    }
}
