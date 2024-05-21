<?php
namespace App\Http\Controllers\Admin;


use DataTables;
use App\Models\User;
use App\Models\Module;
use App\Models\Countries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Admin\CountryRequest;
use App\Http\Requests\Admin\PermissionRequest;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //

        if ($request->ajax()) {
            $data = Permission::get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn ="";
                    $btn = $btn . '<div class="m-b-30">
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                      <div class="btn-group" role="group">
                        <button class="btn btn-light dropdown-toggle text-primary" id="btnGroupDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';

                            $btn = $btn . '<a class="edit-data dropdown-item"  href="javascript:void(0)" title="' . __('labels.Edit') . '" data-url="'.route('permission.edit', $row->id).'">' . __('labels.Edit') . '</a>';
                            $btn = $btn . '<a href="" data-url="' . route('permission.destroy', $row->id) . '" class="dropdown-item destroy-data" title="' . __('labels.Delete') . '">' . __('labels.Delete') . '</a>';

                            $btn = $btn . '</div>
                      </div>
                    </div>
                  </div>';
                   return $btn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        return view('Admin.Permissions.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.Permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request)
    {
        //
        try {
            $post = $request->all();
            $data = new Permission();
            $data->name = $request->name;
            $data->module_name = $request->module_name;
            $data->save();
            if (!empty($data)) {
                return response()->json(['status' => '1', 'success' => __('message.Permission Added Successfully.')]);
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
            $data = Permission::find($id);
            if (!empty($data)) {
                return view('Admin.Permissions.edit', compact('data'));
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
    public function update(PermissionRequest $request, string $id)
    {
        try {
            $data =  Permission::find($id);
            $data->name = $request->name;
            $data->module_name = $request->module_name;
            $data->save();
            if (!empty($data)) {
            return response()->json(['status' => '1', 'success' => __('message.Permission Update Successfully.')]);
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
            $data =  Permission::find($id);
            $data->delete();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => __('message.Permission Deleted Successfully.')]);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
