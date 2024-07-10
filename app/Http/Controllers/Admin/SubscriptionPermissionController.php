<?php
namespace App\Http\Controllers\Admin;


use DataTables;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\SubscriptionPermission;
use App\Http\Requests\Admin\CreateSubscriptionPermissionRequest;


class SubscriptionPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */



    public function index(Request $request)
    {
        //

        if ($request->ajax()) {
            $data = SubscriptionPermission::get();
            $locale = App::getLocale();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = "";
                    $btn = $btn . '<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                      <div class="btn-group" role="group">
                        <button class="btn btn-light dropdown-toggle text-primary" id="btnGroupDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';

                       $btn = $btn . '<a class="edit-data dropdown-item"  href="javascript:void(0)" title="' . __('labels.Edit') . '" data-url="'.route('subscription-permission.edit', $row->id).'">' . __('labels.Edit') . '</a>';
                       $btn = $btn . '<a href="" data-url="' . route('subscription-permission.destroy', $row->id) . '" class="dropdown-item destroy-data" title="' . __('labels.Delete') . '">' . __('labels.Delete') . '</a>';

                       $btn = $btn . '</div>
                      </div>
                    </div>';



                   return $btn;
                })


                ->rawColumns(['action'])
                ->make(true);
        }
        return view('Admin.Subscription-Permissions.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.Subscription-Permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSubscriptionPermissionRequest $request)
    {
        //
        try {
            $post = $request->all();
            $data = new SubscriptionPermission();
            $data->permission_detail = $request->permission_name;
            $data->permission_name = strtolower(str_replace(' ', '_', $request->permission_name));
            $data->permission_for_user = $request->permission_for_user;
            $data->is_input_box = $request->is_input_box ?? 0;
            $data->basic_input_value = $request->sub_basic;
            $data->bronz_input_value = $request->sub_bronz;
            $data->silver_input_value = $request->sub_silver;
            $data->gold_input_value = $request->sub_gold;
            $data->basic = $request->is_input_box ? 1 : 0;
            $data->bronz = $request->is_input_box ? 1 : 0;
            $data->silver = $request->is_input_box ? 1 : 0;
            $data->gold = $request->is_input_box ? 1 : 0;
            $data->subscription_array = $request->subscription_id ?? " ";
            $data->save();
            if (!empty($data)) {
                return response()->json(['status' => '1', 'success' => __('message.Subscription Permission Added Successfully.')]);
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
            $data = SubscriptionPermission::find($id);
            if (!empty($data)) {
                return view('Admin.Subscription-Permissions.edit', compact('data'));
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
    public function update(CreateSubscriptionPermissionRequest $request, string $id)
    {
        //
        try {

            // dd($request->all());
            $data =  SubscriptionPermission::find($id);
            $data->permission_detail = $request->permission_name;
            $data->permission_name = strtolower(str_replace(' ', '_', $request->permission_name));
            $data->permission_for_user = $request->permission_for_user;
            $data->is_input_box = $request->is_input_box_edit ?? 0;
            $data->basic_input_value = $request->sub_basic;
            $data->bronz_input_value = $request->sub_bronz;
            $data->silver_input_value = $request->sub_silver;
            $data->gold_input_value = $request->sub_gold;
            $data->basic = $request->is_input_box_edit ? 1 : 0;
            $data->bronz = $request->is_input_box_edit ? 1 : 0;
            $data->silver = $request->is_input_box_edit ? 1 : 0;
            $data->gold = $request->is_input_box_edit ? 1 : 0;
            $data->subscription_array = $request->subscription_id ?? " ";
            $data->update();
            if (!empty($data)) {
            return response()->json(['status' => '1', 'success' => __('message.Subscription Permission Update Successfully.')]);
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
            $data =  SubscriptionPermission::find($id);
            $data->delete();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => __('message.Subscription Permission Deleted Successfully.')]);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


     /**
     * Remove the specified resource from storage.
     */
    public function getSubcriptions(Request $request)
    {
           $data = Subscription::where('subscription_type',$request->permission_for_user)->get();
           return $data;

    }






 }
