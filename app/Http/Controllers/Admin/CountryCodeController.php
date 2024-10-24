<?php
namespace App\Http\Controllers\Admin;


use DataTables;
use App\Models\User;
use App\Models\CountryCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EditCountryCodeRequest;
use App\Http\Requests\Admin\CreateCountryCodeRequest;

class CountryCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    function __construct()
    {
        $this->middleware('permission:country-code-list', ['only' => ['index']]);
        $this->middleware('permission:country-code-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:country-code-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:country-code-delete', ['only' => ['destroy']]);
        $this->middleware('permission:country-code-status', ['only' => ['countryStatus']]);
    }

    public function index(Request $request)
    {

        //

        if ($request->ajax()) {
            $data = CountryCode::orderBy('id', 'DESC')->get();
            $locale = App::getLocale();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = "";
                    $btn = $btn . '<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                      <div class="btn-group" role="group">
                        <button class="btn btn-light dropdown-toggle text-primary" id="btnGroupDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';

                        if (auth()->user()->can('country-code-edit')) {
                            $btn = $btn . '<a class="edit-data dropdown-item"  href="javascript:void(0)" title="' . __('labels.Edit') . '" data-url="'.route('country-code.edit', $row->id).'">' . __('labels.Edit') . '</a>';
                        }
                        if (auth()->user()->can('country-code-delete')) {
                            $btn = $btn . '<a href="" data-url="' . route('country-code.destroy', $row->id) . '" class="dropdown-item destroy-data" title="' . __('labels.Delete') . '">' . __('labels.Delete') . '</a>';
                        }
                       $btn = $btn . '</div>
                      </div>
                    </div>';



                   return $btn;
                })

                ->addColumn('image', function ($data) {

                    if ($data['image']) {

                        // return '<img src=' . URL::to('/public') . '/frontend/assets/images/no-image.png' . ' class="img-thumbnail" width="40" height="45"/>';

                        return '<img src=' . URL::to('/public') . '/image/' . $data->image . ' class="img-thumbnail" width="40" height="45"/>';

                    } else {

                        return '<img src="' . URL::to('/public/frontend/assets/images/no-image.png') . '" class="img-thumbnail" width="40" height="45"/>';

                    }

                })



                ->rawColumns(['action','image'])
                ->make(true);
        }
        return view('Admin.Country-Code.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.Country-Code.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCountryCodeRequest $request)
    {
        //
        try {
            $post = $request->all();
            $data = new CountryCode();
            $data->name = $request->name;
            $data->short_name = $request->short_name;
            $data->phonecode = $request->phonecode;

            if ($request->hasFile('image')) {

                $source = $_FILES['image']['tmp_name'];
                if ($source) {
                    $destinationFolder = public_path('image'); // Specify the destination folder
                    $image = $request->file('image');
                    $filename = time() . '_image.' . $image->getClientOriginalExtension();
                    if (!file_exists($destinationFolder)) {
                        mkdir($destinationFolder, 0777, true);
                    }
                    $destination = $destinationFolder . '/' . $filename;
                    $image = compressImage($source, $destination);
                    $data->image = $filename;
                }
            }

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
            $data = CountryCode::find($id);
            if (!empty($data)) {
                return view('Admin.Country-Code.edit', compact('data'));
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
    public function update(EditCountryCodeRequest $request, string $id)
    {
        //
        try {

            $data =  CountryCode::find($id);

            $data->short_name = $request->short_name;
            $data->name = $request->name;
            $data->phonecode = $request->phonecode;
            if ($request->hasFile('image')) {

                $source = $_FILES['image']['tmp_name'];
                if ($source) {
                    $destinationFolder = public_path('image'); // Specify the destination folder
                    $image = $request->file('image');
                    $filename = time() . '_image.' . $image->getClientOriginalExtension();
                    if (!file_exists($destinationFolder)) {
                        mkdir($destinationFolder, 0777, true);
                    }
                    $destination = $destinationFolder . '/' . $filename;
                    $image = compressImage($source, $destination);
                    $data->image = $filename;
                }
            }

            $data->update();
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
            $data =  CountryCode::find($id);
            $data->delete();
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
            $data = CountryCode::find($id);
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
