<?php

namespace App\Http\Controllers\Admin;


use DataTables;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:customer-list', ['only' => ['index']]);
        $this->middleware('permission:customer-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:customer-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:customer-delete', ['only' => ['destroy']]);
        $this->middleware('permission:customer-status', ['only' => ['customerStatus']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('is_delete',0)->where('user_type',4)->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn ="";
                    $btn = $btn . '<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                      <div class="btn-group" role="group">
                        <button class="btn btn-light dropdown-toggle text-primary" id="btnGroupDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';

                        if ($row->is_approved == 1) {
                                $btn = $btn . '<a    href="' . route('customer.approved', $row->id) . '" title="' . __('labels.Approved') . '" class="dropdown-item status-change" data-url="' . route('customer.approved', $row->id) . '">' . __('labels.Approved') . '</a>';
                        }


                        else if ($row->is_approved == 2) {
                            $btn = $btn . '<a    href="' . route('customer.suspend', $row->id) . '" title="' . __('labels.Suspend') . '" class="dropdown-item status-change" data-url="' . route('customer.suspend', $row->id) . '">' . __('labels.Suspend') . '</a>';
                        }

                        else
                        {
                            $btn = $btn . '<a    href="' . route('customer.approved', $row->id) . '" title="' . __('labels.Approved') . '" class="dropdown-item status-change" data-url="' . route('customer.approved', $row->id) . '">' . __('labels.Approved') . '</a>';
                        }

                    //    $btn = $btn . '<a class="edit-data dropdown-item"  href="javascript:void(0)" title="' . __('labels.Edit') . '" data-url="'.route('customer.edit', $row->id).'">' . __('labels.Edit') . '</a>';
                       $btn = $btn . '<a href="" data-url="' . route('customer.destroy', $row->id) . '" class="dropdown-item destroy-data" title="' . __('labels.Delete') . '">' . __('labels.Delete') . '</a>';

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
                            <h6 class="mt-0">&nbsp;&nbsp; ' . $data->first_name . ' ' . $data->last_name .  '</span></h6>
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

                ->addColumn('joing_date', function ($data) {
                    return date('Y-M-d h:i A', strtotime($data->created_at));

                })

                ->addColumn('status', function ($data) {
                    if ($data->is_approved == 1) {
                        return '<span class="badge bg-dark">' . __('labels.Pending') . '</span>';
                    } elseif ($data->is_approved == 2) {
                        return '<span class="badge bg-success">' . __('labels.Approved') . '</span>';
                    }elseif ($data->is_approved == 3) {
                        return '<span class="badge bg-danger">' . __('labels.Suspend') . '</span>';
                    }else{
                        return '<span class="badge bg-dark">' . __('labels.Pending') . '</span>';
                    }
                })


                ->rawColumns(['action','user_details','joing_date','status'])
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


        try{

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

    public function show($id)
    {


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


        try{
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
            $data =  User::find($id);
            $data->is_delete  = 1;
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
                $message =  __('message.Customer Account Approved Successfully.');
                $data->update();
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
                $message =  __('message.Customer Account Suspend Successfully.');
                $data->update();
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

}
