<?php

namespace App\Http\Controllers\API\V1\Customer;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Chats;
use App\Models\Booking;
use App\Models\Services;
use App\Models\WaitList;
use App\Models\BarberRating;
use Illuminate\Http\Request;
use App\Models\BarberProposal;
use App\Models\BarberSchedule;
use App\Models\BarberServices;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\BookingServiceDetail;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Api\Customer\CustomerBookingResource;
use App\Http\Resources\Api\Customer\BookingJoinServiceResource;
use App\Http\Resources\Api\Customer\WaitListNewProposalsResource;
use App\Http\Resources\Api\Customer\CustomerBookingDetailResource;

class BookingController extends Controller
{

    public function booking(Request $request)
    {

        $validated = [];
        $validated['barber_id'] = "required";
        $validated['service_ids'] = "required|array";
        $validated['booking_date'] = "required";
        $validated['slots'] = "required|array";

        $customMessages = [
            'barber_id.required' => __('error.The barber id field is required.'),
            'service_ids.required' => __('error.The service ids field is required.'),
            'booking_date.required' => __('error.The booking date field is required.'),
            'slots.required' => __('error.The time field is required.'),
        ];

        $request->validate($validated, $customMessages);

        try {

            // Initialize variables
            $startTime = null;
            $endTime = null;

            // Loop through the array
            foreach ($request->slots as $index => $slot) {
                // Split the time range by " - "
                list($start, $end) = explode('-', $slot);

                // Set the first start time
                if ($index === 0) {
                    $startTime = $start;
                }

                // Always update the last end time
                $endTime = $end;
            }

            $booking = new Booking();
            $booking->user_id = Auth::user()->id;
            $booking->barber_id = $request->barber_id;
            $booking->booking_date = $request->booking_date;
            $booking->total_price = 0;
            $booking->start_time = $startTime;
            $booking->end_time = $endTime;
            $booking->save();

            if ($booking) {

                $total = 0;
                foreach ($request->service_ids as $key => $service_id) {

                    list($start, $end) = explode('-', $request->slots[$key]);

                    $service_detail = Services::find($service_id);
                    $service_more_detail = BarberServices::where('sub_service_id', $service_id)->where('barber_id', $request->barber_id)->first();

                    $total = $service_more_detail->service_price + $total;

                    $booking_service_detail = new BookingServiceDetail();
                    $booking_service_detail->booking_id = $booking->id;
                    $booking_service_detail->main_service_id = $service_detail->parent_id;
                    $booking_service_detail->service_id = $service_id;
                    $booking_service_detail->service_name_en = $service_detail->service_name_en ?? "";
                    $booking_service_detail->service_name_ar = $service_detail->service_name_ar ?? "";
                    $booking_service_detail->service_name_ur = $service_detail->service_name_ur ?? "";
                    $booking_service_detail->service_name_tr = $service_detail->service_name_tr ?? "";
                    $booking_service_detail->price = $service_more_detail->service_price;
                    $booking_service_detail->start_time = $start;
                    $booking_service_detail->end_time = $end;
                    $booking_service_detail->save();

                }

            }

            $booking->total_price = $total;
            $booking->update();

            sendEmail($booking->user_id,'booking',$booking->id);

            if (!empty($booking)) {
                return response()->json(['status' => 1, 'message' => __('message.Booking succusfully wait for barber accept...')]);
            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }

    }

    public function barberBookingList(Request $request)
    {

        $validated = [];
        $validated['barber_id'] = "required";
        $validated['booking_date'] = "required";

        $customMessages = [
            'barber_id.required' => __('error.The barber id field is required.'),
            'booking_date.required' => __('error.The booking date field is required.'),
        ];

        $request->validate($validated, $customMessages);

        try {

            $booking_ids = Booking::where('barber_id', $request->barber_id)->where('status','accept')->pluck('id')->toArray();

            $data = BookingServiceDetail::with('booking_detail')
                ->whereIn('booking_id', $booking_ids)
                ->whereHas('booking_detail', function ($query) use ($request) {
                    $query->where('barber_id', $request->barber_id)
                        ->where('booking_date', $request->booking_date);
                })
                ->select('booking_id', 'start_time', 'end_time')
                ->whereNotNull('start_time')
                ->whereNotNull('end_time')
                ->get();

            foreach ($data as $item) {

                    $results[] = [
                        'booking_id' => $item->booking_id,
                        'booking_date' => $item->booking_detail->booking_date ?? "",
                        'start_time' => $item->start_time,
                        'end_time' => $item->end_time,
                    ];
            }

            return response()->json(
                [
                    'data' => $results ?? [],
                    'status' => 1,
                    'message' => __('message.Data get successfully.'),
                ], 200);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }

    }

    public function getAllCustomerAppointments(Request $request)
    {

        $validated = $request->validate(
            ['status' => 'required'],
            ['status.required' => __('error.The status field is required.')]
        );

        try {
            $currentDate = Carbon::now()->toDateString(); // Current date
            $currentTime = Carbon::now()->toTimeString(); // Current time

            $query = Booking::with('customer_detail', 'booking_service_detailss','barber_proposal')->where('user_id', Auth::user()->id)->orderBy('id', 'DESC');

            if ($request->status == "appointment") {
                $query->where(function ($q) use ($currentDate, $currentTime) {
                    $q->where('booking_date', '>=', $currentDate)
                        ->orWhere(function ($q) use ($currentDate, $currentTime) {
                            $q->where('booking_date', '>=', $currentDate)
                                ->where('start_time', '>=', $currentTime);
                        });
                });

                $total = $query->count();
                $data = $query->paginate(10);

            } elseif ($request->status == "history") {
                $query->where('status', 'finished');

                $total = $query->count();
                $data = $query->paginate(10);

            }
            else
            {
                $query->where('status', 'pending')->where('booking_type', 'waitlist')->whereNull('start_time')->whereNull('end_time');

                $total = $query->count();
                $data = $query->paginate(10);

            }

            foreach ($data as $record) {
                $rating = BarberRating::where('barber_id', $record->barber_id)->avg('rating');
                $record->average_rating = $rating ? number_format($rating, 1) : "0"; // Add average rating to each item
            }


            if ($data->isNotEmpty()) {
                $results = CustomerBookingResource::collection($data);
                return response()->json([
                    'data' => $results,
                    'total' => $total,
                    'status' => 1,
                    'message' => __('message.Data get successfully.'),
                ], 200);
            } else {
                return response()->json([
                    'data' => [],
                    'total' => 0,
                    'status' => 1,
                    'message' => __('message.No data available.'),
                ], 200);
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()], 400
            );
        }
    }

