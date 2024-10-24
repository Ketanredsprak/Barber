<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubscriptionRequest;
use App\Models\Subscription;
use App\Models\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

// use App\Http\Requests\Admin\EditTestimonialRequest;

// use App\Http\Requests\Admin\CreateTestimonialRequest;

class SubscriptionController extends Controller
{

    /**

     * Display a listing of the resource.

     */

    public function __construct()
    {

        $this->middleware('permission:subscription-list', ['only' => ['index']]);

        $this->middleware('permission:subscription-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:subscription-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:subscription-delete', ['only' => ['destroy']]);

        $this->middleware('permission:subscription-status', ['only' => ['subscriptionStatus']]);

    }

    public function index(Request $request)
    {

        //

        if ($request->ajax()) {

            $data = Subscription::where('is_delete', 0)->orderBy('id', 'DESC')->get();

            $locale = App::getLocale();

            return Datatables::of($data)->addIndexColumn()

                ->addColumn('action', function ($row) {

                    $btn = "";

                    $btn = $btn . '<div class="btn-group" role="group" aria-label="Button group with nested dropdown">

                      <div class="btn-group" role="group">

                        <button class="btn btn-light dropdown-toggle text-primary" id="btnGroupDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></button>

                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';

                    if (auth()->user()->can('subscription-status')) {
                        if ($row->status == 1) {

                            $btn = $btn . '<a    href="' . route('subscription.status', $row->id) . '" title="' . __('labels.Inactive') . '" class="dropdown-item status-change" data-url="' . route('subscription.status', $row->id) . '">' . __('labels.Inactive') . '</a>';

                        } else if ($row->status == 0) {

                            $btn = $btn . '<a   href="javascript:void(0)" href="' . route('subscription.status', $row->id) . '"   class="dropdown-item status-change" title="' . __('labels.Active') . '" data-url="' . route('subscription.status', $row->id) . '">' . __('labels.Active') . '</a>';

                        } else {

                            $btn = $btn . '<a   href="javascript:void(0)" href="' . route('subscription.status', $row->id) . '"   class="dropdown-item status-change" title="' . __('labels.Active') . '" data-url="' . route('subscription.status', $row->id) . '">' . __('labels.Active') . '</a>';

                        }
                    }

                    if (auth()->user()->can('subscription-edit')) {
                        $btn = $btn . '<a class="edit-data dropdown-item"  href="' . route('subscription.edit', $row->id) . '" title="' . __('labels.Edit') . '">' . __('labels.Edit') . '</a>';
                    }
                    if (auth()->user()->can('subscription-delete')) {
                        $btn = $btn . '<a href="" data-url="' . route('subscription.destroy', $row->id) . '" class="dropdown-item destroy-data" title="' . __('labels.Delete') . '">' . __('labels.Delete') . '</a>';
                    }

                    $btn = $btn . '</div>

                      </div>

                    </div>';

                    return $btn;

                })

                ->addColumn('status', function ($row) {

                    if ($row->status == 1) {

                        return '<span class="badge bg-success">' . __('labels.Active') . '</span>';

                    } else {

                        return '<span class="badge bg-danger">' . __('labels.Inactive') . '</span>';

                    }

                })

                ->addColumn('subscription_name', function ($row) {

                    $locale = App::getLocale();

                    $name = "subscription_name_" . $locale;

                    return $row->$name;

                })

                ->rawColumns(['action', 'status', 'subscription_name'])

                ->make(true);

        }

        return view('Admin.Subscriptions.index');

    }

    /**

     * Show the form for creating a new resource.

     */

    public function create()
    {

        //

        return view('Admin.Subscriptions.create');

    }

    /**

     * Store a newly created resource in storage.

     */

    public function store(SubscriptionRequest $request)
    {

        //

        try {

            $post = $request->all();

            $data = new Subscription();

            $data->subscription_name_en = $request->subscription_name_en;

            $data->subscription_name_ar = $request->subscription_name_ar;

            $data->subscription_name_ur = $request->subscription_name_ur;

            $data->subscription_name_tr = $request->subscription_name_tr;

            $data->subscription_detail_en = $request->subscription_description_en;

            $data->subscription_detail_ar = $request->subscription_description_ar;

            $data->subscription_detail_ur = $request->subscription_description_ur;

            $data->subscription_detail_tr = $request->subscription_description_tr;

            $data->number_of_booking = $request->number_of_booking;

            $data->price = $request->price;

            $data->duration_in_months = $request->duration_in_months;

            $data->subscription_type = $request->subscription_type;

            $data->status = 1;

            $data->save();

            if (!empty($data)) {

                return response()->json(['status' => '1', 'success' => __('message.Subscription Added Successfully.')]);

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

            $data = Subscription::find($id);

            if (!empty($data)) {

                return view('Admin.Subscriptions.edit', compact('data'));

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

    public function update(SubscriptionRequest $request, string $id)
    {

        //

        try {

            $data = Subscription::find($id);

            $data->subscription_name_en = $request->subscription_name_en;

            $data->subscription_name_ar = $request->subscription_name_ar;

            $data->subscription_name_ur = $request->subscription_name_ur;

            $data->subscription_name_tr = $request->subscription_name_tr;

            $data->subscription_detail_en = $request->subscription_description_en;

            $data->subscription_detail_ar = $request->subscription_description_ar;

            $data->subscription_detail_ur = $request->subscription_description_ur;

            $data->subscription_detail_tr = $request->subscription_description_tr;

            $data->number_of_booking = $request->number_of_booking;

            $data->price = $request->price;

            $data->duration_in_months = $request->duration_in_months;

            $data->update();

            if (!empty($data)) {

                return response()->json(['status' => '1', 'success' => __('message.Subscription Update Successfully.')]);

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

            $data = Subscription::find($id);

            $data->is_delete = 1;

            $data->update();

            DB::commit(); // Commit Transaction

            return response()->json(['status' => '1', 'success' => __('message.Subscription Deleted Successfully.')]);

        } catch (\Exception $e) {

            DB::rollBack(); //Rollback Transaction

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        } catch (\Throwable $e) {

            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }

    }

    public function subscriptionStatus($id)
    {

        try {

            DB::beginTransaction();

            $data = Subscription::find($id);

            if ($data->status == 1) {

                $data->status = 0;

                $message = __('message.Subscription Deactived Successfully.');

            } else {

                $data->status = 1;

                $message = __('message.Subscription Actived Successfully.');

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
