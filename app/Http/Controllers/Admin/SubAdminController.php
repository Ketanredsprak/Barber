<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateSubadminRequest;
use App\Http\Requests\Admin\EditSubadminRequest;
use App\Models\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class SubAdminController extends Controller
{

    public function __construct()
    {

        $this->middleware('permission:subadmin-list', ['only' => ['index']]);

        $this->middleware('permission:subadmin-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:subadmin-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:subadmin-delete', ['only' => ['destroy']]);

        $this->middleware('permission:subadmin-status', ['only' => ['subadminStatus']]);

    }

    /**

     * Display a listing of the resource.

     */

    public function index(Request $request)
    {

        //

        if ($request->ajax()) {

            $data = User::where('user_type', 2)->where("is_delete", 0)->orderBy('id', 'DESC')->get();

            return Datatables::of($data)->addIndexColumn()

                ->addColumn('action', function ($row) {

                    $btn = "";

                    $btn = $btn . '<div class="btn-group" role="group" aria-label="Button group with nested dropdown">

                      <div class="btn-group" role="group">

                        <button class="btn btn-light dropdown-toggle text-primary" id="btnGroupDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></button>

                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';

                    if (auth()->user()->can('subadmin-status')) {
                        if ($row->is_approved == 2) {

                            $btn = $btn . '<a    href="' . route('subadmin.status', $row->id) . '" title="' . __('labels.Suspend') . '" class="dropdown-item status-change" data-url="' . route('subadmin.status', $row->id) . '">' . __('labels.Suspend') . '</a>';

                        } else if ($row->is_approved == 3) {

                            $btn = $btn . '<a   href="javascript:void(0)" href="' . route('subadmin.status', $row->id) . '"   class="dropdown-item status-change" title="' . __('labels.Approved') . '" data-url="' . route('subadmin.status', $row->id) . '">' . __('labels.Approved') . '</a>';

                        } else {

                            $btn = $btn . '<a   href="javascript:void(0)" href="' . route('subadmin.status', $row->id) . '"   class="dropdown-item status-change" title="' . __('labels.Approved') . '" data-url="' . route('subadmin.status', $row->id) . '">' . __('labels.Approved') . '</a>';

                        }
                    }
                    if (auth()->user()->can('subadmin-edit')) {
                        $btn = $btn . '<a class="edit-data dropdown-item"  href="javascript:void(0)" title="' . __('labels.Edit') . '" data-url="' . route('subadmin.edit', $row->id) . '">' . __('labels.Edit') . '</a>';
                    }
                    if (auth()->user()->can('subadmin-delete')) {
                        $btn = $btn . '<a href="" data-url="' . route('subadmin.destroy', $row->id) . '" class="dropdown-item destroy-data" title="' . __('labels.Delete') . '">' . __('labels.Delete') . '</a>';
                    }
                    $btn = $btn . '</div>

                      </div>

                    </div>';

                    return $btn;

                })

                ->addColumn('status', function ($row) {

                    if ($row->is_approved == 2) {

                        return '<span class="badge bg-success">' . __('labels.Approved') . '</span>';

                    } else if ($row->is_approved == 3) {

                        return '<span class="badge bg-danger">' . __('labels.Suspend') . '</span>';

                    } else {

                        return '<span class="badge bg-dark">' . __('labels.Pending') . '</span>';

                    }

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

                ->rawColumns(['action', 'status', 'user_details'])

                ->make(true);

        }

        return view('Admin.Sub-Admin.index');

    }

    /**

     * Show the form for creating a new resource.

     */

    public function create()
    {

        //

        return view('Admin.Sub-Admin.create');

    }

    /**

     * Store a newly created resource in storage.

     */

    public function store(CreateSubadminRequest $request)
    {

        //

        try {

            $referral_code = generate_rederal_code();

            $post = $request->all();

            $data = new User();

            $data->first_name = $request->first_name;

            $data->last_name = $request->last_name;

            $data->phone = $request->phone;

            $data->email = $request->email;

            $email = $request->email;

            $data->gender = $request->gender;

            $data->password = Hash::make($request->password);

            $data->user_type = 2;

            $data->is_approved = "2";

            $data->register_type = 2;

            $data->register_method = 1;

            $data->referral_code = $referral_code;

            // for Profile Image

            if ($request->hasFile('profile_image')) {

                $image = $request->file('profile_image');

                $profile_image_name = time() . '_profile_image.' . $image->getClientOriginalExtension();

                $destinationPath = public_path('/profile_image');

                $image->move($destinationPath, $profile_image_name);

                $data->profile_image = $profile_image_name;

            }

            $data->save();

            if ($data->id) {

                $data = array('role_id' => 2, "model_type" => "App\Models\User", "model_id" => $data->id);

                DB::table('model_has_roles')->insert($data);

            }

            if (!empty($data)) {

                Mail::send(

                    ['html' => 'email.subadmin_register'],

                    array(

                        'email' => $email,

                        'password' => $request->password,

                    ),

                    function ($message) use ($email) {

                        $message->from(env('MAIL_USERNAME'), 'Ehjez');

                        $message->to($email);

                        $message->subject("Welcome to Ehjez as Sub Admin...");

                    }

                );

                return response()->json(['status' => '1', 'success' => __('message.Sub Admin Account Added Successfully.')]);

                //

            }

        } catch (Exception $ex) {

            return response()->json(

                ['success' => false, 'message' => $ex->getMessage()]

            );

        }

    }

    /**

     * Display the specified resource.

     */

    public function show(string $id)
    {

        //

    }

    /**

     * Show the form for editing the specified resource.

     */

    public function edit(string $id)
    {

        //

        try {

            $data = User::find($id);

            if (!empty($data)) {

                return view('Admin.Sub-Admin.edit', compact('data'));

            }

        } catch (Exception $ex) {

            return response()->json(

                ['success' => false, 'message' => $ex->getMessage()]

            );

        }

    }

    /**

     * Update the specified resource in storage.

     */

    public function update(EditSubadminRequest $request, string $id)
    {

        $validated = [];

        $validated['email'] = 'required|email|unique:users,email,' . $id;

        $customMessages = [

            'email.required' => __('error.This field is required'),

            'email.email' => __('error.Please enter a valid email address.'),

            'email.max' => __('error.The field must not exceed :max characters.'),

            'email.unique' => __('error.The email address is already in use.'),

        ];

        $request->validate($validated, $customMessages);

        //

        try {

            $data = User::find($id);

            $data->first_name = $request->first_name;

            $data->last_name = $request->last_name;

            $data->phone = $request->phone;

            $data->email = $request->email;

            $data->gender = $request->gender;

            // for Profile Image

            if ($request->hasFile('profile_image')) {

                File::delete(public_path('profile_image/' . $data->profile_image));

                $image = $request->file('profile_image');

                $uploaded = time() . '_profile_image.' . $image->getClientOriginalExtension();

                $destinationPath = public_path('/profile_image');

                $image->move($destinationPath, $uploaded);

                $data->profile_image = $uploaded;

            }

            $data->save();

            if (!empty($data)) {

                return response()->json(['status' => '1', 'success' => __('message.Sub Admin Account Update Successfully.')]);

            }

        } catch (Exception $ex) {

            return response()->json(

                ['success' => false, 'message' => $ex->getMessage()]

            );

        }

    }

    /**

     * Remove the specified resource from storage.

     */

    public function destroy(string $id)
    {

        //

        try {

            DB::beginTransaction();

            $data = User::find($id);

            $data->is_delete = 1;

            $data->update();

            DB::commit(); // Commit Transaction

            return response()->json(['status' => '1', 'success' => __('message.Sub Admin Account Deleted Successfully.')]);

        } catch (\Exception $e) {

            DB::rollBack(); //Rollback Transaction

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        } catch (\Throwable $e) {

            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }

    }

    public function subadminStatus($id)
    {

        try {

            DB::beginTransaction();

            $data = User::find($id);

            if ($data->is_approved == 2) {

                $data->is_approved = "3";

                $message = __('message.Sub Admin Account Suspend Successfully.');

            } else {

                $data->is_approved = "2";

                $message = __('message.Sub Admin Account Approved Successfully.');

            }

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
