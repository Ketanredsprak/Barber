<?php

namespace App\Http\Controllers\API\V1;

use App\Models\CountryCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


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



};
