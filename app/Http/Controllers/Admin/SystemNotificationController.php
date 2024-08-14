<?php

namespace App\Http\Controllers\Admin;


use DataTables;
use App\Models\User;
use App\Models\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EditServiceRequest;
use App\Http\Requests\Admin\CreateSystemNotificationRequest;
use App\Models\SystemNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SystemNotificationController extends Controller
{

    function __construct()
    {
        // $this->middleware('permission:SystemNotification-list', ['only' => ['index']]);
        // $this->middleware('permission:SystemNotification-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:SystemNotification-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:SystemNotification-delete', ['only' => ['destroy']]);
        // $this->middleware('permission:SystemNotification-status', ['only' => ['serviceStatus']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //




        // dd('data');
        if ($request->ajax()) {
            $data = SystemNotification::orderBy('id', 'DESC')->get();



            return Datatables::of($data)->addIndexColumn()
                ->addColumn('notificationtype', function ($row) {

                    return @$row->notification_type;
                })
                ->addColumn('usertype', function ($row) {

                    return @$row->usertype;
                })

                ->addColumn('title', function ($row) {

                    return @$row->title;
                })
                ->addColumn('description', function ($row) {

                    return @$row->description;
                })

                ->rawColumns(['notificationtype', 'usertype', 'title', 'description'])
                ->make(true);
        }
        return view('Admin.System-Notification.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.System-Notification.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSystemNotificationRequest $request)
    {



        try {
            // Retrieve all the input data from the request
            $post = $request->all();

            // Check user type and fetch users accordingly
            if ($request->usertype == 3) {
                $user = User::where('user_type', 3)->orderBy('id', 'DESC')->get();
                $usertype = "Barber";
            }
            if ($request->usertype == 4) {
                $user = User::where('user_type', 4)->orderBy('id', 'DESC')->get();
                $usertype = "Customer";
            } else {
                $user = User::orderBy('id', 'DESC')->get();
            }

            // Check the notification type and handle accordingly
            switch ($request->notification_type) {
                case 'email':
                    // Handle email notifications
                    foreach ($user as $u) {
                        Mail::send(
                            ['html' => 'email.system_notification_template'], // Specify the view template
                            [
                                'title' => $request->title, // Pass the title
                                'description' => $request->description // Pass the description
                            ],
                            function ($message) use ($u, $request) {
                                $message->to($u->email)
                                    ->subject('Notification'); // Use the title as the subject
                            }
                        );
                    }
                    break;

                case 'push':
                    // Handle push notifications
                    foreach ($user as $u) {
                        // Logic to send push notification
                        PushNotification::send($u->device_token, $data);
                    }
                    break;

                case 'both':
                    // Handle both email and push notifications
                    foreach ($user as $u) {
                        // Send email
                        Mail::raw(
                            "Title: {$request->title}\nDescription: {$request->description}",
                            function ($message) use ($u, $request) {
                                $message->to($u->email)
                                    ->subject($request->title);
                            }
                        );

                        // Send push notification
                        PushNotification::send($u->device_token, $data);
                    }
                    break;

                default:
                    // Invalid notification type
                    return response()->json(['status' => '0', 'error' => __('Invalid notification type.')]);
            }

            // Insert notification into the system
            $data = new SystemNotification();
            $data->usertype = $usertype;
            $data->notification_type = $request->notification_type;
            $data->title = $request->title;
            $data->description = $request->description;
            $data->save();

            // Return success response
            return response()->json(['status' => '1', 'success' => __('System Notification Send Successfully.')]);
        } catch (Exception $ex) {
            // Return error response
            return response()->json(['status' => '0', 'error' => $ex->getMessage()]);
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
            $data = SystemNotification::find($id);
            if (!empty($data)) {
                return view('Admin.System-Notification.edit', compact('data'));
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
    public function update(EditServiceRequest $request, string $id)
    {
        //
        try {


            $data =  SystemNotification::find($id);
            $data->service_name_en = $request->service_name_en;
            $data->service_name_ar = $request->service_name_ar;
            $data->service_name_ur = $request->service_name_ur;
            $data->service_name_tr = $request->service_name_tr;
            $data->parent_id = $request->parent_id ?? 0;
            $data->is_special_service = $request->is_special_service ?? 0;

            if ($request->hasFile('service_image')) {
                $source = $_FILES['service_image']['tmp_name'];
                if ($source) {
                    $destinationFolder = public_path('service_image'); // Specify the destination folder
                    $image = $request->file('service_image');
                    $filename = time() . '_service_image.' . $image->getClientOriginalExtension();
                    if (!file_exists($destinationFolder)) {
                        mkdir($destinationFolder, 0777, true);
                    }
                    $destination = $destinationFolder . '/' . $filename;
                    $service_image = compressImage($source, $destination);
                    $data->service_image = $filename;
                }
            }

            $data->save();
            if (!empty($data)) {
                return response()->json(['status' => '1', 'success' => __('message.Service Update Successfully.')]);
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
            $data =  SystemNotification::find($id);
            $data->is_delete  = 1;
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' =>  __('message.Service Deleted Successfully.')]);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function SystemNotificationStatus($id)
    {
        try {
            DB::beginTransaction();
            $data = SystemNotification::find($id);
            if ($data->status == 1) {
                $data->status = 0;
                $message = __('message.Service Deactived Successfully.');
            } else {
                $data->status = 1;
                $message = __('message.Service Actived Successfully.');
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
