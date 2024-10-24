<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\UserSubscription;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class CustomerController extends Controller
{

    public function __construct()
    {

        $this->middleware('permission:customer-list', ['only' => ['index']]);

        $this->middleware('permission:customer-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:customer-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:customer-delete', ['only' => ['destroy']]);

        $this->middleware('permission:customer-status', ['only' => ['customerStatus']]);

        $this->middleware('permission:customer-show', ['only' => ['show']]);

        $this->middleware('permission:customer-booking-add', ['only' => ['customerBookingAdd','customerBookingSave']]);

    }

    public function index(Request $request)
    {

        if ($request->ajax()) {

            // $data = User::where('is_delete',0)->orderBy('id', 'DESC')->where('user_type',4)->get();

            $currentDate = (new \DateTime())->format('Y-m-d H:i:s');

            // $data = User::with(['user_subscriptions'])->where('is_delete', 0)->where('user_type', 4)->get();

            $data = User::with(['user_subscriptions.subscription:id,subscription_name_en,subscription_name_ar,subscription_name_ur,subscription_name_tr'])

                ->where('is_delete', 0)

                ->where('user_type', 4)

            // ->whereHas('user_subscriptions', function ($query) use ($currentDate) {

            //     $query->where('start_date_time', '<=', $currentDate)

            //           ->where('end_date_time', '>=', $currentDate);

            // })

                ->orderBy('id', 'DESC')

                ->get();

            return Datatables::of($data)->addIndexColumn()

                ->addColumn('action', function ($row) {

                    $alert_delete = "return confirm('Are you sure want to delete !')";

                    $btn = "";

                    $btn = $btn . '<div class="btn-group" role="group" aria-label="Button group with nested dropdown">

                      <div class="btn-group" role="group">

                        <button class="btn btn-light dropdown-toggle text-primary" id="btnGroupDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></button>

                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';

                    $encrypted_Id = Crypt::encryptString($row->id);
                    if (auth()->user()->can('customer-booking-add')) {

                        $btn = $btn . '<a    href="javascript:void(0);" title="' . __('labels.Add Booking') . '" class="dropdown-item booking-add-data" data-url="' . route('customer.booking.add', $row->id) . '">' . __('labels.Add Booking') . '</a>';
                    }
                    if (auth()->user()->can('customer-status')) {
                        if ($row->is_approved == 1) {

                            $btn = $btn . '<a    href="' . route('customer.approved', $row->id) . '" title="' . __('labels.Approved') . '" class="dropdown-item status-change" data-url="' . route('customer.approved', $row->id) . '">' . __('labels.Approved') . '</a>';

                        } else if ($row->is_approved == 2) {

                            $btn = $btn . '<a    href="' . route('customer.suspend', $row->id) . '" title="' . __('labels.Suspend') . '" class="dropdown-item status-change" data-url="' . route('customer.suspend', $row->id) . '">' . __('labels.Suspend') . '</a>';

                        } else {

                            $btn = $btn . '<a    href="' . route('customer.approved', $row->id) . '" title="' . __('labels.Approved') . '" class="dropdown-item status-change" data-url="' . route('customer.approved', $row->id) . '">' . __('labels.Approved') . '</a>';

                        }
                    }
                    if (auth()->user()->can('customer-edit')) {
                        //    $btn = $btn . '<a class="edit-data dropdown-item"  href="javascript:void(0)" title="' . __('labels.Edit') . '" data-url="'.route('customer.edit', $row->id).'">' . __('labels.Edit') . '</a>';
                    }
                    if (auth()->user()->can('customer-delete')) {
                        $btn = $btn . '<a href="" data-url="' . route('customer.destroy', $row->id) . '" class="dropdown-item destroy-data" title="' . __('labels.Delete') . '">' . __('labels.Delete') . '</a>';
                    }
                    if (auth()->user()->can('customer-show')) {
                        $btn = $btn . '<a href="' . route('customer.show', $encrypted_Id) . '"  class="dropdown-item show-data" title="' . __('labels.View') . '">' . __('labels.View') . '</a>';
                    }
                    $btn = $btn . '</div>

                      </div>

                    </div>';

                    return $btn;

                })

                ->addColumn('user_details', function ($data) {

                    if ($data['profile_image'] == null && $data['profile_image'] == "") {

                        return ' <ul>

                        <li>

                          <div class="media"><img class="b-r-8 img-40" src=' . URL::to('/public') . '/admin/assets/images/user/user.png' . '  alt="Generic placeholder image"> <div class="media-body">

                          <div class="row">

                            <div class="col-xl-12">

                            <h6 class="mt-0">&nbsp;&nbsp; ' . $data->first_name . ' ' . $data->last_name . '</span></h6>

                            </div>

                          </div>

                          <p>&nbsp;&nbsp; ' . $data->email . '</p>

                        </div>

                      </div>

                    </li>

                  </ul>';

                    } else {

                        return ' <ul>

                        <li>

                          <div class="media"><img class="b-r-8 img-40" src=' . URL::to('/public') . '/profile_image/' . $data->profile_image . '  alt="Generic placeholder image">

                            <div class="media-body">

                              <div class="row">

                                <div class="col-xl-12">

                                <h6 class="mt-0">&nbsp;&nbsp; ' . $data->first_name . ' ' . $data->last_name . '</span></h6>

                                </div>

                              </div>

                              <p>&nbsp;&nbsp; ' . $data->email . '</p>

                            </div>

                          </div>

                        </li>

                      </ul>';

                    }

                })

                ->addColumn('subscriptions_name', function ($user) {

                    // Check if user has any subscriptions

                    if ($user->user_subscriptions->isEmpty()) {

                        return '';

                    }

                    // Get the latest subscription based on end_date_time

                    $latestSubscription = $user->user_subscriptions->sortByDesc('end_date_time')->first();

                    // Determine the subscription name field based on the current locale

                    $language = config('app.locale');

                    $subscriptionNameField = 'subscription_name_' . $language;

                    // Return the subscription name for the latest subscription

                    return $latestSubscription->subscription->$subscriptionNameField;

                })

                ->addColumn('subscriptions_start_date', function ($user) {

                    // Check if user has any subscriptions

                    if ($user->user_subscriptions->isEmpty()) {

                        return '';

                    }

                    // Get the latest subscription based on start_date_time

                    $latestSubscription = $user->user_subscriptions->sortByDesc('start_date_time')->first();

                    return date('Y-M-d h:i A', strtotime($latestSubscription->start_date_time));

                })

                ->addColumn('subscriptions_end_date', function ($user) {

                    // Check if user has any subscriptions

                    if ($user->user_subscriptions->isEmpty()) {

                        return '';

                    }

                    // Get the latest subscription based on end_date_time

                    $latestSubscription = $user->user_subscriptions->sortByDesc('end_date_time')->first();

                    return date('Y-M-d h:i A', strtotime($latestSubscription->end_date_time));

                })

                ->addColumn('availble_booking', function ($user) {

                    // Check if user has any subscriptions

                    if ($user->user_subscriptions->isEmpty()) {

                        return '0';

                    }

                    // Get the latest subscription based on end_date_time

                    $latestSubscription = $user->user_subscriptions->sortByDesc('end_date_time')->first();

                    return $latestSubscription->availble_booking ?? 0;

                })

                ->addColumn('joing_date', function ($data) {

                    return date('Y-M-d h:i A', strtotime($data->created_at));

                })

                ->addColumn('status', function ($data) {

                    if ($data->is_approved == 1) {

                        return '<span class="badge bg-dark">' . __('labels.Pending') . '</span>';

                    } elseif ($data->is_approved == 2) {

                        return '<span class="badge bg-success">' . __('labels.Approved') . '</span>';

                    } elseif ($data->is_approved == 3) {

                        return '<span class="badge bg-danger">' . __('labels.Suspend') . '</span>';

                    } else {

                        return '<span class="badge bg-dark">' . __('labels.Pending') . '</span>';

                    }

                })

                ->rawColumns(['action', 'user_details', 'subscriptions_name', 'subscriptions_start_date', 'subscriptions_end_date', 'joing_date', 'status', 'availble_booking'])

                ->make(true);

        }

        return view('Admin.Customers.Index');

    }

    public function create()
    {

        return view('Admin.Customers.create');

    }

    public function store(Request $request)
    {

        $this->validate($request, [

            'name' => 'required',

            'profile_image' => 'required',

            'email' => 'required|email|unique:users,email',

            'password' => 'required|digits_between:6,12',

            'phone' => 'required|digits_between:8,12|numeric',

        ], [

            'name.required' => __('error.The name field is required.'),

            'profile_image.required' => __('error.The profile image field is required.'),

            'email.required' => __('error.The email field is required.'),

            'email.email' => __('error.Please enter a valid email address.'),

            'email.unique' => __('error.The email has already been taken.'),

            'password.required' => __('error.The password field is required.'),

            'password.digits_between' => __('error.The password must be between 6 and 12 digits.'),

            'phone.required' => __('error.The phone number field is required.'),

            'phone.digits_between' => __('error.The phone number must be between 8 and 12 digits.'),

            'phone.numeric' => __('error.The phone number must be a number.'),

        ]);

        try {

            $email = $request['email'];

            $password = $request['password'];

            $post = $request->all();

            $data = new User();

            $data->name = $request['name'];

            $data->phone = $request['phone'];

            // $data->gender = $request['gender'];

            $data->email = $request['email'];

            $data->status = 1;

            $data->user_type = 4; //customer

            $data->password = Hash::make($request->password);

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

                    $data->profile_image = $filename;

                }

            }

            $data->save();

            if (!empty($data)) {

                return response()->json(['status' => '1', 'success' => __('message.Customer Account Added Successfully.')]);

            }

        } catch (Exception $ex) {

            return response()->json(

                ['success' => false, 'message' => $ex->getMessage()]

            );

        }

    }

    public function show(Request $request, $id)
    {
        try {

            // Decrypt ID if needed

            $Decrypt_id = Crypt::decryptString($id);

            // Fetch user data

            $data = User::find($Decrypt_id);

            if (!$data) {

                return response()->json(['error' => 'User not found'], 404);

            }

            // Fetch all user subscriptions using eager loading

            $userSubscriptions = UserSubscription::with('subscription_detail')

                ->where('user_id', $Decrypt_id)

                ->get();

            $customer_bookings = Booking::where('user_id', $Decrypt_id)
                ->get();
            // Pass the user and userSubscriptions data to the view

            return view('Admin.Customers.show', compact('data', 'userSubscriptions', 'customer_bookings'));

        } catch (\Exception $ex) {

            // Handle exceptions, return JSON response with error message

            return response()->json(['success' => false, 'message' => $ex->getMessage()]);

        }

    }

    public function edit($id)
    {

        try {

            $data = User::find($id);

            if (!empty($data)) {

                return view('Admin.Customers.edit', compact('data'));

            }

        } catch (Exception $ex) {

            return response()->json(

                ['success' => false, 'message' => $ex->getMessage()]

            );

        }

    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [

            'name' => 'required',

            'phone' => 'required|digits_between:8,12|numeric',

        ], [

            'name.required' => __('error.The name field is required.'),

            'phone.required' => __('error.The phone number field is required.'),

            'phone.digits_between' => __('error.The phone number must be between 8 and 12 digits.'),

            'phone.numeric' => __('error.The phone number must be a number.'),

        ]);

        try {

            $post = $request->all();

            $data = User::find($id);

            $data->name = $request['name'];

            $data->phone = $request['phone'];

            $data->password = Hash::make($request->password);

            if ($request->hasFile('profile_image')) {

                $source = $_FILES['profile_image']['tmp_name'];

                File::delete(public_path('profile_image/' . $data->profile_image));

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

            $data->save();

            if (!empty($data)) {

                return response()->json(['status' => '1', 'success' => __('message.Customer Account Update Successfully.')]);

            }

        } catch (Exception $ex) {

            return response()->json(

                ['success' => false, 'message' => $ex->getMessage()]

            );

        }

    }

    public function destroy($id)
    {

        try {

            DB::beginTransaction();

            $data = User::find($id);

            $data->is_delete = 1;

            $data->update();

            DB::commit(); // Commit Transaction

            return response()->json(['status' => '1', 'success' => __('message.Customer Account Delete Successfully.')]);

        } catch (\Exception $e) {

            DB::rollBack(); //Rollback Transaction

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        } catch (\Throwable $e) {

            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }

    }

    public function customerApprovedStatus($id)
    {

        try {

            DB::beginTransaction();

            $data = User::find($id);

            $data->is_approved = "2";

            $message = __('message.Customer Account Approved Successfully.');

            $data->update();

            sendEmail($data->id, 'account-approved', '');

            DB::commit(); // Commit Transaction

            return response()->json(['status' => '1', 'success' => $message]);

        } catch (\Exception $e) {

            DB::rollBack(); //Rollback Transaction

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        } catch (\Throwable $e) {

            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }

    }

    public function customerSuspendStatus($id)
    {

        try {

            DB::beginTransaction();

            $data = User::find($id);

            $data->is_approved = "3";

            $message = __('message.Customer Account Suspend Successfully.');

            $data->update();

            sendEmail($data->id, 'account-suspend', '');

            DB::commit(); // Commit Transaction

            return response()->json(['status' => '1', 'success' => $message]);

        } catch (\Exception $e) {

            DB::rollBack(); //Rollback Transaction

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        } catch (\Throwable $e) {

            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }

    }

    public function customerBookingAdd($id)
    {
        try {

            $data = User::find($id);

            if (!empty($data)) {
                return view('Admin.Customers.add-booking', compact('data'));
            }

        } catch (Exception $ex) {

            return response()->json(

                ['success' => false, 'message' => $ex->getMessage()]

            );

        }
    }

    public function customerBookingSave(Request $request)
    {
        $this->validate($request, [
            'number_of_booking' => 'required|numeric',

        ], [
            'number_of_booking.required' => __('error.This field is required'),
            'number_of_booking.numeric' => __('error.The field must be a numeric'),
        ]);

        try {

            $data = UserSubscription::where('user_id', $request->user_id)->first();
            if ($data) {
                $data->availble_booking = $data->availble_booking + $request->number_of_booking;
                $data->update();
            } else {
                $data = setUserPermissionBaseOnSubscription($request->user_id, 1);
            }
            if (!empty($data)) {
                return response()->json(['status' => '1', 'success' => __('message.Booking Added to customer account')]);
            }

        } catch (Exception $ex) {

            return response()->json(

                ['success' => false, 'message' => $ex->getMessage()]

            );

        }

    }

}