    public function getCustomerAppointmentDetail($id)
    {
        try {
            $data = Booking::with('customer_detail', 'booking_service_detailss.main_service', 'booking_service_detailss.sub_service')->where('user_id', Auth::user()->id)->find($id);

            if($data->status = "accept")
            {
                  $chat_detail = Chats::where('user_id1',$data->user_id)->where('user_id2',$data->barber_id)->first();
                  $data['chat_unique_key'] = $chat_detail->chat_unique_key;
            }

            if (!$data) {
                return response()->json([
                    'status' => 0,
                    'message' => __('message.Booking not found.'),
                ], 404);
            }

            // Assume $data->booking_date, $data->start_time, and $data->end_time are provided
            $bookingDate = $data->booking_date; // e.g., '2024-07-31'
            $startTime = $data->start_time; // e.g., '11:30:00'
            $endTime = $data->end_time; // e.g., '12:30:00'

            // Get current date and time
            $currentDateTime = Carbon::now();
            $currentDate = $currentDateTime->toDateString(); // 'Y-m-d'

            // Create Carbon instances for booking start and end times
            $bookingStartDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $bookingDate . ' ' . $startTime);
            $bookingEndDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $bookingDate . ' ' . $endTime);

            // Determine process status based on the comparison
            $minutesUntilStart = "";
            if ($bookingStartDateTime->isToday()) {
                // Booking is for today, check the time
                if ($currentDateTime->lessThan($bookingStartDateTime)) {
                    $processStatus = 'waiting'; // Current time is before the booking start time
                    $minutesUntilStart = $currentDateTime->diffInMinutes($bookingStartDateTime);
                } elseif ($currentDateTime->between($bookingStartDateTime, $bookingEndDateTime)) {
                    $processStatus = 'in progress'; // Current time is between the booking start and end time
                    $minutesUntilEnd = $currentDateTime->diffInMinutes($bookingEndDateTime);
                } else {
                    $processStatus = 'finished'; // Current time is after the booking end time
                }
            } elseif ($bookingStartDateTime->isFuture()) {
                // Booking is for a future date
                $processStatus = 'booked';
            } else {
                // Booking is for an old date
                $processStatus = 'finished';
            }

