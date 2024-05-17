<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = Role::get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn = "<ul class='action'>";
                    if ($row->status == 0) {
                            $btn = $btn .  '<li class="edit"> <a class="edit-data"  href="javascript:void(0)" title="Edit" data-url="'.route('role.edit', $row->id).'"><i class="icon-pencil-alt"></i></a></li>';
                            $btn = $btn . ' <li class="delete"><a href="" data-url="' . route('role.destroy', $row->id) . '" class="destroy-data" title="Delete"> <i class="icon-trash"></i></a></li> </ul>';
                    }
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
        return view('Admin.Roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.Roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name'),'guard_name' => "web"]);
        $role->syncPermissions($request->input('permission'));

        if (!empty($role)) {
            return response()->json(['status' => '1', 'success' => 'Roles Added successfully.']);
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

        $role = Role::find($id);
        $permission_group = Permission::get()->groupBy('section');
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('Admin.Roles.edit', compact('role', 'permission_group', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       //
                $this->validate($request, [
                'name' => 'required',
                'permission' => 'required',
                ]);

                $role = Role::find($id);
                $role->name = $request->input('name');
                $role->save();

                $role->syncPermissions($request->input('permission'));

                if (!empty($role)) {
                    return response()->json(['status' => '1', 'success' => 'Roles Update successfully.']);
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
            DB::table("roles")->where('id', $id)->delete();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => 'Roles Deleted successfully']);
            } catch (\Exception $e) {
                DB::rollBack(); //Rollback Transaction
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            } catch (\Throwable $e) {
                DB::rollBack();
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
    }
}
