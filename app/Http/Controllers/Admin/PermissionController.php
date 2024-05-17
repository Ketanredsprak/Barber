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
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn = "<ul class='action'>";

                            $btn = $btn .  '<li class="edit"> <a class="edit-data"  href="javascript:void(0)" title="Edit" data-url="'.route('permission.edit', $row->id).'"><i class="icon-pencil-alt"></i></a></li>';
                            $btn = $btn . ' <li class="delete"><a href="" data-url="' . route('permission.destroy', $row->id) . '" class="destroy-data" title="Delete"> <i class="icon-trash"></i></a></li> </ul>';

                    $btn = $btn . '<ul>';
                   return $btn;
                })

                ->addColumn('status', function ($row) {
                    if ($row->status == 1) {
                        return '<span class="badge bg-success">Active</span>';
                    } else {
                        return '<span class="badge bg-danger">In-Active</span>';
                    }
                })


                ->rawColumns(['action','status'])
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
                return response()->json(['status' => '1', 'success' => 'Permission Added successfully.']);
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
            return response()->json(['status' => '1', 'success' => 'Permission edit Successfully']);
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
            return response()->json(['status' => '1', 'success' => 'Permission deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
