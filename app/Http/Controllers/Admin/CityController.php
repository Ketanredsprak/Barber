<?php
namespace App\Http\Controllers\Admin;


use DataTables;
use App\Models\User;
use App\Models\State;
use App\Models\Cities;
use App\Models\Countries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CityRequest;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //

        if ($request->ajax()) {
            $data = Cities::with('state_data')->where('is_delete',0)->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn = "<ul class='action'>";
                    if ($row->status == 1) {
                        $btn = $btn . '<li class="delete"> <a   href="javascript:void(0)" href="' . route('city.status', $row->id) . '" title="Deactivate" class="status-change" data-url="' . route('city.status', $row->id) . '"><i class="fa fa-close"></i></a>  &nbsp; </li> ';
                    } else {
                        $btn = $btn . ' <li class="edit"> <a   href="javascript:void(0)" href="' . route('city.status', $row->id) . '"   class="status-change" title="Activate" data-url="' . route('city.status', $row->id) . '"><i class="icon-check"></i></a></li> ';
                    }

                    if ($row->status == 0) {
                            $btn = $btn .  '<li class="edit"> <a class="edit-data"  href="javascript:void(0)" title="Edit" data-url="'.route('city.edit', $row->id).'"><i class="icon-pencil-alt"></i></a></li>';
                            $btn = $btn . ' <li class="delete"><a href="" data-url="' . route('city.destroy', $row->id) . '" class="destroy-data" title="Delete"> <i class="icon-trash"></i></a></li> </ul>';
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


                ->addColumn('state_name', function ($row) {
                    return @$row->state_data['name_en'];
               })


                ->rawColumns(['action','status','state_name'])
                ->make(true);
        }
        return view('Admin.Cities.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.Cities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CityRequest $request)
    {
        //
        try {
            $post = $request->all();
            $data = new Cities();
            $data->name_en = $request->city_name_en;
            $data->name_ar = $request->city_name_ar;
            $data->name_ur = $request->city_name_ur;
            $data->state_id = $request->state_id;
            $data->country_id = $request->country_id;
            $data->status = 1;
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
            $data = Cities::find($id);
            $data_state = State::find($data->state_id);
            if (!empty($data)) {
                return view('Admin.Cities.edit', compact('data','data_state'));
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
    public function update(CityRequest $request, string $id)
    {
        //
        try {

            $data =  Cities::find($id);
            $data->name_en = $request->city_name_en;
            $data->name_ar = $request->city_name_ar;
            $data->name_ur = $request->city_name_ur;
            $data->state_id = $request->state_id;
            $data->country_id = $request->country_id;
            $data->save();
            if (!empty($data)) {
            return response()->json(['status' => '1', 'success' => 'City edit Successfully']);
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
            $data =  Cities::find($id);
            $data->is_delete  = 1;
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => 'City deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function cityStatus($id)
    {
        try {
            DB::beginTransaction();
            $data = Cities::find($id);
            if ($data->status == 1) {
                $data->status = 0;
                $message = "Deactived";
            } else {
                $data->status = 1;
                $message = "Actived";
            }
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => 'City ' . $message . ' Successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
