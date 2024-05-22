<?php
namespace App\Http\Controllers\Admin;


use DataTables;
use App\Models\User;
use App\Models\Countries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CountryRequest;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    function __construct()
    {
        $this->middleware('permission:country-list', ['only' => ['index']]);
        $this->middleware('permission:country-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:country-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:country-delete', ['only' => ['destroy']]);
        // $this->middleware('permission:country-status', ['only' => ['countryStatus']]);
    }

    public function index(Request $request)
    {
        //

        if ($request->ajax()) {
            $data = Countries::where('is_delete',0)->get();
            $locale = App::getLocale();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = "";
                    $btn = $btn . '<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                      <div class="btn-group" role="group">
                        <button class="btn btn-light dropdown-toggle text-primary" id="btnGroupDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';

                        if ($row->status == 1) {
                                $btn = $btn . '<a    href="' . route('country.status', $row->id) . '" title="' . __('labels.Inactive') . '" class="dropdown-item status-change" data-url="' . route('country.status', $row->id) . '">' . __('labels.Inactive') . '</a>';
                        }

                        else if ($row->status == 0) {
                                $btn = $btn . '<a   href="javascript:void(0)" href="' . route('country.status', $row->id) . '"   class="dropdown-item status-change" title="' . __('labels.Active') . '" data-url="' . route('country.status', $row->id) . '">' . __('labels.Active') . '</a>';
                        }
                        else
                        {
                                $btn = $btn . '<a   href="javascript:void(0)" href="' . route('country.status', $row->id) . '"   class="dropdown-item status-change" title="' . __('labels.Active') . '" data-url="' . route('country.status', $row->id) . '">' . __('labels.Active') . '</a>';
                        }

                       $btn = $btn . '<a class="edit-data dropdown-item"  href="javascript:void(0)" title="' . __('labels.Edit') . '" data-url="'.route('country.edit', $row->id).'">' . __('labels.Edit') . '</a>';
                       $btn = $btn . '<a href="" data-url="' . route('barber.destroy', $row->id) . '" class="dropdown-item destroy-data" title="' . __('labels.Delete') . '">' . __('labels.Delete') . '</a>';

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
                   return  $row->$name;
                })






                ->rawColumns(['action','status'])
                ->make(true);
        }
        return view('Admin.Countries.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.Countries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CountryRequest $request)
    {
        //
        try {
            $post = $request->all();
            $data = new Countries();
            $data->name_en = $request->country_name_en;
            $data->name_ar = $request->country_name_ar;
            $data->name_ur = $request->country_name_ur;
            $data->shortname = $request->country_short_name;
            $data->phonecode = $request->country_phone_code;
            $data->status = 1;
            $data->save();
            if (!empty($data)) {
                return response()->json(['status' => '1', 'success' => __('message.Country Added Successfully.')]);
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
            $data = Countries::find($id);
            if (!empty($data)) {
                return view('Admin.Countries.edit', compact('data'));
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
    public function update(CountryRequest $request, string $id)
    {
        //
        try {

            $data =  Countries::find($id);

            $data->shortname = $request->country_short_name;
            $data->name_en = $request->country_name_en;
            $data->name_ar = $request->country_name_ar;
            $data->name_ur = $request->country_name_ur;
            $data->phonecode = $request->country_phone_code;
            $data->save();
            if (!empty($data)) {
            return response()->json(['status' => '1', 'success' => __('message.Country Update Successfully.')]);
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
            $data =  Countries::find($id);
            $data->is_delete  = 1;
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => __('message.Country Deleted Successfully.')]);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function countryStatus($id)
    {
        try {
            DB::beginTransaction();
            $data = Countries::find($id);
            if ($data->status == 1) {
                $data->status = 0;
                $message =  __('message.Country Deactived Successfully.');
            } else {
                $data->status = 1;
                $message = __('message.Country Actived Successfully.');
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
