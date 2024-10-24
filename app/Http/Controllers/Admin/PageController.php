<?php



namespace App\Http\Controllers\Admin;



use DataTables;

use App\Models\Cms;

use App\Models\Pagies;

use App\Models\MetaContent;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\App;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Crypt;



class PageController extends Controller

{



    function __construct()

    {

        $this->middleware('permission:page-list', ['only' => ['index']]);

        $this->middleware('permission:page-edit', ['only' => ['edit', 'update']]);



    }





    /**

     * Display a listing of the resource.

     */

    public function index(Request $request)

    {

        //

        if ($request->ajax()) {

            $data = Pagies::orderBy('id', 'DESC')->get();

            return Datatables::of($data)->addIndexColumn()

                ->addColumn('action', function ($row) {

                    $alert_delete = "return confirm('Are you sure want to delete !')";

                    $btn = "<ul class='action'>";

                    $encrypted_Id = Crypt::encryptString($row->id);

                        $btn = "";
                    $btn = $btn . '
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                      <div class="btn-group" role="group">
                        <button class="btn btn-light dropdown-toggle text-primary" id="btnGroupDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';


                    if (auth()->user()->can('page-edit')) {
                        $btn = $btn . '<a href="' . route('page.edit', $encrypted_Id) . '"  class="dropdown-item show-data" title="' . __('labels.Edit') . '">' . __('labels.Edit') . '</a>';
                    }
                    $btn = $btn . '</div>
                      </div>
                    </div>';
                    return $btn;



                })

                ->make(true);

        }

        return view('Admin.Pagies.index');



    }



    /**

     * Show the form for creating a new resource.

     */

    public function create()

    {

        //

        return view('Admin.Cms-Pages.create');

    }



    /**

     * Store a newly created resource in storage.

     */

    public function store(Request $request)

