<?php

namespace App\Http\Controllers\Admin;


use DataTables;
use App\Models\User;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StateRequest;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = State::with("country_data")->where('is_delete',0)->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = "";
                    $btn = $btn . '<div class="m-b-30">
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                      <div class="btn-group" role="group">
                        <button class="btn btn-light dropdown-toggle text-primary" id="btnGroupDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';

                        if ($row->status == 1) {
                                $btn = $btn . '<a    href="' . route('state.status', $row->id) . '" title="' . __('labels.Inactive') . '" class="dropdown-item status-change" data-url="' . route('state.status', $row->id) . '">' . __('labels.Inactive') . '</a>';
                        }

                        else if ($row->status == 0) {
                                $btn = $btn . '<a   href="javascript:void(0)" href="' . route('state.status', $row->id) . '"   class="dropdown-item status-change" title="' . __('labels.Active') . '" data-url="' . route('state.status', $row->id) . '">' . __('labels.Active') . '</a>';
                        }
                        else
                        {
                                $btn = $btn . '<a   href="javascript:void(0)" href="' . route('state.status', $row->id) . '"   class="dropdown-item status-change" title="' . __('labels.Active') . '" data-url="' . route('state.status', $row->id) . '">' . __('labels.Active') . '</a>';
                        }

                       $btn = $btn . '<a class="edit-data dropdown-item"  href="javascript:void(0)" title="' . __('labels.Edit') . '" data-url="'.route('state.edit', $row->id).'">' . __('labels.Edit') . '</a>';
                       $btn = $btn . '<a href="" data-url="' . route('state.destroy', $row->id) . '" class="dropdown-item destroy-data" title="' . __('labels.Delete') . '">' . __('labels.Delete') . '</a>';

                       $btn = $btn . '</div>
                      </div>
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

                ->addColumn('country_name', function ($row) {
                    $locale = App::getLocale();
                    $name = "name_".$locale;
                     return @$row->country_data[$name];
                })


                ->addColumn('name', function ($row) {
                    $locale = App::getLocale();
                    $name = "name_".$locale;
                     return @$row->$name;
                })



                ->rawColumns(['action','status','country_name','name'])
                ->make(true);
        }
        return view('Admin.States.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.States.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StateRequest $request)
    {
        //
        try {
            $post = $request->all();
            $data = new State();
            $data->name_en = $request->state_name_en;
            $data->name_ar = $request->state_name_ar;
            $data->name_ur = $request->state_name_ur;
            $data->country_id = $request->country_id;
            $data->status = 1;
            $data->save();
            if (!empty($data)) {
                return response()->json(['status' => '1', 'success' => __('message.State Added Successfully.')]);
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
            $data = State::find($id);
            if (!empty($data)) {
                return view('Admin.States.edit', compact('data'));
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
    public function update(StateRequest $request, string $id)
    {
        //
        try {
            $data =  State::find($id);
            $data->country_id = $request->country_id;
            $data->name_en = $request->state_name_en;
            $data->name_ar = $request->state_name_ar;
            $data->name_ur = $request->state_name_ur;
            $data->save();
            if (!empty($data)) {
            return response()->json(['status' => '1', 'success' => __('message.State Update Successfully.')]);
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
            $data =  State::find($id);
            $data->is_delete  = 1;
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => __('message.State Deleted Successfully.')]);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function stateStatus($id)
    {
        try {
            DB::beginTransaction();
            $data = State::find($id);
            if ($data->status == 1) {
                $data->status = 0;
                $message = __('message.State Deactived Successfully.');
            } else {
                $data->status = 1;
                $message = __('message.State Actived Successfully.');
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

    public function listState(request $request)
    {
        $state = State::where('country_id', $request->country)->get();
        return $state;
    }



}
