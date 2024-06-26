<?php
namespace App\Http\Controllers\Admin;


use DataTables;
use App\Models\User;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EditServiceRequest;
use App\Http\Requests\Admin\CreateServiceRequest;

class ServiceController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:service-list', ['only' => ['index']]);
        $this->middleware('permission:service-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:service-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:service-delete', ['only' => ['destroy']]);
        $this->middleware('permission:service-status', ['only' => ['serviceStatus']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //

        if ($request->ajax()) {
            $data = Services::where('is_delete',0)->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = "";
                    $btn = $btn . '<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                      <div class="btn-group" role="group">
                        <button class="btn btn-light dropdown-toggle text-primary" id="btnGroupDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';

                        if ($row->status == 1) {
                                $btn = $btn . '<a    href="' . route('service.status', $row->id) . '" title="' . __('labels.Inactive') . '" class="dropdown-item status-change" data-url="' . route('service.status', $row->id) . '">' . __('labels.Inactive') . '</a>';
                        }

                        else if ($row->status == 0) {
                                $btn = $btn . '<a   href="javascript:void(0)" href="' . route('service.status', $row->id) . '"   class="dropdown-item status-change" title="' . __('labels.Active') . '" data-url="' . route('service.status', $row->id) . '">' . __('labels.Active') . '</a>';
                        }
                        else
                        {
                                $btn = $btn . '<a   href="javascript:void(0)" href="' . route('service.status', $row->id) . '"   class="dropdown-item status-change" title="' . __('labels.Active') . '" data-url="' . route('service.status', $row->id) . '">' . __('labels.Active') . '</a>';
                        }

                       $btn = $btn . '<a class="edit-data dropdown-item"  href="javascript:void(0)" title="' . __('labels.Edit') . '" data-url="'.route('service.edit', $row->id).'">' . __('labels.Edit') . '</a>';
                       $btn = $btn . '<a href="" data-url="' . route('service.destroy', $row->id) . '" class="dropdown-item destroy-data" title="' . __('labels.Delete') . '">' . __('labels.Delete') . '</a>';

                       $btn = $btn . '</div>
                      </div>
                    </div>';
                  return $btn;

                })

                ->addColumn('service_image', function ($data) {
                    if ($row['service_image'] = null) {
                        return '<span class="badge badge-soft-success fs-12">no image</span>';
                    } else {
                        return '<img src=' . URL::to('/public') . '/service_image/' . $data->service_image . ' class="img-thumbnail" width="40" height="45"/>';
                    }
                })


                ->addColumn('status', function ($row) {
                    if ($row->status == 1) {
                        return '<span class="badge bg-success">' . __('labels.Active') . '</span>';
                    } else {
                        return '<span class="badge bg-danger">' . __('labels.Inactive') . '</span>';
                    }
                })

                ->addColumn('is_special_service', function ($row) {
                    if ($row->is_special_service == 1) {
                        return '<span>' . __('labels.Special Service') . '</span>';
                    } else {
                        return '';
                    }
                })


                ->addColumn('service_name', function ($row) {
                    $locale = App::getLocale();
                    $service_name = "service_name_".$locale;
                    return @$row->$service_name;
                })


                ->rawColumns(['action','status','service_name','service_image','is_special_service'])
                ->make(true);
        }
        return view('Admin.Services.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.Services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateServiceRequest $request)
    {
        //
        try {
            $post = $request->all();
            $data = new Services();
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
            $data->status = 1;
            $data->save();
            if (!empty($data)) {
                return response()->json(['status' => '1', 'success' => __('message.Service Added Successfully.')]);
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
            $data = Services::find($id);
            if (!empty($data)) {
                return view('Admin.Services.edit', compact('data'));
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


            $data =  Services::find($id);
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
            $data =  Services::find($id);
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

    public function serviceStatus($id)
    {
        try {
            DB::beginTransaction();
            $data = Services::find($id);
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