    {

        //

        $validated = [];

        $validated['slug'] = "required";



        $validated['title_en'] = "required";

        $validated['title_ar'] = "required";

        $validated['title_ur'] = "required";

        $validated['title_tr'] = "required";



        $validated['content_en'] = "required";

        $validated['content_ar'] = "required";

        $validated['content_ur'] = "required";

        $validated['content_tr'] = "required";



        $customMessages['slug.required'] = __('error.This field is required');



        $customMessages['title_en.required'] = __('error.The english title is required.');

        $customMessages['title_ar.required'] = __('error.The urdu title is required.');

        $customMessages['title_ur.required'] = __('error.The arabic title is required.');

        $customMessages['title_tr.required'] = __('error.The turkish title is required.');



        $customMessages['content_en.required'] = __('error.The english content is required.');

        $customMessages['content_ar.required'] = __('error.The arabic content is required.');

        $customMessages['content_ur.required'] = __('error.The urdu content is required.');

        $customMessages['content_tr.required'] = __('error.The turkish content is required.');



        $request->validate($validated, $customMessages);



        try {

            $post = $request->all();

            $data = new Cms();

            $data->slug = $request->slug;

            $data->title_en = $request->title_en;

            $data->title_ar = $request->title_ar;

            $data->title_ur = $request->title_ur;

            $data->title_tr = $request->title_tr;

            $data->content_en = $request->content_en;

            $data->content_ar = $request->content_ar;

            $data->content_ur = $request->content_ur;

            $data->content_tr = $request->content_tr;

            $data->status = 1;

            $data->save();

            if (!empty($data)) {

                return response()->json(['status' => '1', 'success' => __('message.Record Added Successfully')]);

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

            $id = Crypt::decryptString($id);

            $data = Pagies::with("meta_content", "cms_content")->find($id);

            if (!empty($data)) {

                return view('Admin.Pagies.edit', compact('data'));

            }else

            {

                return view('errors.404');

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

    public function update(Request $request, string $id)

    {



        //

        $validated = [];



        $validated['meta_title_en'] = "required";

        $validated['meta_title_ar'] = "required";

        $validated['meta_title_ur'] = "required";

        $validated['meta_title_tr'] = "required";

        $validated['meta_content_en'] = "required";

        $validated['meta_content_ar'] = "required";

        $validated['meta_content_ur'] = "required";

        $validated['meta_content_tr'] = "required";

        $validated['page_name_en'] = "required";

        $validated['page_name_ar'] = "required";

        $validated['page_name_ur'] = "required";

        $validated['page_name_tr'] = "required";

        $validated['title_en.*'] = "required";

        $validated['title_ar.*'] = "required";

        $validated['title_ur.*'] = "required";

        $validated['title_tr.*'] = "required";

        $customMessages['page_name_en.required'] = __('error.The name is required.');

        $customMessages['page_name_ar.required'] = __('error.The name is required.');

        $customMessages['page_name_ur.required'] = __('error.The name is required.');

        $customMessages['page_name_tr.required'] = __('error.The name is required.');

        $customMessages['meta_title_en.required'] = __('error.The name is required.');

        $customMessages['meta_title_ar.required'] = __('error.The name is required.');

        $customMessages['meta_title_ur.required'] = __('error.The name is required.');

        $customMessages['meta_title_tr.required'] = __('error.The name is required.');

        $customMessages['meta_content_en.required'] = __('error.The name is required.');

        $customMessages['meta_content_ar.required'] = __('error.The name is required.');

        $customMessages['meta_content_ur.required'] = __('error.The name is required.');

        $customMessages['meta_content_tr.required'] = __('error.The name is required.');



        $request->validate($validated, $customMessages);



        try {

            $data = Pagies::find($id);

            $data->page_name_en = $request->page_name_en;

            $data->page_name_ar = $request->page_name_ar;

            $data->page_name_ur = $request->page_name_ur;

            $data->page_name_tr = $request->page_name_tr;

            $data->update();



            $meta_data = MetaContent::find($data->id);

            $meta_data->meta_title_en = $request->meta_title_en;

            $meta_data->meta_title_ar = $request->meta_title_ar;

            $meta_data->meta_title_ur = $request->meta_title_ur;

            $meta_data->meta_title_tr = $request->meta_title_tr;

            $meta_data->meta_content_en = $request->meta_content_en;

            $meta_data->meta_content_ar = $request->meta_content_ar;

            $meta_data->meta_content_ur = $request->meta_content_ur;

            $meta_data->meta_content_tr = $request->meta_content_tr;

            $meta_data->update();



            if ($request->record_ids) {

                foreach ($request->record_ids as $key => $id) {

                    $update_cms = Cms::find($id);

                    $update_cms->title_en = $request->title_en[$key];

                    $update_cms->title_ar = $request->title_ar[$key];

                    $update_cms->title_ur = $request->title_ur[$key];

                    $update_cms->title_tr = $request->title_tr[$key];

                    $update_cms->sub_title_en = $request->sub_title_en[$key];

                    $update_cms->sub_title_ar = $request->sub_title_ar[$key];

                    $update_cms->sub_title_ur = $request->sub_title_ur[$key];

                    $update_cms->sub_title_tr = $request->sub_title_tr[$key];

                    $update_cms->content_en = $request->content_en[$key] ?? "";

                    $update_cms->content_ar = $request->content_ar[$key] ?? "";

                    $update_cms->content_ur = $request->content_ur[$key] ?? "";

                    $update_cms->content_tr = $request->content_tr[$key] ?? "";



                    $cms_image = $request->cms_image[$id] ?? "";

                    if ($cms_image) {



                        $uploaded = time() . '_' . uniqid() . '_cms_image.' . $cms_image->getClientOriginalExtension();

                        $destinationPath = public_path('/cms_image');

                        if (!file_exists($destinationPath)) {

                            mkdir($destinationPath, 0777, true);

                        }

                        $cms_image->move($destinationPath, $uploaded);

                        $update_cms->cms_image = $uploaded;



                    }

                    $update_cms->update();



                }

            }



            if (!empty($data)) {

                return response()->json(['status' => '1', 'success' => __('message.Record Update Successfully')]);

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

            // Cms::find($id)->delete();

            $data = Cms::find($id);

            $data->is_delete = 1;

            $data->update();

            DB::commit(); // Commit Transaction

            return response()->json(['status' => '1', 'success' => __('message.Record Deleted Successfully')]);

        } catch (\Exception $e) {

            DB::rollBack(); //Rollback Transaction

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        } catch (\Throwable $e) {

            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }

    }



}

