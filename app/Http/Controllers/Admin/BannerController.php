<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateBannerRequest;
use App\Http\Requests\Admin\EditBannerRequest;
use App\Models\Banners;
use App\Models\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

class BannerController extends Controller
{

    public function __construct()
    {

        $this->middleware('permission:banner-list', ['only' => ['index']]);

        $this->middleware('permission:banner-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:banner-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:banner-delete', ['only' => ['destroy']]);

        $this->middleware('permission:banner-status', ['only' => ['bannerStatus']]);

    }

    /**

     * Display a listing of the resource.

     */

    public function index(Request $request)
    {

        //

        if ($request->ajax()) {

            $data = Banners::where('is_delete', 0)->orderBy('id', 'DESC')->get();

            return Datatables::of($data)->addIndexColumn()

                ->addColumn('action', function ($row) {

                    $btn = "";

                    $btn = $btn . '<div class="btn-group" role="group" aria-label="Button group with nested dropdown">

                      <div class="btn-group" role="group">

                        <button class="btn btn-light dropdown-toggle text-primary" id="btnGroupDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></button>

                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';

                    if (auth()->user()->can('banner-status')) {
                        if ($row->status == 1) {

                            $btn = $btn . '<a    href="' . route('banner.status', $row->id) . '" title="' . __('labels.Inactive') . '" class="dropdown-item status-change" data-url="' . route('banner.status', $row->id) . '">' . __('labels.Inactive') . '</a>';

                        } else if ($row->status == 0) {

                            $btn = $btn . '<a   href="javascript:void(0)" href="' . route('banner.status', $row->id) . '"   class="dropdown-item status-change" title="' . __('labels.Active') . '" data-url="' . route('banner.status', $row->id) . '">' . __('labels.Active') . '</a>';

                        } else {

                            $btn = $btn . '<a   href="javascript:void(0)" href="' . route('banner.status', $row->id) . '"   class="dropdown-item status-change" title="' . __('labels.Active') . '" data-url="' . route('banner.status', $row->id) . '">' . __('labels.Active') . '</a>';

                        }
                    }

                    if (auth()->user()->can('banner-edit')) {

                        $btn = $btn . '<a class="edit-data dropdown-item"  href="javascript:void(0)" title="' . __('labels.Edit') . '" data-url="' . route('banner.edit', $row->id) . '">' . __('labels.Edit') . '</a>';
                    }

                    if (auth()->user()->can('banner-delete')) {

                        $btn = $btn . '<a href="" data-url="' . route('banner.destroy', $row->id) . '" class="dropdown-item destroy-data" title="' . __('labels.Delete') . '">' . __('labels.Delete') . '</a>';

                    }

                    $btn = $btn . '</div>

                      </div>

                    </div>';

                    return $btn;

                })

                ->addColumn('banner_image', function ($data) {

                    if ($row['banner_image'] = null) {

                        return '<span class="badge badge-soft-success fs-12">no image</span>';

                    } else {

                        return '<img src=' . URL::to('/public') . '/banner_image/' . $data->banner_image . ' class="img-thumbnail" width="40" height="45"/>';

                    }

                })

                ->addColumn('status', function ($row) {

                    if ($row->status == 1) {

                        return '<span class="badge bg-success">' . __('labels.Active') . '</span>';

                    } else {

                        return '<span class="badge bg-danger">' . __('labels.Inactive') . '</span>';

                    }

                })

                ->addColumn('title', function ($row) {

                    $locale = App::getLocale();

                    $title = "title_" . $locale;

                    return @$row->$title;

                })

                ->addColumn('content', function ($row) {

                    $locale = App::getLocale();

                    $content = "content_" . $locale;

                    return @$row->$content;

                })

                ->addColumn('created_at', function ($data) {

                    return date('Y-M-d h:i A', strtotime($data->created_at));

                })

                ->rawColumns(['action', 'status', 'title', 'content', 'banner_image', 'created_at'])

                ->make(true);

        }

        return view('Admin.Banners.index');

    }

    /**

     * Show the form for creating a new resource.

     */

    public function create()
    {

        //

        return view('Admin.Banners.create');

    }

    /**

     * Store a newly created resource in storage.

     */

    public function store(CreateBannerRequest $request)
    {

        //

        try {

            $post = $request->all();

            $data = new Banners();

            $data->title_en = $request->title_en;

            $data->title_ar = $request->title_ar;

            $data->title_ur = $request->title_ur;

            $data->title_tr = $request->title_tr;

            $data->content_en = $request->content_en;

            $data->content_ar = $request->content_ar;

            $data->content_ur = $request->content_ur;

            $data->content_tr = $request->content_tr;

            $data->barber_id = $request->barber_id;

            $data->status = 1;

            if ($request->hasFile('banner_image')) {

                $source = $_FILES['banner_image']['tmp_name'];

                if ($source) {

                    $destinationFolder = public_path('banner_image'); // Specify the destination folder

                    $image = $request->file('banner_image');

                    $filename = time() . '_banner_image.' . $image->getClientOriginalExtension();

                    if (!file_exists($destinationFolder)) {

                        mkdir($destinationFolder, 0777, true);

                    }

                    $destination = $destinationFolder . '/' . $filename;

                    $banner_image = compressImage($source, $destination);

                    $data->banner_image = $filename;

                }

            }

            $data->save();

            if (!empty($data)) {

                return response()->json(['status' => '1', 'success' => __('message.Banner Added Successfully.')]);

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

            $data = Banners::find($id);

            if (!empty($data)) {

                return view('Admin.Banners.edit', compact('data'));

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

    public function update(EditBannerRequest $request, string $id)
    {

        //

        try {

            $data = Banners::find($id);

            $data->title_en = $request->title_en;

            $data->title_ar = $request->title_ar;

            $data->title_ur = $request->title_ur;

            $data->title_tr = $request->title_tr;

            $data->content_en = $request->content_en;

            $data->content_ar = $request->content_ar;

            $data->content_ur = $request->content_ur;

            $data->content_tr = $request->content_tr;

            $data->barber_id = $request->barber_id;

            if ($request->hasFile('banner_image')) {

                $source = $_FILES['banner_image']['tmp_name'];

                File::delete(public_path('banner_image/' . $data->banner_image));

                if ($source) {

                    $destinationFolder = public_path('banner_image'); // Specify the destination folder

                    $image = $request->file('banner_image');

                    $filename = time() . '_banner_image.' . $image->getClientOriginalExtension();

                    if (!file_exists($destinationFolder)) {

                        mkdir($destinationFolder, 0777, true);

                    }

                    $destination = $destinationFolder . '/' . $filename;

                    $banner_image = compressImage($source, $destination);

                    $data->banner_image = $filename;

                }

            }

            $data->save();

            if (!empty($data)) {

                return response()->json(['status' => '1', 'success' => __('message.Banner Update Successfully.')]);

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

            $data = Banners::find($id);

            $data->is_delete = 1;

            $data->update();

            DB::commit(); // Commit Transaction

            return response()->json(['status' => '1', 'success' => __('message.Banner Deleted Successfully.')]);

        } catch (\Exception $e) {

            DB::rollBack(); //Rollback Transaction

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        } catch (\Throwable $e) {

            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }

    }

    public function bannerStatus($id)
    {

        try {

            DB::beginTransaction();

            $data = Banners::find($id);

            if ($data->status == 1) {

                $data->status = 0;

                $message = __('message.Banner Deactived Successfully.');

            } else {

                $data->status = 1;

                $message = __('message.Banner Actived Successfully.');

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
