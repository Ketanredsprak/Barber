<?php

namespace App\Http\Controllers\API\V1\Barber;

use App\Models\User;
use App\Models\Services;
use Illuminate\Http\Request;
use App\Models\BarberServices;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    //

    public function getAllServices(Request $request)
    {
        try {
            $id = Auth::user()->id;
            $language_code = $request->header('language');

            $service_name = "service_name_".$language_code;
               $data = Services::select('id',$service_name,'service_image')->where("parent_id",0)->get();
              foreach($data  as $service)
                {
                    $service['service_name'] = $service->$service_name ?? "";
                    unset($service['service_image']);
                    unset($service[$service_name]);
                    // $service['service_image'] = URL::to('/public') . '/service_image/' .$service->service_image ?? "";

                    $sub_services = Services::select('id',$service_name,'service_image')->where('parent_id',$service->id)->get();
                    foreach ($sub_services as $key => $sub_service) {

                        $sub_service['sub_service_name'] = $sub_service->$service_name ?? "";

                        //set price
                        $sub_service_detail = BarberServices::where('barber_id',$id)->where('sub_service_id',$sub_service->id)->first();
                        $sub_service['service_price'] = $sub_service_detail->service_price ?? 0;
                        $sub_service['special_service'] = $sub_service_detail->special_service ?? 0;


                        unset($sub_service['service_image']);
                        unset($sub_service[$service_name]);
                    }
                    $service['sub_service'] = $sub_services;

                }

              return response()->json(
                [
                    'data' => $data,
                    'message' => __('message.Data get Succesfully.'),
                    'status' => 0,
                ]
                , 200);


        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }


    }




    public function addAndUpdateServices(Request $request)
    {

        $validated['subids'] = "required|array";
        $validated['prices'] = "required|array";
        $validated['special_services'] = "required|array";

        $customMessages = [
            'subids.required' =>  __('error.This field is required'),
            'subids.array' =>  __('error.This field is required'),
            'prices.required' => __('error.This field is required'),
            'prices.array' => __('error.This field is required'),
            'special_services.required' => __('error.This field is required'),
            'special_services.array' =>  __('error.This field is required'),
       ];

        $request->validate($validated, $customMessages);

        try {

            if($request->subids) {

                    foreach($request->subids as  $index=>$sub_service)
                    {

                        $user = User::find(Auth::user()->id);
                        $barberService = BarberServices::updateOrCreate(
                            [
                                'barber_id' => $user->id,
                                'sub_service_id' => $sub_service ?? 0,
                            ],
                            [
                                'service_id' => 0,
                                'service_price' => $request->prices[$index] ?? 0,
                                'special_service' => $request->special_services[$index] ?? 0,
                            ]
                        );
                    }
                    if ($barberService) {
                          return response()->json(
                            [
                                'status' => 1,
                                'message' => __('message.Service Update Successfully.'),
                            ], 200);
                    }else
                    {
                          return response()->json(
                            [
                                'status' => 0,
                                'message' => __('message.Somthing went wrong'),
                            ], 200);
                    }


            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }
    }

}