            // Display or use the results
            if (isset($minutesUntilStart)) {
                $data->minute_start_and_end_minute_left = $minutesUntilStart;
            } elseif (isset($minutesUntilEnd)) {
                $data->minute_start_and_end_minute_left = $minutesUntilStart;
            } else {

                $data->minute_start_and_end_minute_left = $minutesUntilStart;

            }

            $data->process_status = $processStatus;

            $results = new CustomerBookingDetailResource($data);
            return response()->json([
                'data' => $results,
                'status' => 1,
                'message' => __('message.Data get successfully.'),
            ], 200);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()], 400
            );
        }

    }

    public function bookingWithJoinWaitlist(Request $request)
    {
        $validated = $request->validate([
            'barber_id' => 'required',
            'service_ids' => 'required|array',
            'booking_date' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Parse the booking date
                    $bookingDate = Carbon::parse($value);

                    // Check if the booking date is today or in the future
                    if (!$bookingDate->isToday() && !$bookingDate->isFuture()) {
                        $fail(__('error.The booking date must be today or a future date.'));
                    }
                },
            ],
        ], [
            'barber_id.required' => __('error.The barber id field is required.'),
            'service_ids.required' => __('error.The service ids field is required.'),
            'booking_date.required' => __('error.The booking date field is required.'),
        ]);

        try {

            $booking = new Booking();
            $booking->user_id = Auth::user()->id;
            $booking->barber_id = $request->barber_id;
            $booking->booking_date = $request->booking_date;
            $booking->total_price = 0;
            $booking->start_time = null;
            $booking->end_time = null;
            $booking->booking_type = "waitlist";
            $booking->save();

            if ($booking) {

                $total = 0;
                foreach ($request->service_ids as $key => $service_id) {
                    $service_more_detail = BarberServices::where('sub_service_id', $service_id)->where('barber_id', $request->barber_id)->first();
                    $total = $service_more_detail->service_price + $total;

                    $service_detail = Services::find($service_id);

                    $booking_service_detail = new BookingServiceDetail();
                    $booking_service_detail->booking_id = $booking->id;
                    $booking_service_detail->service_id = $service_id;
                    $booking_service_detail->main_service_id = $service_detail->parent_id;
                    $booking_service_detail->service_name_en = $service_detail->service_name_en ?? "";
                    $booking_service_detail->service_name_ar = $service_detail->service_name_ar ?? "";
                    $booking_service_detail->service_name_ur = $service_detail->service_name_ur ?? "";
                    $booking_service_detail->service_name_tr = $service_detail->service_name_tr ?? "";
                    $booking_service_detail->price = $service_more_detail->service_price;
                    $booking_service_detail->start_time = null;
                    $booking_service_detail->end_time = null;
                    $booking_service_detail->save();

                }

            }

            $booking->total_price = $total;
            $booking->update();

            $data = Booking::with('customer_detail', 'booking_service_detailss.main_service', 'booking_service_detailss.sub_service')->find($booking->id);
            $results = new BookingJoinServiceResource($data);

            if (!empty($results)) {
                return response()->json([
                    'data' => $results,
                    'status' => 1,
                    'message' => __('message.Complete second step for join waitlist.'),
                ], 200);

            } else {
                return response()->json(['status' => 0, 'message' => __('message.Somthing went wrong')]);
            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }

    public function joinWaitlist(Request $request)
    {


        try {


                $any_date = $request->input('any_date');
                $selected_date = $request->input('selected_date');
                $select_date_range = $request->input('select_date_range');
                $from_date = $request->input('from_date');
                $to_date = $request->input('to_date');
                $any_time = $request->input('any_time');
                $selected_time = $request->input('selected_time');
                $select_time_range = $request->input('select_time_range');
                $from_time = $request->input('from_time');
                $to_time = $request->input('to_time');

                $max_length = max(
                    count($any_date ?? []),
                    count($selected_date ?? []),
                    count($select_date_range ?? []),
                    count($from_date ?? []),
                    count($to_date ?? []),
                    count($any_time ?? []),
                    count($selected_time ?? []),
                    count($select_time_range ?? []),
                    count($from_time ?? []),
                    count($to_time ?? [])
                );


                for ($i = 0; $i < $max_length; $i++) {
                    $wait_list = new WaitList();
                    $wait_list->booking_id = $request->booking_id;

                    if (isset($selected_date[$i]) && $selected_date[$i]) {
                        $wait_list->select_date = 1;
                        $wait_list->selected_date = $selected_date[$i];
                    } else {
                        $wait_list->select_date = 0;
                        $wait_list->selected_date = null;
                    }

                    if (isset($select_date_range[$i]) && $select_date_range[$i]) {
                        $wait_list->select_date_range = 1;
                        $wait_list->from_date = $from_date[$i] ?? null;
                        $wait_list->to_date = $to_date[$i] ?? null;
                    } else {
                        $wait_list->select_date_range = 0;
                        $wait_list->from_date = null;
                        $wait_list->to_date = null;
                    }

                    if (isset($selected_time[$i]) && $selected_time[$i]) {
                        $wait_list->select_time = 1;
                        $wait_list->selected_time = $selected_time[$i] ?? null;
                    } else {
                        $wait_list->select_time = 0;
                        $wait_list->selected_time = null;
                    }

                    if (isset($select_time_range[$i]) && $select_time_range[$i]) {
                        $wait_list->select_time_range = 1;
                        $wait_list->from_time = $from_time[$i] ?? null;
                        $wait_list->to_time = $to_time[$i] ?? null;
                    } else {
                        $wait_list->select_time_range = 0;
                        $wait_list->from_time = null;
                        $wait_list->to_time = null;
                    }


                    $wait_list->any_date = $any_date[$i];
                    $wait_list->any_time = $any_time[$i];

                    $wait_list->save();
                }

            return response()->json(['status' => 1, 'message' => __('message.Wait List join succusfully wait for barber accept')]);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }

    public function cancelBooking($id)
    {
        try {

            $data = Booking::find($id);

            $data->status = "cancel";
            $data->update();

            if ($data) {
                return response()->json([
                    'status' => 1,
                    'message' => __('message.Booking cancel successfully'),
                ], 200);
            } else {
                return response()->json(['status' => 0, 'message' => __('message.Somthing went wrong')]);
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }



    public function rescheduleBooking($id)
    {
        try {

            $data = Booking::find($id);
            // $data->status = "rescheduled";
            // $data->update();

            $booking = Booking::with('customer_detail', 'booking_service_detailss.main_service', 'booking_service_detailss.sub_service')->find($data->id);
            $booking['barber_schedule'] = BarberSchedule::where('barber_id', $data->barber_id)->first();
            $results = new BookingJoinServiceResource($booking);
            if ($results) {
                return response()->json([
                    'data' => $results,
                    'status' => 1,
                    'message' => __('message.Booking reschedule successfully'),
                ], 200);
            } else {
                return response()->json(['status' => 0, 'message' => __('message.Somthing went wrong')]);
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }



    public function rescheduleBookingSubmit(Request $request)
    {


        $language_code = $request->header('language');

        $id = Auth::user()->id;
        $validated = [];
        $validated['booking_id'] = "required";
        $validated['booking_date'] = "required";
        $validated['slots'] = "required|array";

        $customMessages = [
            'booking_id.required' => __('error.The booking id field is required.'),
            'booking_date.required' => __('error.The booking date field is required.'),
            'slots.required' => __('error.The time field is required.'),
        ];

        $request->validate($validated, $customMessages);



        try {



            $data = Booking::find($request->booking_id);
            if(!empty($data))
            {


                 // Loop through the array
                    foreach ($request->slots as $index => $slot) {
                        // Split the time range by " - "
                        list($start, $end) = explode('-', $slot);

                        // Set the first start time
                        if ($index === 0) {
                            $startTime = $start;
                        }

                        // Always update the last end time
                        $endTime = $end;
                    }

                $booking = new Booking();
                $booking->user_id = Auth::user()->id;
                $booking->barber_id = $data->barber_id;
                $booking->booking_date = $request->booking_date;
                $booking->total_price = 0;
                $booking->start_time = $startTime;
                $booking->end_time = $endTime;
                $booking->booking_type = "booking";
                $booking->status = "pending";
                $booking->is_reschedule = 1;
                $booking->save();


                  if(!empty($booking))
                  {
                                $bookingServiceDetail  =  BookingServiceDetail::where('booking_id',$data->id)->get();
                                if(!empty($bookingServiceDetail)) {
                                                foreach($bookingServiceDetail as $key=>$booking_detail)
                                                {


                                                          list($start, $end) = explode('-', $request->slots[$key]);
                                                          $booking_reschesule_detail = New BookingServiceDetail();
                                                          $booking_reschesule_detail->booking_id = $booking->id;
                                                          $booking_reschesule_detail->main_service_id = $booking_detail->main_service_id;
                                                          $booking_reschesule_detail->service_id = $booking_detail->service_id;
                                                          $booking_reschesule_detail->service_name_en = $booking_detail->service_name_en ?? "";
                                                          $booking_reschesule_detail->service_name_ar = $booking_detail->service_name_ar ?? "";
                                                          $booking_reschesule_detail->service_name_ur = $booking_detail->service_name_ur ?? "";
                                                          $booking_reschesule_detail->service_name_tr = $booking_detail->service_name_tr ?? "";
                                                          $booking_reschesule_detail->price = $booking_detail->price;
                                                          $booking_reschesule_detail->start_time = $start;
                                                          $booking_reschesule_detail->end_time = $end;
                                                          $booking_reschesule_detail->save();


                                                }
                                }
                                $data->is_reschedule = 1;
                                $data->status = "rescheduled";
                                $data->update();
                  }


            }else
            {
                 return response()->json(['status' => 0, 'message' => __('message.Somthing went wrong')]);
            }

            if ($booking_reschesule_detail) {
                resechedule_booking($request->booking_id,$booking->id);
                return response()->json([
                    'status' => 1,
                    'message' => __('message.Booking reschedule successfully'),
                ], 200);
            }


        // DB::commit()
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }



    public function acceptOrRejectBarberProposal(Request $request)
    {


        $validated = [];
        $validated['status'] = "required";
        $validated['id'] = "required";
        $validated['booking_id'] = "required";

        $customMessages = [
            'status.required' => __('error.The status field is required.'),
            'id.required' => __('error.The id field is required.'),
            'booking_id.required' => __('error.The booking id field is required.'),
        ];

        $request->validate($validated, $customMessages);

        try {

           $data = BarberProposal::find($request->id);
           $data->status = $request->status;
           $data->update();

           if($request->status == "accept")
           {
                    $booking_service_detail = BookingServiceDetail::where('booking_id',$request->booking_id)->orderBy('id', 'DESC')->get();
                    foreach($booking_service_detail as $key=>$service_detail)
                    {
                                list($start, $end) = explode('-', $data->slots[$key]);
                                $booking_detail =  BookingServiceDetail::find($service_detail->id);
                                $booking_detail->start_time = $start;
                                $booking_detail->end_time = $end;
                                $booking_detail->save();

                    }

                    // Loop through the array
                    foreach ($data->slots as $index => $slot) {
                        // Split the time range by " - "
                        list($start, $end) = explode('-', $slot);

                        // Set the first start time
                        if ($index === 0) {
                            $startTime = $start;
                        }

                        // Always update the last end time
                        $endTime = $end;
                    }

                    $booking = Booking::find($request->booking_id);
                    $booking->start_time = $startTime;
                    $booking->end_time = $endTime;
                    $booking->booking_date = $data->booking_date;
                    $booking->booking_type = "booking";
                    $booking->status = 'accept';
                    $booking->update();


                    $check = Chats::where('user_id1',$data->user_id)->where('user_id2',$data->barber_id)->exists();
                    if($check == Null) {
                         $create_chat = new Chats();
                         $create_chat->user_id1 = $data->user_id;
                         $create_chat->user_id2 = $data->barber_id;
                         $create_chat->chat_unique_key = chat_unique_key();
                         $create_chat->save();
                    }

           }
           sendEmail($data->user_id,'customer-chnage-status-for-barber-proposal',$request->booking_id);

           return response()->json([
            'status' => 1,
            'message' => __('message.Barber Proposal status update successfully'),
        ], 200);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()],400
            );
        }
    }



    public function ratingBarber(Request $request)
    {

        $validated = [];
        $validated['rating'] = "required";
        $validated['booking_id'] = "required";

        $customMessages = [
            'rating.required' => __('error.The rating field is required.'),
            'booking_id.required' => __('error.The booking id field is required.'),
        ];

        $request->validate($validated, $customMessages);

        try {


                $booking = Booking::find($request->booking_id);
                $data = new  BarberRating();
                $data->user_id = $booking->user_id;
                $data->barber_id = $booking->barber_id;
                $data->booking_id = $booking->booking_id;
                $data->rating = $request->rating;
                $data->save();

                sendEmail(Auth::user()->id,'customer-rating-to-barber',$booking->id);

            if ($data) {
                return response()->json([
                    'status' => 1,
                    'message' => __('message.Rating submit successfully'),
                ], 200);
            } else {
                return response()->json([
                    'status' => 0,
                    'message' => __('message.Somthing went wrong'),400]);
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()],400
            );
        }
    }








}









