<?php
namespace App\Http\Controllers\Admin;


use DataTables;
use App\Models\User;
use App\Models\State;
use App\Models\Cities;
use App\Models\Countries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
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
                    $btn = "";
                    $btn = $btn . '<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                      <div class="btn-group" role="group">
                        <button class="btn btn-light dropdown-toggle text-primary" id="btnGroupDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';

                        if ($row->status == 1) {
                                $btn = $btn . '<a    href="' . route('city.status', $row->id) . '" title="' . __('labels.Inactive') . '" class="dropdown-item status-change" data-url="' . route('city.status', $row->id) . '">' . __('labels.Inactive') . '</a>';
                        }

                        else if ($row->status == 0) {
                                $btn = $btn . '<a   href="javascript:void(0)" href="' . route('city.status', $row->id) . '"   class="dropdown-item status-change" title="' . __('labels.Active') . '" data-url="' . route('city.status', $row->id) . '">' . __('labels.Active') . '</a>';
                        }
                        else
                        {
                                $btn = $btn . '<a   href="javascript:void(0)" href="' . route('city.status', $row->id) . '"   class="dropdown-item status-change" title="' . __('labels.Active') . '" data-url="' . route('city.status', $row->id) . '">' . __('labels.Active') . '</a>';
                        }

                       $btn = $btn . '<a class="edit-data dropdown-item"  href="javascript:void(0)" title="' . __('labels.Edit') . '" data-url="'.route('city.edit', $row->id).'">' . __('labels.Edit') . '</a>';
                       $btn = $btn . '<a href="" data-url="' . route('city.destroy', $row->id) . '" class="dropdown-item destroy-data" title="' . __('labels.Delete') . '">' . __('labels.Delete') . '</a>';

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

                ->addColumn('name', function ($row) {
                    $locale = App::getLocale();
                    $name = "name_".$locale;
                    return @$row->$name;
                })

                ->addColumn('state_name', function ($row) {
                    $locale = App::getLocale();
                    $name = "name_".$locale;
                    return @$row->state_data[$name];
               })


                ->rawColumns(['action','status','state_name','name'])
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
                return response()->json(['status' => '1', 'success' => __('message.City Added Successfully.')]);
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
            return response()->json(['status' => '1', 'success' => __('message.City Update Successfully.')]);
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
            return response()->json(['status' => '1', 'success' =>  __('message.City Deleted Successfully.')]);
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
                $message = __('message.City Deactived Successfully.');
            } else {
                $data->status = 1;
                $message = __('message.City Actived Successfully.');
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
