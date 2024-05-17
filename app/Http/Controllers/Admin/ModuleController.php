<?php
namespace App\Http\Controllers\Admin;


use DataTables;
use App\Models\User;
use App\Models\Module;
use App\Models\Countries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ModuleRequest;
use App\Http\Requests\Admin\CountryRequest;

class moduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = Module::get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn = "<ul class='action'>";

                            $btn = $btn .  '<li class="edit"> <a class="edit-data"  href="javascript:void(0)" title="Edit" data-url="'.route('module.edit', $row->id).'"><i class="icon-pencil-alt"></i></a></li>';
                            $btn = $btn . ' <li class="delete"><a href="" data-url="' . route('module.destroy', $row->id) . '" class="destroy-data" title="Delete"> <i class="icon-trash"></i></a></li> </ul>';

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
        return view('Admin.Modules.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.Modules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ModuleRequest $request)
    {
        //
        try {
            $post = $request->all();
            $data = new module();
            $data->name = $request->name;
            $data->save();
            if (!empty($data)) {
                return response()->json(['status' => '1', 'success' => 'Data Added successfully.']);
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
            $data = module::find($id);
            if (!empty($data)) {
                return view('Admin.Modules.edit', compact('data'));
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
    public function update(ModuleRequest $request, string $id)
    {
        try {
            $data =  module::find($id);
            $data->name = $request->name;
            $data->save();
            if (!empty($data)) {
            return response()->json(['status' => '1', 'success' => 'Module edit Successfully']);
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
            $data =  module::find($id);
            $data->delete();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => 'Module deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
