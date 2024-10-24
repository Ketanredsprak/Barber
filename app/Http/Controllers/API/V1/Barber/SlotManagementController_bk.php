<?php

namespace App\Http\Controllers\API\V1\Barber;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Barber\DisableSlotListResource;
use App\Models\BarberSlotDisable;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SlotManagementController extends Controller
{

    public function enableOrDisableBarberSlot(Request $request)
    {
        // account delete,suspend and wiating for approved
        $response = checkUserStatus(Auth::user()->id);
        if ($response['status'] == 1) {
            return response()->json(
                [
                    'status' => 2,
                    'message' => $response['message'],
                ], 200);
        }
        // account delete,suspend and wiating for approved

        $validated = [];
        $validated['date'] = "required";
        $validated['all_slot'] = "required";

        $customMessages = [
            'barber_id.required' => __('error.The barber id field is required.'),
            'all_slot.required' => __('error.The all slot field is required.'),
        ];

        $request->validate($validated, $customMessages);

        try {

            // Checking for existing bookings
            if ($request->all_slot == "1") {
                $booking = Booking::where('barber_id', Auth::user()->id)
                    ->where('booking_date', $request->date)
                    ->first();
                $message = __('message.Customer appointment is booked for this date, so you cannot disable slot for this date.');
            } else {
                $query = Booking::where('barber_id', Auth::user()->id)
                    ->where('booking_date', $request->date);
                if (!empty($request->slot)) {
                    $query->where('start_time', $request->slot);
                }
                $booking = $query->first();
                $message = __('message.Customer appointment is booked for this slot, so you cannot disable this slot.');
            }
            // Checking for existing bookings

            //main api start
            if ($booking == null) {

                if ($request->all_slot == "1") {

                    BarberSlotDisable::where('barber_id', Auth::user()->id)->where('date', $request->date)->where('all_slots', 1)->delete();
                    BarberSlotDisable::where('barber_id', Auth::user()->id)->where('date', $request->date)->delete();

                    $data = new BarberSlotDisable();
                    $data->barber_id = Auth::user()->id;
                    $data->all_slots = "1";
                    $data->disable_type = "1";
                    $data->slot = null;
                    $data->date = $request->date;
                    $data->start_date = null;
                    $data->end_date = null;
                    $data->save();

                    return response()->json([
                        'status' => 1,
                        'message' => __('message.Slot disabled successfully.'),
                    ], 200);

                } else {
                    // If only a specific slot is to be disabled
                    // Check if the slot already exists in the database

                    if ($request->slot) {
                        $existingRecord = BarberSlotDisable::where('barber_id', Auth::user()->id)
                            ->where('date', $request->date)
                            ->where('slot', $request->slot)
                            ->first();

                        if ($existingRecord == null) {
                            // No record found, so insert a new one
                            $data = new BarberSlotDisable();
                            $data->barber_id = Auth::user()->id;
                            $data->all_slots = "0";
                            $data->disable_type = "0";
                            $data->slot = $request->slot;
                            $data->date = $request->date;
                            $data->start_date = null;
                            $data->end_date = null;
                            $data->save();

                            return response()->json([
                                'status' => 1,
                                'message' => __('message.Slot disabled successfully.'),
                            ], 200);
                        } else {
                            // Existing record found, so delete it
                            $existingRecord->delete();

                            return response()->json([
                                'status' => 1,
                                'message' => __('message.Slot enabled successfully.'),
                            ], 200);
                        }

                    } else {
                        BarberSlotDisable::where('barber_id', Auth::user()->id)
                            ->where('date', $request->date)->delete();

                        return response()->json([
                            'status' => 1,
                            'message' => __('message.Slot enabled successfully.'),
                        ], 200);

                    }
                }

            } else {
                return response()->json([
                    'status' => 0,
                    'message' => $message,
                ], 200);
            }
            //main api end

        } catch (Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage(),
            ]);
        }
    }

    public function getDisableSlotList(Request $request)
    {


         // account delete,suspend and wiating for approved
         $response = checkUserStatus(Auth::user()->id);
         if ($response['status'] == 1) {
             return response()->json(
                 [
                     'status' => 2,
                     'message' => $response['message'],
                 ], 200);
         }
         // account delete,suspend and wiating for approved

        // account delete,suspend and wiating for approved
        $response = checkUserStatus(Auth::user()->id);
        if ($response['status'] == 1) {
            return response()->json(
                [
                    'status' => 2,
                    'message' => $response['message'],
                ], 200);
        }
        // account delete,suspend and wiating for approved

        $validated = [];
        // $validated['barber_id'] = "required";
        $validated['date'] = "required";
        $validated['barber_id'] = "required";

        $customMessages = [
            'date.required' => __('error.The date field is required.'),
            'barber_id.required' => __('error.The barber id field is required.'),
        ];

        $request->validate($validated, $customMessages);

        try {
            $barber_id = $request->barber_id;
            $date = $request->date;

            // Check for manually disabled slots
            $query1 = BarberSlotDisable::where('barber_id', $barber_id)->where('date', $date)->where('all_slots', 0)->get();

            // Check for fully disabled slots for the entire day
            $query2 = BarberSlotDisable::where('barber_id', $barber_id)->where('date', $date)->where('all_slots', 1)->first();

            // Check if the date is between start_date and end_date
            $query3 = BarberSlotDisable::where('barber_id', $barber_id)->where('start_date', '<=', $date)->where('end_date', '>=', $date)->first();

            $result = [];
            $result1 = "0";

            // Combine the results
            if ($query1->isNotEmpty()) {
                // If there are manually disabled slots, use these results
                $result = DisableSlotListResource::collection($query1);
            }

            if ($query2) {
                // If the entire day is disabled, override the result with an empty array
                $result = [];
                $result1 = "1";
            }

            if ($query3) {
                // If the date falls within a disabled range, override the result with an empty array
                $result = [];
                $result1 = "1";
            }

            return response()->json(
                [
                    'disable_slot_list' => $result,
                    'full_day_disable' => $result1,
                    'message' => __('message.Data get successfully.'),
                    'status' => 1,
                ]
                , 200);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }

    }

    public function enableOrDisableBarberSlotDateRange(Request $request)
    {

         // account delete,suspend and wiating for approved
         $response = checkUserStatus(Auth::user()->id);
         if ($response['status'] == 1) {
             return response()->json(
                 [
                     'status' => 2,
                     'message' => $response['message'],
                 ], 200);
         }
         // account delete,suspend and wiating for approved


        $validated = [];
        $validated['start_date'] = "required";
        $validated['end_date'] = "required";

        $customMessages = [
            'start_date.required' => __('error.The date field is required.'),
            'end_date.required' => __('error.The date field is required.'),
        ];

        $request->validate($validated, $customMessages);

        try {

            $barber_id = Auth::user()->id;
            $start_date = $request->start_date;
            $end_date = $request->end_date;

            $booking = Booking::where('barber_id', Auth::user()->id)->whereBetween('booking_date', [$start_date, $end_date])->first();
            if ($booking) {
                $message = __('message.Customer appointment are booked between this start and end date range, so you can not disable slot for this range.');
                return response()->json(
                    [
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'message' => $message,
                        'status' => 0,
                    ]
                    , 200);
            }

            // Check if the given date range overlaps with any existing record
            $data_check = BarberSlotDisable::where('barber_id', $barber_id)
                ->where(function ($query) use ($start_date, $end_date) {
                    $query->whereBetween('start_date', [$start_date, $end_date])
                        ->orWhereBetween('end_date', [$start_date, $end_date]);
                })
                ->first();

            if (!$data_check) {

                // No overlap found, insert the new record
                $data = new BarberSlotDisable();
                $data->barber_id = $barber_id;
                $data->start_date = $start_date;
                $data->end_date = $end_date;
                $data->disable_type = "2";
                $data->all_slots = "0";
                $data->save();

                return response()->json(
                    [
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'message' => __('message.Slot disable successfully.'),
                        'status' => 1,
                    ]
                    , 200);

            } else {

                // Overlap found, do not insert
                return response()->json(
                    [
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'message' => __('message.Record already exists for the given date range.'),
                        'status' => 1,
                    ]
                    , 200);

            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }

    }

}
