<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Cms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;

class CmsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = Cms::where('is_delete',0)->orderBY('id','DESC')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn = "<ul class='action'>";
                    $btn = $btn .  '<li class="edit"> <a class="edit-data"  href="javascript:void(0)" title="Edit" data-url="'.route('cms.edit', $row->id).'"><i class="icon-pencil-alt"></i></a></li>  </ul>';
                    return $btn;

                })
                ->addColumn('title', function ($data) {
                    $title_array = json_decode($data['title'], true);
                    if (!empty($title_array['en']['title'])) {$data_blog_title = $title_array['en']['title'];} else { $data_blog_title = "No Data Found";}
                    $name = $data->id;
                    return $data_blog_title;
                })

                ->addColumn('id', function ($data) {
                    $name = $data->id;
                    return $name;
                })

                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return '<span class="badge bg-success">' . __('labels.Active') . '</span>';
                    } else {
                        return '<span class="badge bg-danger">' . __('labels.Inactive') . '</span>';
                    }
                })

                ->addColumn('title', function ($row) {
                    $locale = App::getLocale();
                    $title = "title_".$locale;
                    return @$row->$title;
                })


                ->addColumn('updated_at', function ($data) {
                    return date('Y-M-d h:i A', strtotime($data->updated_at));

                })
                ->rawColumns(['action', 'status', 'id','title'])
                ->make(true);
        }
        return view('Admin.Cms-Pages.index');

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

            $customMessages['content_en.required'] =  __('error.The english content is required.');
            $customMessages['content_ar.required'] =  __('error.The arabic content is required.');
            $customMessages['content_ur.required'] =  __('error.The urdu content is required.');
            $customMessages['content_tr.required'] =  __('error.The turkish content is required.');



        $request->validate($validated,$customMessages);

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
            $data = Cms::find($id);
            if (!empty($data)) {
                return view('Admin.Cms-Pages.edit', compact('data'));
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

            $validated['title_en'] = "required";
            $validated['title_ar'] = "required";
            $validated['title_ur'] = "required";
            $validated['title_tr'] = "required";
            $validated['content_en'] = "required";
            $validated['content_ar'] = "required";
            $validated['content_ur'] = "required";
            $validated['content_tr'] = "required";
            $customMessages['title_en.required'] = __('error.The english title is required.');
            $customMessages['title_ar.required'] = __('error.The urdu title is required.');
            $customMessages['title_ur.required'] = __('error.The arabic title is required.');
            $customMessages['title_tr.required'] = __('error.The turkish title is required.');
            $customMessages['content_en.required'] =  __('error.The english content is required.');
            $customMessages['content_ar.required'] =  __('error.The arabic content is required.');
            $customMessages['content_ur.required'] =  __('error.The urdu content is required.');
            $customMessages['content_tr.required'] =  __('error.The turkish content is required.');

            $request->validate($validated,$customMessages);

        try {
            $data = Cms::find($id);
            $data->title_en = $request->title_en;
            $data->title_ar = $request->title_ar;
            $data->title_ur = $request->title_ur;
            $data->title_tr = $request->title_tr;
            $data->content_en = $request->content_en;
            $data->content_ar = $request->content_ar;
            $data->content_ur = $request->content_ur;
            $data->content_tr = $request->content_tr;
            $data->update();

            if (!empty($data)) {
                    return response()->json(['status' => '1', 'success' =>  __('message.Record Update Successfully')]);
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
            return response()->json(['status' => '1', 'success' =>  __('message.Record Deleted Successfully')]);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function getCmsPageContent($id)
    {
        $numberArray = explode('-',$id);
        $data = Cms::where('slug',$numberArray[0])->first();
        if($data) {
            $title = json_decode($data['title']);
            $content = json_decode($data['content']);
            $language = $numberArray[1];
            $page_title = $title->$language->title ?? "";
            $page_content = $content->$language->content ?? "";
            return view('content', compact('data','page_title','page_content'));
        }
        else
        {
              echo "page not foound";
        }

    }



}
