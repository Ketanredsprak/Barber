<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\CountryCode;
use App\Models\Pagies;
use Illuminate\Http\Request;

class GenralController extends Controller
{

    public function getCountryCode()
    {
        try {

            $data = CountryCode::get();
            return response()->json(
                [
                    'data' => $data,
                    'message' => __('message.Data get Succesfully.'),
                    'status' => 1,
                ]
                , 200);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    public function getPageContent(Request $request)
    {

        $languege =  $request->header('language');
        $validated = [];
        $validated['page_name'] = "required";

        $customMessages = [
            'page_name.required' => __('error.This field is required.'),
        ];

        $request->validate($validated, $customMessages);

        try {
            // $data = Pagies::with('meta_content','cms_content')->where('key', $request->page_name)->first();

            $url = env('APP_URL');
            $url_final['url'] = $url."/get-cms-content/".$request->page_name."-".$languege;
            if (!empty($url_final)) {
                return response()->json(
                    [
                        'data' =>$url_final,
                        'status' => 1,
                        'message' =>  __('message.Data get successfully.'),
                    ], 200);
            } else {
                return response()->json(
                    [
                        'status' => 0,
                        'message' => __('message.Somthing went wrong'),
                    ], 200);

            }



        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

};
