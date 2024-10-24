<?php

namespace App\Http\Controllers\API\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Customer\BarberDetailResource;
use App\Http\Resources\Api\Customer\BarberListResource;
use App\Http\Resources\Api\NearetBarberResource;
use App\Models\BarberSchedule;
use App\Models\BarberServices;
use App\Models\Booking;
use App\Models\BookingServiceDetail;
use App\Models\MyFavorite;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class BarberController extends Controller
{
    //
    // public function getAllBarbers(Request $request)
    // {

    //       // account delete,suspend and wiating for approved
    //       $response = checkUserStatus(Auth::user()->id);
    //       if ($response['status'] == 1) {
    //           return response()->json(
    //               [
    //                   'status' => 2,
    //                   'message' => $response['message'],
    //               ], 200);
    //       }
    //       // account delete,suspend and wiating for approved

    //     $validated = $request->validate([
    //         'latitude' => 'required',
    //         'longitude' => 'required',
    //     ], [
    //         'latitude.required' => __('error.The latitude field is required.'),
    //         'longitude.required' => __('error.The longitude field is required.'),
    //     ]);

    //     try {

    //         $userLatitude = $request->latitude;
    //         $userLongitude = $request->longitude;

    //         $barber = User::with('barber_service', 'barber_rating')
    //             ->where('user_type', 3)
    //             ->where('is_approved', "2")
    //             ->where('is_delete', 0)
    //             ->select('users.*', DB::raw("
    //             ( 6371 * acos( cos( radians($userLatitude) )
    //             * cos( radians( users.latitude ) )
    //             * cos( radians( users.longitude ) - radians($userLongitude) )
    //             + sin( radians($userLatitude) )
    //             * sin( radians( users.latitude ) ) ) )
    //             AS distance
    //         "))
    //             ->withAvg('barberRatings', 'rating')
    //             ->orderBy('distance');

    //         if ($request->gender) {
    //             $barber->where('gender', $request->gender);
    //         }

    //         if ($request->search) {
    //             // $searchTerms = explode(' ', $request->search);
    //             $searchTerms = explode(' ', $request->search);
    //             $search = $request->search;

    //             $barber->where(function ($query) use ($search) {

    //                 $query->orWhere('first_name', 'like', '%' . $search . '%')
    //                     ->orWhere('last_name', 'like', '%' . $search . '%')
    //                     ->orWhere('salon_name', 'like', '%' . $search . '%');

    //             });
    //         }

    //         if ($request->service_id) {
    //             $barber->whereHas('barber_service', function ($query) use ($request) {
    //                 $query->whereIn('service_id', $request->service_id);
    //             });
    //         }

    //         $total = $barber->count();
    //         $barber_list = $barber->paginate(10);

    //         foreach ($barber_list as $barbers) {
    //             $barbers['encrypt_id'] = Crypt::encryptString($barbers->id);
    //             $barbers['average_rating'] = $barbers->averageRating();
    //         }

    //         if (!empty($barber_list)) {
    //             $data = BarberListResource::collection($barber_list);
    //             return response()->json([
    //                 'data' => $data,
    //                 'total' => $total,
    //                 'status' => 1,
    //                 'message' => __('message.Get barber list successfully.'),
    //             ], 200);
    //         }

    //     } catch (Exception $ex) {
    //         return response()->json(
    //             ['success' => 0, 'message' => $ex->getMessage()], 401
    //         );
    //     }
    // }

    public function getAllBarbers(Request $request)
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

        $validated = $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ], [
            'latitude.required' => __('error.The latitude field is required.'),
            'longitude.required' => __('error.The longitude field is required.'),
        ]);

        try {

            $customer_lat = $request->latitude;
            $customer_long = $request->longitude;
            $currentDateFormatted = now()->format('Y-m-d');
            $currentHourFormatted = now()->format('H:i:s');
            $dayName = strtolower(Carbon::now()->format('l'));
            $currentDateTime = Carbon::now();
            $currentDateFormatted = $currentDateTime->format('Y-m-d');
            $currentHourFormatted = $currentDateTime->format('H:i:s');
            $endTime = $currentDateTime->copy()->addHours(3); // End time 3 hours from now

            // Initialize the query builder
            $query = User::query()
                ->select('users.*')
                ->with('barber_service', 'barber_rating', 'barber_schedule')
                ->where('user_type', 3)
                ->where('is_approved', "2")
                ->where('is_delete', 0)
                ->whereHas('barber_service') // Ensure barber_service is not null
                ->whereHas('barber_schedule'); // Ensure barber_schedule is not null

            // Apply distance calculation if coordinates are available
            if (!empty($customer_lat) && !empty($customer_long)) {
                $query->selectRaw("
                        ( 6371 * acos( cos( radians(?) ) * cos( radians( users.latitude ) )
                        * cos( radians( users.longitude ) - radians(?) ) + sin( radians(?) )
                        * sin( radians( users.latitude ) ) ) ) AS distance
                    ", [$customer_lat, $customer_long, $customer_lat])
                    ->whereNotNull('latitude') // Ensure latitude is set
                    ->whereNotNull('longitude'); // Ensure longitude is set

                // Optionally, order by distance
                $query->orderBy('distance', 'asc');
            }

            // Apply filters if provided
            if ($request->gender) {
                $query->where('gender', $request->gender);
            }

            if ($request->service_min_price || $request->service_max_price) {
                $query->whereHas('barber_service', function ($query) use ($request) {
                    $query->whereBetween('service_price', [$request->service_min_price, $request->service_max_price]);
                });
            }

            if ($request->search) {
                $names = explode(' ', $request->search);
                $query->where(function ($query) use ($request) {
                    $query->whereRaw(
                        'CONCAT(first_name, " ", last_name) LIKE ?',
                        ['%' . $request->search . '%']
                    );
                });

            }

            if ($request->salon_name) {
                $query->where('salon_name', 'like', '%' . $request->salon_name . '%');
            }

            if ($request->state_name) {
                $query->where('state_name', 'like', '%' . $request->state_name . '%');
            }

            if ($request->city_name) {
                $query->where('city_name', 'like', '%' . $request->city_name . '%');
            }

            if ($request->service_id) {
                $query->whereHas('barber_service', function ($query) use ($request) {
                    $query->where('sub_service_id', $request->service_id);
                });
            }

            // // Apply rating filter
            if ($request->rating != null) {
                $query->withAvg('barber_rating', 'rating');
                $rating = ($request->rating == 0) ? null : $request->rating;
                if ($rating == 0) {
                    $query->havingNull('barber_rating_avg_rating');
                } else {
                    $query->having('barber_rating_avg_rating', '>=', $rating)->having('barber_rating_avg_rating', '<', $rating + 1);
                }
            }

            // Paginate results
            $barber_list = $query->paginate(10);
            $total = $query->count();

            // new code check
            foreach ($barber_list as $barber) {

                $barber->average_rating = $barber->averageRating();
                $barber['encrypt_id'] = Crypt::encryptString($barber->id);
                if (!empty($customer_lat) || !empty($customer_long)) {
                    $barber['distance'] = round($barber->distance, 2); // Round distance to 2 decimal places
                }

                $dayName = strtolower(Carbon::now()->format('l')); // Get current day in lowercase
                $holiday = $dayName . "_is_holiday";
                $start_time = $dayName . "_start_time";
                $end_time = $dayName . "_end_time";

                if ($barber->barber_schedule) {
                    // If today is a holiday for the barber, set all parameters to 0
                    if ($barber->barber_schedule->$holiday == 0) {

                        ///checking current time and start time and checking current time + 3 and edn_time
                        if ($barber->barber_schedule->$start_time < $currentHourFormatted && $barber->barber_schedule->$end_time > $endTime->format('H:i:s')) {

                            $barber_id = $barber->id;

                            // Query for upcoming bookings and waitlist
                            $hasUpcomingBooking = Booking::where('barber_id', $barber_id)
                                ->where('booking_type', "booking")
                                ->where('booking_date', $currentDateFormatted)
                                ->whereBetween('start_time', [$currentHourFormatted, $endTime->format('H:i:s')])
                                ->exists();

                            $hasUpcomingWaitlist = Booking::where('barber_id', $barber_id)
                                ->where('booking_type', "waitlist")
                                ->where('booking_date', $currentDateFormatted)
                                ->exists();

                            // Check if the barber is fully booked for the next 3 hours
                            $slots = [];
                            $slotLimit = 6;
                            $slotDuration = 30 * 60; // 30 minutes in seconds

                            // Convert current time to timestamp
                            $startTime = strtotime($currentHourFormatted);

                            // Calculate the minutes part of the current time
                            $minutes = (int) date('i', $startTime);

                            // Calculate the next 30-minute mark
                            if ($minutes > 0 && $minutes <= 30) {
                                $nextSlotTime = strtotime(date('H', $startTime) . ":30:00");
                            } else {
                                // Round up to the next hour if minutes are above 30
                                $nextSlotTime = strtotime((date('H', $startTime) + 1) . ":00:00");
                            }

                            // Generate the slots
                            for ($i = 0; $i < $slotLimit; $i++) {
                                $slotFormatted = date("H:i:s", $nextSlotTime);
                                $slots[] = $slotFormatted;

                                // Check if the slot already exists in the database
                                $slotExists = BookingServiceDetail::whereHas('booking_detail', function ($query) use ($barber, $slotFormatted) {
                                    $query->where('barber_id', $barber->id);
                                })
                                    ->where('start_time', $slotFormatted)
                                    ->exists();

                                // Set a flag based on whether the slot exists
                                if ($slotExists) {
                                    $barber['full_booked'] = $slotExists ? 1 : 0;
                                } else {
                                    $barber['full_booked'] = $slotExists ? 1 : 0;
                                }

                                $nextSlotTime += $slotDuration; // Increment by 30 minutes
                            }
                            // Check if the barber is fully booked for the next 3 hours

                            // Set the parameters
                            $barber['has_upcoming_waitlist'] = $hasUpcomingWaitlist ? 1 : 0;
                            $barber['has_upcoming_booking'] = $hasUpcomingBooking ? 1 : 0;
                            $barber['is_holiday'] = 0;
                        } else {
                            $barber['is_holiday'] = 1;
                        }
                    } else {
                        $barber['is_holiday'] = 1;
                    }
                } else {
                    $barber['is_holiday'] = 1;
                }

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

    public function getBarberDetail(Request $request)
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

        $validated = $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'barber_id' => 'required',
        ], [
            'latitude.required' => __('error.The latitude field is required.'),
            'longitude.required' => __('error.The longitude field is required.'),
            'barber_id.required' => __('error.The barber id field is required.'),
        ]);

        try {
            $id = $request->barber_id;
            $userLatitude = $request->latitude;
            $userLongitude = $request->longitude;

            $data = User::with('barber_rating', 'barber_images')->find($id);
            if (!$data) {
                return response()->json([
                    'status' => 0,
                    'message' => __('error.Barber not found.'),
                ], 404);
            }

            // Calculate the distance using the Haversine formula
            $barberLatitude = $data->latitude;
            $barberLongitude = $data->longitude;

            $theta = $userLongitude - $barberLongitude;
            $dist = sin(deg2rad($userLatitude)) * sin(deg2rad($barberLatitude)) + cos(deg2rad($userLatitude)) * cos(deg2rad($barberLatitude)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $kilometers = $miles * 1.609344;

            $data['distance'] = $kilometers; // Store the distance in kilometers

            $data['average_rating'] = $data->averageRating();
            $data['barber_services'] = BarberServices::with('service_detail', 'sub_service_detail')->where('barber_id', $id)->get();
            $data['barber_schedule'] = BarberSchedule::where('barber_id', $id)->first();

            $url = env('APP_URL');
            $encrypt_id = Crypt::encryptString($id);
            $data['url'] = $url . "/barber-detail/" . $encrypt_id;

            if (auth('api')->check()) {
                $user = auth('api')->user();
                $is_favorite = MyFavorite::where('barber_id', $data->id)->where('user_id', $user->id)->first();
                $data['is_favorite'] = !empty($is_favorite) ? 1 : 0;
            } else {
                $data['is_favorite'] = 0;
            }

            if ($data['barber_schedule']) {
                // Get the current day and time
                $currentDay = strtolower(Carbon::now()->format('l')); // e.g., 'monday'
                $currentTime = Carbon::now()->format('H:i:s'); // e.g., '14:00:00'

                // Check if today is a holiday
                $isHolidayField = "{$currentDay}_is_holiday";

                if ($data['barber_schedule']->$isHolidayField) {
                    $data['salon_status'] = "closed";
                } else {
                    // Get today's start and end times
                    $startTimeField = "{$currentDay}_start_time";
                    $endTimeField = "{$currentDay}_end_time";
                    $startTime = $data['barber_schedule']->$startTimeField;
                    $endTime = $data['barber_schedule']->$endTimeField;

                    // Check if current time is within the working hours
                    $data['salon_status'] = ($currentTime >= $startTime && $currentTime <= $endTime) ? "open" : "closed";
                }
            } else {
                $data['salon_status'] = "closed";
            }

            $result = new BarberDetailResource($data);
            return response()->json([
                'data' => $result,
                'status' => 1,
                'message' => __('message.Barber detail successfully'),
            ], 200);

        } catch (Exception $ex) {
            return response()->json([
                'success' => 0,
                'message' => $ex->getMessage(),
            ], 401);
        }
    }

    public function searchNearBarber(Request $request)
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

        $validated = $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ], [
            'latitude.required' => __('error.The latitude field is required.'),
            'longitude.required' => __('error.The longitude field is required.'),
        ]);

        try {

            $userLatitude = $request->latitude;
            $userLongitude = $request->longitude;

            $topNearbyBarbers = User::with(['barber_service', 'barberRatings:barber_id,rating'])
                ->where([
                    ['user_type', 3],
                    ['is_approved', "2"],
                    ['is_delete', 0],
                ])
                ->whereNotNull('users.latitude')
                ->whereNotNull('users.longitude')
                ->select('users.*', DB::raw("
                    ( 6371 * acos( cos( radians($userLatitude) )
                    * cos( radians( users.latitude ) )
                    * cos( radians( users.longitude ) - radians($userLongitude) )
                    + sin( radians($userLatitude) )
                    * sin( radians( users.latitude ) ) ) )
                    AS distance
                "))
                ->withAvg('barberRatings', 'rating')
                ->orderBy('distance');

            if ($request->search) {
                $searchTerm = $request->search;

                $topNearbyBarbers->where(function ($query) use ($searchTerm) {
                    $query->where('users.location', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('users.salon_name', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere(function ($q) use ($searchTerm) {
                            $nameParts = explode(' ', $searchTerm, 2);
                            $firstName = $nameParts[0] ?? null;
                            $lastName = $nameParts[1] ?? null;

                            if ($firstName && $lastName) {
                                // Search by both first and last names in the 'users' table
                                $q->where('users.first_name', 'LIKE', '%' . $firstName . '%')
                                    ->where('users.last_name', 'LIKE', '%' . $lastName . '%');
                            } elseif ($firstName) {
                                // Search by first name only or last name only
                                $q->where('users.first_name', 'LIKE', '%' . $firstName . '%')
                                    ->orWhere('users.last_name', 'LIKE', '%' . $firstName . '%');
                            }
                        });
                });
            }

            $topNearbyBarbers = $topNearbyBarbers->take(20)->get();

            $topNearbyBarbers->each(function ($barber) {
                $barber['average_rating'] = $barber->barberRatings_avg_rating;
            });

            if (!empty($topNearbyBarbers)) {
                $result = NearetBarberResource::collection($topNearbyBarbers);
                return response()->json(
                    [
                        'data' => $result,
                        'status' => 1,
                        'message' => __('message.Barber list get successfully'),
                    ], 200);
            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }
    }

}
