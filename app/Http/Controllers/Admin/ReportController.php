<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;



use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    // Existing methods

    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('search_detail');
        $gender = $request->input('gender');

        return view('Admin.Report.SubadminReport', compact('startDate', 'endDate', 'gender'));
    }

    public function subadminReportData(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $gender = $request->input('gender');

        // Check if all input fields are empty
        if (empty($startDate) && empty($endDate) && empty($gender)) {
            return Datatables::of([])->make(true);
        }

        $query = User::query()
            ->where('user_type', 2)
            ->where('is_delete', 0);

        if ($startDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $query->where('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->where('created_at', '<=', $endDate);
        }

        if ($gender) {
            $query->where('gender', $gender);
        }

        return DataTables::of($query)
            ->addColumn('no', function ($item) {
                return null; // Will be replaced on client side
            })
            ->addColumn('status', function ($item) {
                return $item->is_approved ? 'Approved' : 'Pending';
            })
            ->rawColumns(['status'])
            ->make(true);
    }

    public function customerReport(Request $request)
{

  
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $gender = $request->input('gender');
    $subscriptionStatus = $request->input('subscription_status');

    if ($request->ajax()) {
        // Check if all input fields are empty
        if (empty($startDate) && empty($endDate) && empty($gender) && empty($subscriptionStatus)) {
            return DataTables::of([])->make(true);
        }

        // Initialize the query
        $query = User::with('user_subscriptions.subscription_detail')
            ->where('user_type', 4)
            ->where('is_delete', 0); // Filter out deleted users

        if ($startDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $query->where('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->where('created_at', '<=', $endDate);
        }

        if ($gender) {
            $query->where('gender', $gender);
        }

        // Apply subscription status filter if provided
        if ($subscriptionStatus) {
            // Ensure $subscriptionStatus is an array or a string in a proper format
            $subscriptionIds = is_array($subscriptionStatus) ? $subscriptionStatus : explode(',', $subscriptionStatus);

            // Filter users based on the collected IDs
            $query->whereHas('user_subscriptions', function($subQuery) use ($subscriptionIds) {
                $subQuery->whereIn('subscription_id', $subscriptionIds)
                ->where('status', 'active');

                
                
            });
        }


       
    

        // Fetch users
        $users = $query->get();

        // Map user data and include only the latest subscription
        $data = $users->map(function ($user) {
            // Get the latest subscription for the user
            $latestSubscription = $user->user_subscriptions->where('status', 'active')->sortByDesc('created_at')->first();

            // If there is a latest subscription, get the subscription name from the loaded subscription_detail
            $latestSubscriptionName = $latestSubscription && $latestSubscription->subscription_detail
                ? $latestSubscription->subscription_detail->subscription_name_en // Access directly
                : 'No Subscription';

            $joining_date = $user->created_at->toDateTimeString(); // Format as needed

            return [
                'first_name' => $user->first_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'gender' => $user->gender,
                'subscription_name_en' => $latestSubscriptionName,
                'joining_date' => $joining_date,
                'status' => $user->is_approved ? 'Approved' : 'Pending',
            ];
        });

        // Return the data as DataTables response
        return DataTables::of($data)->make(true);
    }

    // Fetch subscriptions for the filter dropdown
    $subscriptions = Subscription::where('subscription_type', 'customer')->get();

    return view('Admin.Report.CustomerReport', compact('startDate', 'endDate', 'gender', 'subscriptions'));
}


    public function customerReport2(Request $request)
    {




        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $gender = $request->input('gender');
        $subscriptionStatus = $request->input('subscription_status');


        if ($request->ajax()) {
            // Check if all input fields are empty
            if (empty($startDate) && empty($endDate) && empty($gender) && empty($subscriptionStatus)) {
                return DataTables::of([])->make(true);
            }

            // Fetch users with filters
            // $query = User::query();


            $query = User::with(['user_subscriptions'])->where('user_type', 4)
                ->where('is_delete', 0); // Filter out deleted bookings



            if ($startDate) {
                $startDate = Carbon::parse($startDate)->startOfDay();
                $query->where('created_at', '>=', $startDate);
            }

            if ($endDate) {
                $endDate = Carbon::parse($endDate)->endOfDay();
                $query->where('created_at', '<=', $endDate);
            }

            if ($gender) {
                $query->where('gender', $gender);
            }

            if ($subscriptionStatus) {
                // Fetch user subscription data from the database 
                $UserSubscriptionData = UserSubscription::where('subscription_id', $subscriptionStatus)->get();

                // Initialize arrays for collecting user data and subscription names
                $usersubscription_id = [];


                foreach ($UserSubscriptionData as $UserSubscription) {
                    // Collect user IDs
                    $usersubscription_id[] = $UserSubscription->user_id;

                    // Collect subscription IDs to look up names


                    $query->where('id', $usersubscription_id);
                }

                // $subscriptionNames = [];

                // // Fetch subscription names for the collected subscription IDs
                // $subscriptionNames = Subscription::whereIn('id', $subscriptionStatus)
                //     ->pluck('subscription_name_en', 'id')
                //     ->get(); // Converts to an associative array


                //  dd($subscriptionNames);
            }
            // Fetch users
            $users = $query->get();

            //  dd($users);


            // Map user data and include subscription names
            $data = $users->map(function ($user) use ($subscriptionStatus) {
                // Get subscription name from the map
                // $subscriptionName = $subscriptionMap[$user->subscription_id] ?? $subscriptionStatus ??'No Subscription'; // Assuming user has a `subscription_id` field
                return [
                    'first_name' => $user->first_name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'gender' => $user->gender,
                    'subscription_name_en' => $subscriptionStatus,
                    'status' => $user->is_approved ? 'Approved' : 'Pending'
                ];
            });


            // Return the data as DataTables response
            return DataTables::of($data)->make(true);
        }

        $subscriptions = Subscription::where('subscription_type', 'customer')->get();

        return view('Admin.Report.CustomerReport', compact('startDate', 'endDate', 'gender', 'subscriptions'));
    }
    public function customerReport3(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $gender = $request->input('gender');
        $subscriptionStatus = $request->input('subscription_status');

        if ($request->ajax()) {
            // Check if all input fields are empty
            if (empty($startDate) && empty($endDate) && empty($gender) && empty($subscriptionStatus)) {
                return DataTables::of([])->make(true);
            }

            // Initialize the query
            $query = User::with('user_subscriptions.subscription_detail')
                ->where('user_type', 4)
                ->where('is_delete', 0); // Filter out deleted users

            if ($startDate) {
                $startDate = Carbon::parse($startDate)->startOfDay();
                $query->where('created_at', '>=', $startDate);
            }

            if ($endDate) {
                $endDate = Carbon::parse($endDate)->endOfDay();
                $query->where('created_at', '<=', $endDate);
            }

            if ($gender) {
                $query->where('gender', $gender);
            }

            $subscriptionNames = [];
            if ($subscriptionStatus) {
                // Ensure $subscriptionStatus is an array or a string in a proper format
                $subscriptionIds = is_array($subscriptionStatus) ? $subscriptionStatus : explode(',', $subscriptionStatus);

                // Fetch subscription names for the provided subscription IDs
                $subscriptionNames = Subscription::whereIn('id', $subscriptionIds)
                    ->pluck('subscription_name_en', 'id'); // Pluck subscription names keyed by ID

                // Fetch user IDs with the specified subscription status
                $usersWithSubscription = UserSubscription::whereIn('subscription_id', $subscriptionIds)
                    ->pluck('user_id'); // Collect user IDs directly

                // Filter users based on the collected IDs
                $query->whereIn('id', $usersWithSubscription);
            }

            // Fetch users
            $users = $query->get();

            // dd($users);

            // Map user data and include subscription names
            // Map user data and include only the latest subscription
            $data = $users->map(function ($user) use ($subscriptionNames) {
                // Get the latest subscription for the user



                $latestSubscription = $user->user_subscriptions->sortByDesc('created_at')->first();
                $latestSubscriptionName = $latestSubscription ? $subscriptionNames[$latestSubscription->subscription_id] ?? 'No Subscription' : 'No Subscription';
                $joining_date = $user->created_at->toDateTimeString(); // Format as needed

                return [
                    'first_name' => $user->first_name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'gender' => $user->gender,
                    'subscription_name_en' => $latestSubscriptionName,
                    'joining_date' => $joining_date,

                    'status' => $user->is_approved ? 'Approved' : 'Pending',
                ];
            });

            // Return the data as DataTables response
            return DataTables::of($data)->make(true);
        }

        // Fetch subscriptions for the filter dropdown
        $subscriptions = Subscription::where('subscription_type', 'customer')->get();

        return view('Admin.Report.CustomerReport', compact('startDate', 'endDate', 'gender', 'subscriptions'));
    }


    public function barberReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $gender = $request->input('gender');
        $subscription = $request->input('subscription');

        // Fetch all subscriptions for the filter dropdown
        $subscriptions = Subscription::where('subscription_type', 'barber')->get();

        return view('Admin.Report.BarberReport', compact('startDate', 'endDate', 'gender', 'subscription', 'subscriptions'));
    }


    // public function barberReportData(Request $request)
    // {
    //     // Fetch and filter data based on request parameters
    //     $startDate = $request->input('start_date');
    //     $endDate = $request->input('end_date');
    //     $gender = $request->input('gender');

    //     // Check if all input fields are empty
    //     if (empty($startDate) && empty($endDate) && empty($gender)) {
    //         return Datatables::of([])->make(true);
    //     }

    //     // Build the query
    //     $query = User::query()
    //         ->where('user_type', 3) // Assuming 3 is the type for barbers
    //         ->where('is_delete', 0);

    //     // Apply filters if provided
    //     if ($startDate) {
    //         $startDate = Carbon::parse($startDate)->startOfDay();
    //         $query->where('created_at', '>=', $startDate);
    //     }

    //     if ($endDate) {
    //         $endDate = Carbon::parse($endDate)->endOfDay();
    //         $query->where('created_at', '<=', $endDate);
    //     }

    //     if ($gender) {
    //         $query->where('gender', $gender);
    //     }

    //     return DataTables::of($query)
    //         ->addColumn('no', function ($item) {
    //             // This will be dynamically set on the client side
    //         })
    //         ->addColumn('status', function ($item) {
    //             return $item->is_approved ? 'Approved' : 'Pending';
    //         })
    //         ->rawColumns(['status'])
    //         ->make(true);
    // }


    public function barberReportData2(Request $request)
    {

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $gender = $request->input('gender');
        $subscriptionStatus = $request->input('subscription_status');

        if ($request->ajax()) {
            // Check if all input fields are empty
            if (empty($startDate) && empty($endDate) && empty($gender) && empty($subscriptionStatus)) {
                return DataTables::of([])->make(true);
            }

            // Initialize the query
            $query = User::with(['user_subscriptions'])
                ->where('user_type', 3)
                ->where('is_delete', 0); // Filter out deleted users

            if ($startDate) {
                $startDate = Carbon::parse($startDate)->startOfDay();
                $query->where('created_at', '>=', $startDate);
            }

            if ($endDate) {
                $endDate = Carbon::parse($endDate)->endOfDay();
                $query->where('created_at', '<=', $endDate);
            }

            if ($gender) {
                $query->where('gender', $gender);
            }

            $subscriptionNames = [];
            if ($subscriptionStatus) {
                // Ensure $subscriptionStatus is an array or a string in a proper format
                $subscriptionIds = is_array($subscriptionStatus) ? $subscriptionStatus : explode(',', $subscriptionStatus);

                // Fetch subscription names for the provided subscription IDs
                $subscriptionNames = Subscription::whereIn('id', $subscriptionIds)
                    ->pluck('subscription_name_en', 'id'); // Pluck subscription names keyed by ID

                // Fetch user IDs with the specified subscription status
                $usersWithSubscription = UserSubscription::whereIn('subscription_id', $subscriptionIds)
                    ->pluck('user_id'); // Collect user IDs directly

                // Filter users based on the collected IDs
                $query->whereIn('id', $usersWithSubscription);
            }
       

            // Fetch users
            $users = $query->get();

            // Map user data and include only the latest subscription
            $data = $users->map(function ($user) use ($subscriptionNames) {
                // Get the latest subscription for the user
                $latestSubscription = $user->user_subscriptions->sortByDesc('created_at')->first();
                $latestSubscriptionName = $latestSubscription ? $subscriptionNames[$latestSubscription->subscription_id] ?? 'No Subscription' : 'No Subscription';

                // Access the created_at attribute for each user
                $joining_date = $user->created_at->toDateTimeString(); // Format as needed

                return [
                    'first_name' => $user->first_name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'gender' => $user->gender,
                    'subscription_name_en' => $latestSubscriptionName,
                    'joining_date' => $joining_date, // Use the formatted created_at for each user
                    'status' => $user->is_approved ? 'Approved' : 'Pending',
                ];
            });

            // Optionally, you can use dd() to inspect the data
            // dd($data);


            // Return the data as DataTables response
            return DataTables::of($data)->make(true);
        }
        // Make sure to fetch subscriptions for the view
        $subscriptions = Subscription::where('subscription_type', 'barber')->get();

        return view('Admin.Report.BarberReport', compact('startDate', 'endDate', 'gender', 'subscriptions'));
    }



    public function barberReportData(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $gender = $request->input('gender');
    $subscriptionStatus = $request->input('subscription_status');

    if ($request->ajax()) {
        // Check if all input fields are empty
        if (empty($startDate) && empty($endDate) && empty($gender) && empty($subscriptionStatus)) {
            return DataTables::of([])->make(true);
        }

        // Initialize the query
        $query = User::with('user_subscriptions.subscription_detail')
            ->where('user_type', 3)
            ->where('is_delete', 0); // Filter out deleted users

        if ($startDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $query->where('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->where('created_at', '<=', $endDate);
        }

        if ($gender) {
            $query->where('gender', $gender);
        }

        // Apply subscription status filter if provided
        if ($subscriptionStatus) {
            // Ensure $subscriptionStatus is an array or a string in a proper format
            $subscriptionIds = is_array($subscriptionStatus) ? $subscriptionStatus : explode(',', $subscriptionStatus);

            // Filter users based on the collected IDs
            $query->whereHas('user_subscriptions', function($subQuery) use ($subscriptionIds) {
              
                $subQuery->whereIn('subscription_id', $subscriptionIds)
                ->where('status', 'active');
            });

            
        }

        // Fetch users
        $users = $query->get();

        // Map user data and include only the latest subscription
        $data = $users->map(function ($user) {
            // Get the latest subscription for the user
            $latestSubscription = $user->user_subscriptions->where('status','active')->sortByDesc('created_at')->first();

            // If there is a latest subscription, get the subscription name from the loaded subscription_detail
            $latestSubscriptionName = $latestSubscription && $latestSubscription->subscription_detail
                ? $latestSubscription->subscription_detail->subscription_name_en // Access directly
                : 'No Subscription';

            $joining_date = $user->created_at->toDateTimeString(); // Format as needed

            return [
                'first_name' => $user->first_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'gender' => $user->gender,
                'subscription_name_en' => $latestSubscriptionName,
                'joining_date' => $joining_date,
                'status' => $user->is_approved ? 'Approved' : 'Pending',
            ];
        });

        // Return the data as DataTables response
        return DataTables::of($data)->make(true);
    }

    // Fetch subscriptions for the filter dropdown
    $subscriptions = Subscription::where('subscription_type', 'customer')->get();

    return view('Admin.Report.BarberReport', compact('startDate', 'endDate', 'gender', 'subscriptions'));
}

    // 05-08-2024 BOOKING REPORT



    public function bookingReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $customer_search_detail = $request->input('customer_search_detail');
        $barber_search_detail = $request->input('barber_search_detail');

        $status = $request->input('status');

        // Fetch all subscriptions for the filter dropdown
        // $subscriptions = Subscription::where('subscription_type', 'barber')->get();

        // return view('Admin.Report.BookingReport', compact('startDate', 'endDate', 'gender', 'subscription', 'subscriptions'));
        return view('Admin.Report.BookingReport', compact('startDate', 'endDate', 'customer_search_detail', 'barber_search_detail', 'status',));
        // return view('Admin.Report.TestingReport');  
    }



    public function bookingReportData(Request $request)
    {


        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $customer_search_detail = $request->input('customer_search_detail');
        $barber_search_detail = $request->input('barber_search_detail');
        $name = $request->input('name');

        $booking_status = $request->input('status'); // Ensure this matches the parameter from the client

        // dd($request);
        // Debugging
        //  dd([
        //     'start_date' => $startDate,
        //     'end_date' => $endDate,
        //     'name' => $name,
        //     'customer_search_detail' => $customer_search_detail,
        //     'barber_search_detail' => $barber_search_detail,

        //     'status' => $booking_status,
        // ]);

        if ($request->ajax()) {


            if (empty($startDate) && empty($endDate) && empty($customer_search_detail) && empty($barber_search_detail)  && empty($name)  && empty($booking_status)) {
                return DataTables::of([])->make(true);
            }


            // Build the query with eager loading
            $query = Booking::with(['barber_detail', 'customer_detail']); // Filter out deleted bookings

            // Apply date filters
            if ($startDate) {
                $startDate = Carbon::parse($startDate)->startOfDay();
                $query->where('booking_date', '>=', $startDate);
            }

            if ($endDate) {
                $endDate = Carbon::parse($endDate)->endOfDay();
                $query->where('booking_date', '<=', $endDate);
            }

            // Apply combined search filter
            if ($customer_search_detail) {
                $query->where(function ($q) use ($customer_search_detail) {
                    $q->whereHas('customer_detail', function ($q) use ($customer_search_detail) {
                        $q->where('first_name', 'LIKE', "%{$customer_search_detail}%")
                            ->orWhere('last_name', 'LIKE', "%{$customer_search_detail}%")
                            ->orWhere('email', 'LIKE', "%{$customer_search_detail}%")
                            ->orWhere('phone', 'LIKE', "%{$customer_search_detail}%");
                    });
                });
            }

            if ($barber_search_detail) {
                $query->where(function ($q) use ($barber_search_detail) {
                    $q->WhereHas('barber_detail', function ($q) use ($barber_search_detail) {
                        $q->where('first_name', 'LIKE', "%{$barber_search_detail}%")
                            ->orWhere('last_name', 'LIKE', "%{$barber_search_detail}%")
                            ->orWhere('email', 'LIKE', "%{$barber_search_detail}%")
                            ->orWhere('phone', 'LIKE', "%{$barber_search_detail}%");
                    });
                });
            }




            // Apply booking status filter
            if ($booking_status) {
                $query->where('status', $booking_status); // Filter by status
            }

            // Execute the query and prepare data for DataTables
            $bookings = $query->get();

            // Map data for DataTables with status badges
            $data = $bookings->map(function ($booking) {


                // User details rendering
                $userDetails = '';
                if ($booking->customer_detail->profile_image) {
                    $profileImageUrl = URL::to('/public') . ('/profile_image/' . $booking->customer_detail->profile_image);
                } else {
                    $profileImageUrl = URL::to('/public') . ('/admin/assets/images/user/user.png');
                }

                $userDetails = '
            <ul>
                <li>
                    <div class="media">
                        <img style="margin:2%" class="b-r-8 img-40" src="' . $profileImageUrl . '" alt="Profile Image">
                        <div class="media-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <h6 class="" style="margin:2%">' . $booking->customer_detail->first_name . ' ' . $booking->customer_detail->last_name . '</h6>
                                </div>
                            </div>
                            <p style="margin:2%">' . $booking->customer_detail->email . '</p>
                        </div>
                    </div>
                </li>
            </ul>';


                // Barber details rendering
                $barberDetails = '';
                if ($booking->barber_detail->profile_image) {
                    $profileImageUrl = URL::to('/public') . ('/profile_image/' . $booking->barber_detail->profile_image);
                } else {
                    $profileImageUrl = URL::to('/public') . ('/admin/assets/images/user/user.png');
                }

                $barberDetails = '
            <ul>
                <li>
                    <div class="media">
                        <img style="margin:2%" class="b-r-8 img-40" src="' . $profileImageUrl . '" alt="Profile Image">
                        <div class="media-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <h6 style="margin:2%" class="">' . $booking->barber_detail->first_name . ' ' . $booking->barber_detail->last_name . '</h6>
                                </div>
                            </div>
                            <p style="margin:2%">' . $booking->barber_detail->email . '</p>
                        </div>
                    </div>
                </li>
            </ul>';


                // Determine the status badge
                $statusBadge = '';
                switch ($booking->status) {
                    case 'pending':
                        $statusBadge = '<span class="badge bg-secondary">' . __('labels.Pending') . '</span>';
                        break;
                    case 'reject':
                        $statusBadge = '<span class="badge bg-danger">' . __('labels.Reject') . '</span>';
                        break;
                    case 'cancel':
                        $statusBadge = '<span class="badge bg-danger">' . __('labels.Cancel') . '</span>';
                        break;
                    case 'accept':
                        $statusBadge = '<span class="badge bg-success">' . __('labels.Accept') . '</span>';
                        break;
                    case 'finished':
                        $statusBadge = '<span class="badge bg-primary">' . __('labels.Finished') . '</span>';
                        break;
                    case 'rescheduled':
                        $statusBadge = '<span class="badge bg-warning">' . __('labels.Rescheduled') . '</span>';
                        break;
                    default:
                        $statusBadge = '<span class="badge bg-dark">' . __('labels.Unknown') . '</span>';
                        break;
                }

                return [
                    'customer_detail' => $userDetails, // Add user details here
                    'barber_detail' => $barberDetails,
                    'booking_date' => $booking->booking_date,
                    'start_time' => $booking->start_time,
                    'end_time' => $booking->end_time,
                    'total_price' => $booking->total_price,
                    'status' => $statusBadge // Add the status badge here
                ];
            });

            return DataTables::of($data)
                ->rawColumns(['status', 'customer_detail', 'barber_detail']) // Specify that the 'status' column contains raw HTML
                ->make(true);
        }

        // For non-AJAX requests, fetch subscriptions and return the view
        return view('Admin.Report.BookingReport', compact('startDate', 'endDate'));
    }


    public function revenueReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $gender = $request->input('gender');
        $subscription = $request->input('subscription');

        // Fetch all subscriptions for the filter dropdown
        $subscriptions = Subscription::where('subscription_type', 'revenue')->get();

        return view('Admin.Report.RevenueReport', compact('startDate', 'endDate', 'gender', 'subscription', 'subscriptions'));
    }

    public function revenueReportData(Request $request)
    {
        return view('Admin.Report.RevenueReport');
    }
}
