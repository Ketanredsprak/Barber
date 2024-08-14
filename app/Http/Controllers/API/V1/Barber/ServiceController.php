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
                    // unset($service['service_image']);
                    unset($service[$service_name]);
                    $service['service_image'] = URL::to('/public') . '/service_image/' .$service['service_image'] ?? "";

                    $sub_services = Services::select('id',$service_name,'service_image')->where('parent_id',$service->id)->get();
                    foreach ($sub_services as $key => $sub_service) {

                        $sub_service['sub_service_name'] = $sub_service->$service_name ?? "";

                        //set price
                        $sub_service_detail = BarberServices::where('barber_id',$id)->where('sub_service_id',$sub_service->id)->first();
                        $sub_service['service_price'] = $sub_service_detail->service_price ?? 0;
                        // $sub_service['special_service'] = $sub_service_detail->special_service ?? 0;
                        $sub_service['service_image'] = URL::to('/public') . '/service_image/' .$sub_service->service_image ?? "";


                        // unset($sub_service['service_image']);
                        unset($sub_service[$service_name]);
                    }
                    $service['special_service'] = $sub_service_detail->special_service ?? 0;
                    $service['sub_service'] = $sub_services;

                }

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




    public function addAndUpdateServices(Request $request)
    {

        $validated['parent_service_ids'] = "required";
        $validated['sub_service_ids'] = "required|array";
        $validated['prices'] = "required|array";
        $validated['parent_special_services'] = "required|array";

        $customMessages = [
            'parent_service_ids.required' =>  __('error.This field is required'),
            'parent_service_ids.array' =>  __('error.This field is required'),
            'sub_service_ids.required' =>  __('error.This field is required'),
            'sub_service_ids.array' =>  __('error.This field is required'),
            'prices.required' => __('error.This field is required'),
            'prices.array' => __('error.This field is required'),
            'parent_special_services.required' => __('error.This field is required'),
            'parent_special_services.array' =>  __('error.This field is required'),
       ];

        $request->validate($validated, $customMessages);

        try {

            if($request->parent_service_ids) {

                $user = User::find(Auth::user()->id);


                foreach($request->parent_service_ids as $index => $parent_service_id) {
                    foreach($request->sub_service_ids[$index] as $key => $sub_service_id) {
                        $barberService = BarberServices::updateOrCreate(
                            [
                                'barber_id' => $user->id,
                                'sub_service_id' => $sub_service_id,
                            ],
                            [
                                'service_id' => $parent_service_id,
                                'service_price' => $request->prices[$index][$key],
                                'special_service' => $request->parent_special_services[$index],
                            ]
                        );
                    }
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


    public function getBarberProvideServices(Request $request)
    {
        try {
            $data_barber_services = BarberServices::where('barber_id', Auth::user()->id)->get();
            // Extract service_id into an array
            $service_ids = $data_barber_services->pluck('service_id')->toArray();

            // dd($service_ids);

            $language_code = $request->header('language');

            $service_name = "service_name_".$language_code;


            $data = Services::select('id',$service_name,'service_image') ->whereIn('id', $service_ids)->where("parent_id",0)->get();
            // dd($data);
              foreach($data  as $service)
                {
                    $service['service_name'] = $service->$service_name ?? "";
                    // unset($service['service_image']);
                    unset($service[$service_name]);
                    $service['service_image'] = URL::to('/public') . '/service_image/' .$service['service_image'] ?? "";

                    $sub_services = Services::select('id',$service_name,'service_image')->where('parent_id',$service->id)->get();
                    foreach ($sub_services as $key => $sub_service) {

                        $sub_service['sub_service_name'] = $sub_service->$service_name ?? "";

                        //set price
                        $sub_service_detail = BarberServices::where('barber_id',Auth::user()->id)->where('sub_service_id',$sub_service->id)->first();
                        $sub_service['service_price'] = $sub_service_detail->service_price ?? 0;
                        // $sub_service['special_service'] = $sub_service_detail->special_service ?? 0;
                        $sub_service['service_image'] = URL::to('/public') . '/service_image/' .$sub_service->service_image ?? "";


                        // unset($sub_service['service_image']);
                        unset($sub_service[$service_name]);
                    }
                    $service['special_service'] = $sub_service_detail->special_service ?? 0;
                    $service['sub_service'] = $sub_services;
                }

                  if ($data) {
                        return response()->json(
                          [
                              'data' => $data,
                              'status' => 1,
                              'message' => __('message.Data get Succesfully.'),
                          ], 200);
                  }

            } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }
    }



    public function deleteServiceFromBarber($id)
    {
        try {
                  $user = User::find(Auth::user()->id);
                  $data = BarberServices::where('service_id',$id)->where('barber_id',$user->id)->delete();
                  if ($data) {
                    return response()->json(
                      [
                          'status' => 1,
                          'message' => __('message.Service Deleted Successfully.'),
                      ], 200);
                  }else
                  {
                    return response()->json(
                        [
                            'status' => 0,
                            'message' => __('message.Record not found.'),
                        ], 400);
                  }
            } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }
    }











    // public function addAndUpdateServices(Request $request)
    // {

    //     $validated['subids'] = "required|array";
    //     $validated['prices'] = "required|array";
    //     $validated['special_services'] = "required|array";

    //     $customMessages = [
    //         'subids.required' =>  __('error.This field is required'),
    //         'subids.array' =>  __('error.This field is required'),
    //         'prices.required' => __('error.This field is required'),
    //         'prices.array' => __('error.This field is required'),
    //         'special_services.required' => __('error.This field is required'),
    //         'special_services.array' =>  __('error.This field is required'),
    //    ];

    //     $request->validate($validated, $customMessages);

    //     try {

    //         if($request->subids) {

    //                 foreach($request->subids as  $index=>$sub_service)
    //                 {
    //                     $service_data = Services::find($sub_service);
    //                     $user = User::find(Auth::user()->id);
    //                     $barberService = BarberServices::updateOrCreate(
    //                         [
    //                             'barber_id' => $user->id,
    //                             'sub_service_id' => $sub_service ?? 0,
    //                         ],
    //                         [
    //                             'service_id' => $service_data->parent_id,
    //                             'service_price' => $request->prices[$index] ?? 0,
    //                             'special_service' => $request->special_services[$index] ?? 0,
    //                         ]
    //                     );
    //                 }
    //                 if ($barberService) {
    //                       return response()->json(
    //                         [
    //                             'status' => 1,
    //                             'message' => __('message.Service Update Successfully.'),
    //                         ], 200);
    //                 }else
    //                 {
    //                       return response()->json(
    //                         [
    //                             'status' => 0,
    //                             'message' => __('message.Somthing went wrong'),
    //                         ], 200);
    //                 }


    //         }
    //     } catch (Exception $ex) {
    //         return response()->json(
    //             ['success' => 0, 'message' => $ex->getMessage()], 401
    //         );
    //     }
    // }



    public function getAllBarbers(Request $request)
    {
        try {

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }
    }


}
