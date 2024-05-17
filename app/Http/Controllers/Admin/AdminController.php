<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Admin\AdminProfileRequest;

class AdminController extends Controller
{
    //

    public function adminLogin()
    {

        if(!empty((Auth::user()))) {
                if(Auth::user()->user_type  == 1)
                {
                    return redirect('admin/dashboard');
                }
        }else
        {
            return  view('Admin.login');
        }

    }


    public function storeLogin(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::AdminHome);
    }




    public function dashboard()
    {
          return view('Admin.dashboard');
    }

    public function setting(Request $request)
    {

            return view('Admin.account_setting', [
                'user' => $request->user(),
            ]);

    }

      /**
     * Update the user's profile information.
     */
    public function update(AdminProfileRequest $request)
    {

        $user = Auth::user();
        $data = User::find($user->id);

        // for Image
        if ($request->hasFile('profile_image')) {
            if($data->profile_image) {
             File::delete(public_path('profile_image/' . $data->profile_image));
            }
            $source = $_FILES['profile_image']['tmp_name'];
            if ($source) {
                $destinationFolder = public_path('profile_image'); // Specify the destination folder
                $image = $request->file('profile_image');
                $filename = time() . '_profile_image.' . $image->getClientOriginalExtension();
                if (!file_exists($destinationFolder)) {
                    mkdir($destinationFolder, 0777, true);
                }
                $destination = $destinationFolder . '/' . $filename;
                $profile_image = compressImage($source, $destination);
                $data->profile_image = $filename;
            }

        }


        $data->name = $request['name'];
        $data->email = $request['email'];
        $data->phone = $request['phone'];
        $data->save();
        if (!empty($data)) {
            return redirect()->route('setting');
            // return redirect()->route('setting')->with('success',__('message.Profile edit Successfully'));
            // return response()->json(['status' => '1', 'success' => 'Profile edit Successfully']);
        }
    }

    public function getChangePassword(Request $request)
    {
        return view('Admin.change_password', [
            'user' => $request->user(),
        ]);
    }

    public function storeChangePassword(Request $request)
    {

        $request->validate([
            'current_password' => 'required',
            'password' => 'required',
            'password_confirmation' => ['required', 'same:password'],
        ], [
            'current_password.required' => __('error.This field is required'),
            'password.required' => __('error.This field is required'),
            'password_confirmation.required' => __('error.This field is required'),
            'password_confirmation.same' => __('error.The password confirmation does not match the new password.'),
        ]);

        $pass = Hash::make($request->password);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return redirect()->route('setting')->with("error", __('message.Old Password Does not match!'));
        } else {
            $data = User::find(Auth::id())->update(array('password' => $pass));
            if (!empty($data)) {
                return redirect()->route('setting')->with('info', __('message.Password updated successfully.'));
            }
        }
    }

    public function languageChange(Request $request)
    {
        app()->setLocale($request->data);
        session()->put('locale', $request->data);
        return response()->json(['status' => 'success', 'success' => 'language change']);
    }


}
