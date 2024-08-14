<?php

namespace App\Http\Controllers\API\V1\Barber;

use Illuminate\Http\Request;
use App\Models\BarberSchedule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BarberScheduleController extends Controller
{
    //
    public function addAndUpdateBarberSchedule(Request $request)
    {

        $id = Auth::user()->id;
        $language_code = $request->header('language');

        $validated = [];
        $validated['monday_is_holiday'] = "required";
        $validated['monday_start_time'] = "required_if:monday_is_holiday,0";
        $validated['monday_end_time'] = "required_if:monday_is_holiday,0";

        $validated['tuesday_is_holiday'] = "required";
        $validated['tuesday_start_time'] = "required_if:tuesday_is_holiday,0";
        $validated['tuesday_end_time'] = "required_if:tuesday_is_holiday,0";

        $validated['wednesday_is_holiday'] = "required";
        $validated['wednesday_start_time'] = "required_if:wednesday_is_holiday,0";
        $validated['wednesday_end_time'] = "required_if:wednesday_is_holiday,0";

        $validated['thursday_is_holiday'] = "required";
        $validated['thursday_start_time'] = "required_if:thursday_is_holiday,0";
        $validated['thursday_end_time'] = "required_if:thursday_is_holiday,0";

        $validated['friday_is_holiday'] = "required";
        $validated['friday_start_time'] = "required_if:friday_is_holiday,0";
        $validated['friday_end_time'] = "required_if:friday_is_holiday,0";

        $validated['saturday_is_holiday'] = "required";
        $validated['saturday_start_time'] = "required_if:saturday_is_holiday,0";
        $validated['saturday_end_time'] = "required_if:saturday_is_holiday,0";

        $validated['sunday_is_holiday'] = "required";
        $validated['sunday_start_time'] = "required_if:sunday_is_holiday,0";
        $validated['sunday_end_time'] = "required_if:sunday_is_holiday,0";

        $customMessages = [
            'monday_is_holiday.required' => __('error.This field is required.'),
            'monday_start_time.required' => __('error.This field is required.'),
            'monday_end_time.required' => __('error.This field is required.'),

            'tuesday_is_holiday.required' => __('error.This field is required.'),
            'tuesday_start_time.required' => __('error.This field is required.'),
            'tuesday_end_time.required' => __('error.This field is required.'),

            'wednesday_is_holiday.required' => __('error.This field is required.'),
            'wednesday_start_time.required' => __('error.This field is required.'),
            'wednesday_end_time.required' => __('error.This field is required.'),

            'thursday_is_holiday.required' => __('error.This field is required.'),
            'thursday_start_time.required' => __('error.This field is required.'),
            'thursday_end_time.required' => __('error.This field is required.'),

            'friday_is_holiday.required' => __('error.This field is required.'),
            'friday_start_time.required' => __('error.This field is required.'),
            'friday_end_time.required' => __('error.This field is required.'),

            'saturday_is_holiday.required' => __('error.This field is required.'),
            'saturday_start_time.required' => __('error.This field is required.'),
            'saturday_end_time.required' => __('error.This field is required.'),

            'sunday_is_holiday.required' => __('error.This field is required.'),
            'sunday_start_time.required' => __('error.This field is required.'),
            'sunday_end_time.required' => __('error.This field is required.'),

        ];

        $request->validate($validated, $customMessages);

        try {

               $barberSchedule = BarberSchedule::updateOrCreate(
                    [
                        'barber_id' => $id,
                    ],
                    [
                        'monday_is_holiday' => $request->monday_is_holiday,
                        'monday_start_time' => $request->monday_start_time ?? "",
                        'monday_end_time' => $request->monday_end_time ?? "",
                        'tuesday_start_time' => $request->tuesday_start_time ?? "",
                        'tuesday_is_holiday' => $request->tuesday_is_holiday,
                        'tuesday_end_time' => $request->tuesday_end_time ?? "",
                        'wednesday_is_holiday' => $request->wednesday_is_holiday,
                        'wednesday_start_time' => $request->wednesday_start_time ?? "",
                        'wednesday_end_time' => $request->wednesday_end_time ?? "",
                        'thursday_is_holiday' => $request->thursday_is_holiday,
                        'thursday_start_time' => $request->thursday_start_time ?? "",
                        'thursday_end_time' => $request->thursday_end_time ?? "",
                        'friday_is_holiday' => $request->friday_is_holiday,
                        'friday_start_time' => $request->friday_start_time ?? "",
                        'friday_end_time' => $request->friday_end_time ?? "",
                        'saturday_is_holiday' => $request->saturday_is_holiday,
                        'saturday_start_time' => $request->saturday_start_time ?? "",
                        'saturday_end_time' => $request->saturday_end_time ?? "",
                        'sunday_is_holiday' => $request->sunday_is_holiday,
                        'sunday_start_time' => $request->sunday_start_time ?? "",
                        'sunday_end_time' => $request->sunday_end_time ?? "",
                        'slot_duration' => "30:00",
                    ]
                );


                if ($barberSchedule) {
                    return response()->json(
                      [
                          'status' => 1,
                          'message' => __('message.Barber Schedule Update Successfully.'),
                      ], 200);
              }else
              {
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
}
