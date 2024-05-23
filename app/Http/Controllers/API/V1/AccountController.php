<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    //
     public function login(Request $request)
     {
        $validated = [];
        // $validated['login_type'] = "required";
        $validated['email'] = "required";
        $validated['password'] = "required_if:login_type,0";
        // $validated['device_type'] = "required";
        // $validated['fcm_token'] = "required";
        $request->validate($validated);

        try {

            $user = User::where("email", $request->email)->where("is_delete", 0)->first();

            if (!empty($user)) {

                    $data = [
                        'email' => $request->email,
                        'password' => $request->password,
                    ];


                    if (auth()->attempt($data)) {
                        $token =  auth()->user()->createToken('checking')->accessToken;
                        $array = Auth::user();


                        $array['token'] = $token;
                        $user->update();

                        //
                        $data = new AccountResource($array);
                        return response()->json(
                            [
                                'data' => $data,
                                'status' => 1,
                                'message' => "Login Successfully",
                            ], 200);
                    } else {
                        return response()->json(
                            [
                                'message' => 'Incorrect Email ID And Password..',
                                'status' => 0,
                            ]
                            , 200);
                    }

            } else {
                return response()->json(
                    [
                        'message' => 'Incorrect Email ID And Password..',
                        'status' => 0,
                    ]
                    , 200);
            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

     }
}
