<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DataTables;

class UserController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn = "<ul class='action'>";
                    if ($row->status == 1) {
                        $btn = $btn . '<li class="delete"> <a   href="javascript:void(0)" href="' . route('user.status', $row->id) . '" title="Deactivate" class="status-change" data-url="' . route('user.status', $row->id) . '"><i class="fa fa-close"></i></a>  &nbsp; </li> ';
                    } else {
                        $btn = $btn . ' <li class="edit"> <a   href="javascript:void(0)" href="' . route('user.status', $row->id) . '"   class="status-change" title="Activate" data-url="' . route('user.status', $row->id) . '"><i class="icon-check"></i></a></li> ';
                    }

                    if ($row->status == 0) {
                            $btn = $btn .  '<li class="edit"> <a class="edit-data"  href="javascript:void(0)" title="Edit" data-url="'.route('user.edit', $row->id).'"><i class="icon-pencil-alt"></i></a></li>';
                            $btn = $btn . ' <li class="delete"><a href="" data-url="' . route('user.destroy', $row->id) . '" class="destroy-data" title="Delete"> <i class="icon-trash"></i></a></li> </ul>';
                    }

                    $btn = $btn . '<ul>';
                   return $btn;
                })



                ->make(true);
        }
        return view('Admin.User.index');
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();

        return view('users.edit',compact('user','roles','userRole'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }

    public function destroy($id)
    {

        try {
            DB::beginTransaction();
            $data =  User::find($id);
            $data->is_delete  = 1;
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => 'User deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function userStatus($id)
    {
        try {
            DB::beginTransaction();
            $data = User::find($id);
            if ($data->status == 1) {
                $data->status = 0;
                $message = "Deactived";
            } else {
                $data->status = 1;
                $message = "Actived";
            }
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => 'User ' . $message . ' Successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
