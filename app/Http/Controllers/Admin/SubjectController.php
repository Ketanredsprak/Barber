<?php
namespace App\Http\Controllers\Admin;


use DataTables;
use App\Models\User;
use App\Models\Subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EditSubjectRequest;
use App\Http\Requests\Admin\CreateSubjectRequest;

class SubjectController extends Controller
{

    function __construct()
    {
        // $this->middleware('permission:subject-list', ['only' => ['index']]);
        // $this->middleware('permission:subject-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:subject-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:subject-delete', ['only' => ['destroy']]);
        // $this->middleware('permission:subject-status', ['only' => ['subjectStatus']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //

        if ($request->ajax()) {
            $data = Subjects::where('is_delete',0)->orderBy('id', 'DESC')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = "";
                    $btn = $btn . '<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                      <div class="btn-group" role="group">
                        <button class="btn btn-light dropdown-toggle text-primary" id="btnGroupDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';

                        if ($row->status == 1) {
                                $btn = $btn . '<a    href="' . route('subject.status', $row->id) . '" title="' . __('labels.Inactive') . '" class="dropdown-item status-change" data-url="' . route('subject.status', $row->id) . '">' . __('labels.Inactive') . '</a>';
                        }

                        else if ($row->status == 0) {
                                $btn = $btn . '<a   href="javascript:void(0)" href="' . route('subject.status', $row->id) . '"   class="dropdown-item status-change" title="' . __('labels.Active') . '" data-url="' . route('subject.status', $row->id) . '">' . __('labels.Active') . '</a>';
                        }
                        else
                        {
                                $btn = $btn . '<a   href="javascript:void(0)" href="' . route('subject.status', $row->id) . '"   class="dropdown-item status-change" title="' . __('labels.Active') . '" data-url="' . route('subject.status', $row->id) . '">' . __('labels.Active') . '</a>';
                        }

                       $btn = $btn . '<a class="edit-data dropdown-item"  href="javascript:void(0)" title="' . __('labels.Edit') . '" data-url="'.route('subject.edit', $row->id).'">' . __('labels.Edit') . '</a>';
                       $btn = $btn . '<a href="" data-url="' . route('subject.destroy', $row->id) . '" class="dropdown-item destroy-data" title="' . __('labels.Delete') . '">' . __('labels.Delete') . '</a>';

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

                ->addColumn('is_special_subject', function ($row) {
                    if ($row->is_special_subject == 1) {
                        return '<span>' . __('labels.Special Subject') . '</span>';
                    } else {
                        return '';
                    }
                })


                ->addColumn('subject_name', function ($row) {

                
                    $language = config('app.locale');

                 
                    $subject_name = 'name_' . $language;

                   
                    return @$row->$subject_name;
                })


                ->rawColumns(['action','status','subject_name','is_special_subject'])
                ->make(true);
        }
        return view('Admin.Subjects.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.Subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSubjectRequest $request)
    {
        //
        try {
            $post = $request->all();
            $data = new Subjects();
            $data->name_en = $request->name_en;
            $data->name_ar = $request->name_ar;
            $data->name_ur = $request->name_ur;
            $data->name_tr = $request->name_tr;
        
            // $data->is_special_subject = $request->is_special_subject ?? 0;

            $data->status = 1;
            $data->save();
            if (!empty($data)) {
                return response()->json(['status' => '1', 'success' => __('message.Subject Added Successfully.')]);
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
            $data = Subjects::find($id);
            if (!empty($data)) {
                return view('Admin.Subjects.edit', compact('data'));
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
    public function update(EditSubjectRequest $request, string $id)
    {
        //
        try {


            $data =  Subjects::find($id);
            $data->name_en = $request->name_en;
            $data->name_ar = $request->name_ar;
            $data->name_ur = $request->name_ur;
            $data->name_tr = $request->name_tr;
            // $data->parent_id = $request->parent_id ?? 0;
            // $data->is_special_subject = $request->is_special_subject ?? 0;

       

            $data->save();
            if (!empty($data)) {
            return response()->json(['status' => '1', 'success' => __('message.Subject Update Successfully.')]);
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
            $data =  Subjects::find($id);
            $data->is_delete  = 1;
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' =>  __('message.Subject Deleted Successfully.')]);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function subjectStatus($id)
    {
        try {
            DB::beginTransaction();
            $data = Subjects::find($id);
            if ($data->status == 1) {
                $data->status = 0;
                $message = __('message.Subject Deactived Successfully.');
            } else {
                $data->status = 1;
                $message = __('message.Subject Actived Successfully.');
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
