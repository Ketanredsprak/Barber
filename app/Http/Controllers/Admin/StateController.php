<?php

namespace App\Http\Controllers\Admin;


use DataTables;
use App\Models\User;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn = "<ul class='action'>";
                    if ($row->status == 1) {
                        $btn = $btn . '<li class="delete"> <a   href="javascript:void(0)" href="' . route('state.status', $row->id) . '" title="Deactivate" class="status-change" data-url="' . route('state.status', $row->id) . '"><i class="fa fa-close"></i></a>  &nbsp; </li> ';
                    } else {
                        $btn = $btn . ' <li class="edit"> <a   href="javascript:void(0)" href="' . route('state.status', $row->id) . '"   class="status-change" title="Activate" data-url="' . route('state.status', $row->id) . '"><i class="icon-check"></i></a></li> ';
                    }

                    if ($row->status == 0) {
                            $btn = $btn .  '<li class="edit"> <a class="edit-data"  href="javascript:void(0)" title="Edit" data-url="'.route('state.edit', $row->id).'"><i class="icon-pencil-alt"></i></a></li>';
                            $btn = $btn . ' <li class="delete"><a href="" data-url="' . route('state.destroy', $row->id) . '" class="destroy-data" title="Delete"> <i class="icon-trash"></i></a></li> </ul>';
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

                ->addColumn('country_name', function ($row) {
                     return @$row->country_data['name_en'];
                })



                ->rawColumns(['action','status','country_name'])
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

            $data->shortname = $request->state_short_name;
            $data->name_en = $request->state_name_en;
            $data->name_ar = $request->state_name_ar;
            $data->name_ur = $request->state_name_ur;
            $data->phonecode = $request->state_phone_code;
            $data->save();
            if (!empty($data)) {
            return response()->json(['status' => '1', 'success' => 'State edit Successfully']);
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
            return response()->json(['status' => '1', 'success' => 'state deleted successfully']);
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
                $message = "Deactived";
            } else {
                $data->status = 1;
                $message = "Actived";
            }
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => 'state ' . $message . ' Successfully']);
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
