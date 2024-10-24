<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateTestimonialRequest;
use App\Http\Requests\Admin\EditTestimonialRequest;
use App\Models\Testimonial;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

class TestimonialController extends Controller
{

    /**

     * Display a listing of the resource.

     */

    public function __construct()
    {

        $this->middleware('permission:testimonial-list', ['only' => ['index']]);

        $this->middleware('permission:testimonial-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:testimonial-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:testimonial-delete', ['only' => ['destroy']]);

        $this->middleware('permission:testimonial-status', ['only' => ['testimonialStatus']]);

    }

    public function index(Request $request)
    {

        //

        if ($request->ajax()) {

            $data = Testimonial::where('is_delete', 0)->orderBy('id', 'DESC')->get();

            $locale = App::getLocale();

            return Datatables::of($data)->addIndexColumn()

                ->addColumn('action', function ($row) {

                    $btn = "";

                    $btn = $btn . '<div class="btn-group" role="group" aria-label="Button group with nested dropdown">

                      <div class="btn-group" role="group">

                        <button class="btn btn-light dropdown-toggle text-primary" id="btnGroupDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></button>

                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';

                    if (auth()->user()->can('testimonial-status')) {
                        if ($row->status == 1) {

                            $btn = $btn . '<a    href="' . route('testimonial.status', $row->id) . '" title="' . __('labels.Inactive') . '" class="dropdown-item status-change" data-url="' . route('testimonial.status', $row->id) . '">' . __('labels.Inactive') . '</a>';

                        } else if ($row->status == 0) {

                            $btn = $btn . '<a   href="javascript:void(0)" href="' . route('testimonial.status', $row->id) . '"   class="dropdown-item status-change" title="' . __('labels.Active') . '" data-url="' . route('testimonial.status', $row->id) . '">' . __('labels.Active') . '</a>';

                        } else {

                            $btn = $btn . '<a   href="javascript:void(0)" href="' . route('testimonial.status', $row->id) . '"   class="dropdown-item status-change" title="' . __('labels.Active') . '" data-url="' . route('testimonial.status', $row->id) . '">' . __('labels.Active') . '</a>';

                        }
                    }

                    if (auth()->user()->can('testimonial-edit')) {
                        $btn = $btn . '<a class="edit-data dropdown-item"  href="javascript:void(0)" title="' . __('labels.Edit') . '" data-url="' . route('testimonial.edit', $row->id) . '">' . __('labels.Edit') . '</a>';
                    }
                    if (auth()->user()->can('testimonial-delete')) {
                        $btn = $btn . '<a href="" data-url="' . route('testimonial.destroy', $row->id) . '" class="dropdown-item destroy-data" title="' . __('labels.Delete') . '">' . __('labels.Delete') . '</a>';
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

                ->addColumn('image', function ($data) {

                    if ($row['testimonial_image'] = null) {

                        return '<span class="badge badge-soft-success fs-12">no image</span>';

                    } else {

                        return '<img src=' . URL::to('/public') . '/testimonial_image/' . $data->testimonial_image . ' class="img-thumbnail" width="40" height="45"/>';

                    }

                })

                ->addColumn('name', function ($row) {

                    $locale = App::getLocale();

                    $name = "name_" . $locale;

                    return $row->$name;

                })

                ->addColumn('designation', function ($row) {

                    $locale = App::getLocale();

                    $designation = "designation_" . $locale;

                    return $row->$designation;

                })

                ->rawColumns(['action', 'status', 'designation', 'image'])

                ->make(true);

        }

        return view('Admin.Testimonials.index');

    }

    /**

     * Show the form for creating a new resource.

     */

    public function create()
    {

        //

        return view('Admin.Testimonials.create');

    }

    /**

     * Store a newly created resource in storage.

     */

    public function store(CreateTestimonialRequest $request)
    {

        //

        try {

            $post = $request->all();

            $data = new Testimonial();

            $data->name_en = $request->name_en;

            $data->name_ar = $request->name_ar;

            $data->name_ur = $request->name_ur;

            $data->name_tr = $request->name_tr;

            $data->designation_en = $request->designation_en;

            $data->designation_ar = $request->designation_ar;

            $data->designation_ur = $request->designation_ur;

            $data->designation_tr = $request->designation_tr;

            $data->testimonial_content_en = $request->testimonial_content_en;

            $data->testimonial_content_ar = $request->testimonial_content_ar;

            $data->testimonial_content_ur = $request->testimonial_content_ur;

            $data->testimonial_content_tr = $request->testimonial_content_tr;

            $data->status = 1;

            if ($request->hasFile('testimonial_image')) {

                $source = $_FILES['testimonial_image']['tmp_name'];

                if ($source) {

                    $destinationFolder = public_path('testimonial_image'); // Specify the destination folder

                    $image = $request->file('testimonial_image');

                    $filename = time() . '_testimonial_image.' . $image->getClientOriginalExtension();

                    if (!file_exists($destinationFolder)) {

                        mkdir($destinationFolder, 0777, true);

                    }

                    $destination = $destinationFolder . '/' . $filename;

                    $testimonial_image = compressImage($source, $destination);

                    $data->testimonial_image = $filename;

                }

            }

            $data->save();

            if (!empty($data)) {

                return response()->json(['status' => '1', 'success' => __('message.Testimonial Added Successfully.')]);

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

            $data = Testimonial::find($id);

            if (!empty($data)) {

                return view('Admin.Testimonials.edit', compact('data'));

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

    public function update(EditTestimonialRequest $request, string $id)
    {

        //

        try {

            $data = Testimonial::find($id);

            $data->name_en = $request->name_en;

            $data->name_ar = $request->name_ar;

            $data->name_ur = $request->name_ur;

            $data->name_tr = $request->name_tr;

            $data->designation_en = $request->designation_en;

            $data->designation_ar = $request->designation_ar;

            $data->designation_ur = $request->designation_ur;

            $data->designation_tr = $request->designation_tr;

            $data->testimonial_content_en = $request->testimonial_content_en;

            $data->testimonial_content_ar = $request->testimonial_content_ar;

            $data->testimonial_content_ur = $request->testimonial_content_ur;

            $data->testimonial_content_tr = $request->testimonial_content_tr;

            // for Profile Image

            if ($request->hasFile('testimonial_image')) {

                File::delete(public_path('testimonial_image/' . $data->testimonial_image));

                $image = $request->file('testimonial_image');

                $uploaded = time() . '_testimonial_image.' . $image->getClientOriginalExtension();

                $destinationPath = public_path('/testimonial_image');

                $image->move($destinationPath, $uploaded);

                $data->testimonial_image = $uploaded;

            }

            $data->save();

            if (!empty($data)) {

                return response()->json(['status' => '1', 'success' => __('message.Testimonial Update Successfully.')]);

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

            $data = Testimonial::find($id);

            $data->is_delete = 1;

            $data->update();

            DB::commit(); // Commit Transaction

            return response()->json(['status' => '1', 'success' => __('message.Testimonial Deleted Successfully.')]);

        } catch (\Exception $e) {

            DB::rollBack(); //Rollback Transaction

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        } catch (\Throwable $e) {

            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }

    }

    public function testimonialStatus($id)
    {

        try {

            DB::beginTransaction();

            $data = Testimonial::find($id);

            if ($data->status == 1) {

                $data->status = 0;

                $message = __('message.Testimonial Deactived Successfully.');

            } else {

                $data->status = 1;

                $message = __('message.Testimonial Actived Successfully.');

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
