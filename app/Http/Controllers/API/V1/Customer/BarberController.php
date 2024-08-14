<?php

namespace App\Http\Controllers\API\V1\Customer;

use Carbon\Carbon;
use App\Models\User;
use App\Models\MyFavorite;
use Illuminate\Http\Request;
use App\Models\BarberSchedule;
use App\Models\BarberServices;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Http\Resources\Api\Customer\BarberListResource;
use App\Http\Resources\Api\Customer\BarberDetailResource;

class BarberController extends Controller
{
    //
    public function getAllBarbers(Request $request)
    {
        try {
            $barber = User::with('barber_service','barber_rating')
                ->where('user_type', 3)
                ->where('is_approved', "2")
                ->where('is_delete', 0);

            if ($request->gender) {
                $barber->where('gender', $request->gender);
            }

            if ($request->search) {
                // $searchTerms = explode(' ', $request->search);
                $searchTerms = explode(' ', $request->search);
                $search = $request->search;

                $barber->where(function ($query) use ($search) {

                        $query->orWhere('first_name', 'like', '%' . $search . '%')
                            ->orWhere('last_name', 'like', '%' . $search . '%')
                            ->orWhere('salon_name', 'like', '%' . $search . '%');

                });
            }

            if ($request->service_id) {
                $barber->whereHas('barber_service', function ($query) use ($request) {
                    $query->whereIn('service_id', $request->service_id);
                });
            }

            $total = $barber->count();
            $barber_list = $barber->paginate(10);

            foreach ($barber_list as $barbers) {
                $barbers['encrypt_id'] = Crypt::encryptString($barbers->id);
                $barbers['average_rating'] = $barbers->averageRating();
            }

            if (!empty($barber_list)) {
                $data = BarberListResource::collection($barber_list);
                return response()->json([
                    'data' => $data,
                    'total' => $total,
                    'status' => 1,
                    'message' => __('message.Get barber list successfully.'),
                ], 200);
            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }
    }

    public function getBarberDetail(Request $request, $id)
    {
        try {

            $data = User::with('barber_rating')->find($id);
            $data['average_rating'] = $data->averageRating();
            $data['barber_services'] = BarberServices::with('service_detail', 'sub_service_detail')->where('barber_id', $id)->get();
            $data['barber_schedule'] = BarberSchedule::where('barber_id', $id)->first();
            if (auth('api')->check()) {
                $user = auth('api')->user();
                $is_favorite = MyFavorite::where('barber_id', $data->id)->where('user_id', $user->id)->first();
                if (!empty($is_favorite)) {
                    $is_favorite = 1;
                } else {
                    $is_favorite = 0;
                }
            } else {
                $is_favorite = 0;
            }
            $data['is_favorite'] = $is_favorite;

            if($data['barber_schedule'] != "") {
                    // Get the current day and time
                    $currentDay = strtolower(Carbon::now()->format('l')); // e.g., 'monday'
                    $currentTime = Carbon::now()->format('H:i:s'); // e.g., '14:00:00'

                    // Check if today is a holiday
                    $isHolidayField = "{$currentDay}_is_holiday";

                    if ($data['barber_schedule']->$isHolidayField) {
                        $data['salon_status'] = "closed";
                    }else{
                        // Get today's start and end times
                        $startTimeField = "{$currentDay}_start_time";
                        $endTimeField = "{$currentDay}_end_time";
                        $startTime = $data['barber_schedule']->$startTimeField;
                        $endTime = $data['barber_schedule']->$endTimeField;

                        // Check if current time is within the working hours
                        if ($currentTime >= $startTime && $currentTime <= $endTime) {
                            $data['salon_status'] = "open";
                        } else {
                            $data['salon_status'] = "closed";
                        }
                    }



            }else
            {
                $data['salon_status'] = "closed";
            }


            if (!empty($data)) {
               $result = new BarberDetailResource($data);
                return response()->json(
                [
                    'data' => $result,
                    'status' => 1,
                    'message' => __('message.Barber detail successfully'),
                ], 200);
        }


        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }
    }

}
