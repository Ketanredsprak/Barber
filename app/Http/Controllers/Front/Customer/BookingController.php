<?php

namespace App\Http\Controllers\Front\Customer;

use DateTime;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Chats;
use App\Models\Pagies;
use App\Models\Booking;
use App\Models\Services;
use App\Models\WaitList;
use App\Rules\SameCount;
use App\Models\BarberRating;
use Illuminate\Http\Request;
use App\Models\BarberProposal;
use App\Models\BarberSchedule;
use App\Models\BarberServices;
use App\Http\Controllers\Controller;
use App\Models\BookingServiceDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class BookingController extends Controller
{
    //
    public function getBookingPage($id)
    {

        $barber_id = Crypt::decryptString($id);
        $barber_data = User::with('barber_schedule','barber_rating')->find($barber_id);
        $barber_data->average_rating = $barber_data->averageRating();
        $barber_data->encrypt_id = $id;
        $barber_data['barber_services'] = BarberServices::with('service_detail', 'sub_service_detail')->where('barber_id', $barber_id)->get();
        $data = Pagies::with("meta_content")->find(15);

        return view('Frontend.Booking.book-an-appointment', compact('data', 'barber_data'));
    }

    public function getJoinWaitlist($id)
    {

        $id = Crypt::decryptString($id);

        $data = Pagies::with("meta_content")->find(18);
        $booking_detail = Booking::with('booking_service_detailss.sub_service', 'booking_service_detailss.main_service')->find($id);
        $barber_id = Crypt::encryptString($booking_detail->barber_id);
        // dd($booking_detail);
        return view('Frontend.Barber.join-waitlist', compact('data', 'booking_detail', 'barber_id'));

    }

    public function booking(Request $request)
    {

        $validated = [];
        $validated = $request->validate([
            'barber_id' => 'required',
            'service_ids' => 'required|array',
            'booking_date' => 'required|date', // Added date validation for booking_date
            'slots' => ['required', 'array', new SameCount('service_ids')],
        ], [
            'service_ids.required' => __('error.The barber id field is required.'),
            'service_ids.required' => __('error.The service ids field is required.'),
            'booking_date.required' => __('error.The booking date field is required.'),
            'slots.required' => __('error.The time field is required.'),
        ]);

        try {

            // Initialize variables
            $startTime = null;
            $endTime = null;

            // Loop through the array
            foreach ($request->slots as $index => $slot) {
                // Split the time range by " - "
                list($start, $end) = explode(' - ', $slot);

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

                    list($start, $end) = explode(' - ', $request->slots[$key]);

                    $service_detail = Services::find($service_id);
                    $service_more_detail = BarberServices::where('sub_service_id', $service_id)->where('barber_id', $request->barber_id)->first();

                    $total = $service_more_detail->service_price + $total;

                    $booking_service_detail = new BookingServiceDetail();
                    $booking_service_detail->booking_id = $booking->id;
                    $booking_service_detail->service_id = $service_id;
                    $booking_service_detail->main_service_id = $service_detail->parent_id;
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

            $booking_id = Crypt::encryptString($booking->id);

            sendEmail($booking->user_id,'booking',$booking->id);

            if (!empty($booking)) {
                return response()->json(['status' => 1, 'message' => __('message.Booking succusfully'), 'booking_id' => $booking_id]);
            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }

    }



    public function getBarberSlotsReshedule(Request $request)
    {

        //
        $booking_ids = Booking::where('barber_id', $request->barber_id)->pluck('id')->toArray();

        $bookingDate = DateTime::createFromFormat('d/m/Y', $request->booking_date);
        $booking_date_y_m_d = $bookingDate->format('Y-m-d');

        $data = BookingServiceDetail::with('booking_detail')
            ->whereIn('booking_id', $booking_ids)
            ->whereHas('booking_detail', function ($query) use ($request, $booking_date_y_m_d) {
                $query->where('barber_id', $request->barber_id)
                    ->where('booking_date', $booking_date_y_m_d);
            })
            ->select('booking_id', 'start_time', 'end_time')
            ->get();

        $results = [];

        foreach ($data as $item) {
            $results[] = [
                'start_time' => date('H:i', strtotime($item->start_time)),
                'end_time' => date('H:i', strtotime($item->end_time)),
            ];
        }

        $booking_date = $request->booking_date;
        // Create a DateTime object from the date string
        $dateObject = DateTime::createFromFormat('d/m/Y', $booking_date);
        // Format it as full textual representation of the day (e.g., Monday)
        $dayOfWeek = $dateObject->format('l');
        $dayOfWeek = strtolower($dayOfWeek);

        $holiday = $dayOfWeek . "_is_holiday";
        $start_time = $dayOfWeek . "_start_time";
        $end_time = $dayOfWeek . "_end_time";
        $barber_schesule = BarberSchedule::where('barber_id', $request->barber_id)->select('id', 'barber_id', $holiday, $start_time, $end_time)->first();

        $holiday = $barber_schesule->$holiday;
        $start_time = $barber_schesule->$start_time;
        $end_time = $barber_schesule->$end_time;

        if ($holiday == 0) {
            //generate slot based on barber avaliblity
            $interval = 30 * 60; // duration in seconds
            $startTimestamp = strtotime($start_time);
            $endTimestamp = strtotime($end_time);

            // Initialize an array to store time slots
            $timeSlots = array();

            // Create time slots with 30-minute gaps
            while ($startTimestamp < $endTimestamp) {
                $endTimestampSlot = $startTimestamp + $interval;

                $timeSlots[] = array(
                    'start' => date('H:i', $startTimestamp),
                    'end' => date('H:i', $endTimestampSlot),
                );

                $startTimestamp = $endTimestampSlot;
            }

            //generate slot based on barber avaliblity
        } else {
            $timeSlots = [];
        }
        $list = "";

        // Compare arrays and add is_available key
        foreach ($timeSlots as &$item) {
            $item['is_available'] = 0; // Default to 0

            foreach ($results as $availability) {
                if ($item['start'] === $availability['start_time'] && $item['end'] === $availability['end_time']) {
                    $item['is_available'] = 1;
                    break; // No need to check further if a match is found
                }
            }
        }
        return response()->json(view('Frontend.Barber.slot-list-reshedule', compact('timeSlots'))->render());

    }

    public function getBarberSlots(Request $request)
    {

        //
        $booking_ids = Booking::where('barber_id', $request->barber_id)->pluck('id')->toArray();

        $bookingDate = DateTime::createFromFormat('d/m/Y', $request->booking_date);
        $booking_date_y_m_d = $bookingDate->format('Y-m-d');

        $data = BookingServiceDetail::with('booking_detail')
            ->whereIn('booking_id', $booking_ids)
            ->whereHas('booking_detail', function ($query) use ($request, $booking_date_y_m_d) {
                $query->where('barber_id', $request->barber_id)
                    ->where('booking_date', $booking_date_y_m_d);
            })
            ->select('booking_id', 'start_time', 'end_time')
            ->get();

        $results = [];

        foreach ($data as $item) {
            $results[] = [
                'start_time' => date('H:i', strtotime($item->start_time)),
                'end_time' => date('H:i', strtotime($item->end_time)),
            ];
        }

        $booking_date = $request->booking_date;
        // Create a DateTime object from the date string
        $dateObject = DateTime::createFromFormat('d/m/Y', $booking_date);
        // Format it as full textual representation of the day (e.g., Monday)
        $dayOfWeek = $dateObject->format('l');
        $dayOfWeek = strtolower($dayOfWeek);

        $holiday = $dayOfWeek . "_is_holiday";
        $start_time = $dayOfWeek . "_start_time";
        $end_time = $dayOfWeek . "_end_time";
        $barber_schesule = BarberSchedule::where('barber_id', $request->barber_id)->select('id', 'barber_id', $holiday, $start_time, $end_time)->first();

        $holiday = $barber_schesule->$holiday;
        $start_time = $barber_schesule->$start_time;
        $end_time = $barber_schesule->$end_time;

        if ($holiday == 0) {
            //generate slot based on barber avaliblity
            $interval = 30 * 60; // duration in seconds
            $startTimestamp = strtotime($start_time);
            $endTimestamp = strtotime($end_time);

            // Initialize an array to store time slots
            $timeSlots = array();

            // Create time slots with 30-minute gaps
            while ($startTimestamp < $endTimestamp) {
                $endTimestampSlot = $startTimestamp + $interval;

                $timeSlots[] = array(
                    'start' => date('H:i', $startTimestamp),
                    'end' => date('H:i', $endTimestampSlot),
                );

                $startTimestamp = $endTimestampSlot;
            }

            //generate slot based on barber avaliblity
        } else {
            $timeSlots = [];
        }
        $list = "";

        // Compare arrays and add is_available key
        foreach ($timeSlots as &$item) {
            $item['is_available'] = 0; // Default to 0

            foreach ($results as $availability) {
                if ($item['start'] === $availability['start_time'] && $item['end'] === $availability['end_time']) {
                    $item['is_available'] = 1;
                    break; // No need to check further if a match is found
                }
            }
        }

        return response()->json(view('Frontend.Barber.slot-list', compact('timeSlots'))->render());

    }

    //
    public function myBookingAppointmentToday()
    {
        $userId = Auth::user()->id;
        $todayDate = Carbon::today()->toDateString();
        $Today_Appointments = Booking::with('barber_detail')->where('user_id', $userId)->where('booking_date', '>=', $todayDate)->where('status', '!=', 'finished')->orderBy('id', 'DESC')->paginate(5);
        $data = Pagies::with("meta_content")->find(10);
        return view('Frontend.Booking.my-booking-appointments-today', compact('data', 'Today_Appointments'));
    }

    //
    public function myBookingAppointmentHistory()
    {
        $userId = Auth::user()->id;
        $todayDate = Carbon::today()->toDateString();
        $Old_Appointments = Booking::with('barber_detail')->where('user_id', $userId)->where('status','finished')->orderBy('id', 'DESC')->paginate(5);
        $data = Pagies::with("meta_content")->find(10);
        return view('Frontend.Booking.my-booking-appointments-history', compact('data', 'Old_Appointments'));
    }

    public function myBookingAppointmentDetail($id)
    {
        try {
            $data = Booking::with('barber_detail', 'customer_detail',  'booking_service_detailss.main_service', 'booking_service_detailss.sub_service')->find($id);
            $barber_id = Crypt::encryptString($data->barber_id);
            if (!empty($data)) {
                return view('Frontend.Booking.my-appointment-detail', compact('data','barber_id'));
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }

    public function myBookingAppointmentSuccess($id)
    {
        try {

            $id = Crypt::decryptString($id);
            $data = Pagies::with("meta_content", 'cms_content')->find(17);
            $data['booking'] = Booking::with('barber_detail', 'customer_detail', 'booking_service_detailss')->find($id);
            if (!empty($data)) {
                return view('Frontend.Booking.my-booking-appointment-seccess', compact('data'));
            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }

    public function bookingJoinWaitlist(Request $request)
    {

        $validated = [];
        $validated = $request->validate([
            'barber_id' => 'required',
            'service_ids' => 'required|array',
            'booking_date' => 'required|date', // Added date validation for booking_date
        ], [
            'service_ids.required' => __('error.The barber id field is required.'),
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

            $booking_id = Crypt::encryptString($booking->id);

            if (!empty($booking)) {
                return response()->json(['status' => 1, 'message' => __('message.Complete second step for join waitlist.'), 'booking_id' => $booking_id]);
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


            if ($request->input('any_date') && $request->input('any_time')) {
                // foreach ($request->input('any_date') as $index => $any_date) {
                    $wait_list = new WaitList();
                    $wait_list->booking_id = $request->booking_id;
                    $wait_list->any_date = 1;
                    $wait_list->any_time = 1;
                    $wait_list->select_time = 0;
                    $wait_list->select_date = 0;
                    $wait_list->selected_time = null;
                    $wait_list->selected_date = null;
                    $wait_list->select_date_range = 0;
                    $wait_list->select_time_range = 0;
                    $wait_list->to_date = null;
                    $wait_list->from_date = null;
                    $wait_list->to_time = null;
                    $wait_list->from_time = null;
                    $wait_list->save();
                // }
            } else {
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
                        $wait_list->selected_time = $selected_time[$i];
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

                    $wait_list->any_date = isset($any_date[$i]) ? 1 : 0;
                    $wait_list->any_time = isset($any_time[$i]) ? 1 : 0;

                    $wait_list->save();
                }
            }
            return response()->json(['status' => 1, 'message' => __('message.Wait List join succusfully wait for barber accept')]);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }



    public function getBookingDetail($id)
    {
            // $booking_id = Crypt::decryptString($id);
            $data = Pagies::with("meta_content", 'cms_content')->find(19);
            $booking = Booking::with('customer_detail','barber_detail', 'booking_service_detailss.main_service', 'booking_service_detailss.sub_service','barber_reting','barber_proposal')->find($id);


            $booking_encrypt_id = Crypt::encryptString($booking->id);
            $booking->booking_encrypt_id = $booking_encrypt_id;

            if($booking->booking_type == "booking") {
             // Assume $data->booking_date, $data->start_time, and $data->end_time are provided
             $bookingDate = $booking->booking_date; // e.g., '2024-07-31'
             $startTime = $booking->start_time; // e.g., '11:30:00'
             $endTime = $booking->end_time; // e.g., '12:30:00'

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
                 $booking->minute_start_and_end_minute_left = $minutesUntilStart;
             } elseif (isset($minutesUntilEnd)) {
                 $booking->minute_start_and_end_minute_left = $minutesUntilStart;
             } else {

                 $booking->minute_start_and_end_minute_left = $minutesUntilStart;

             }

             $booking->process_status = $processStatus;


            }
            else
            {


                if(!empty($booking->barber_proposal->slots))
                 // Loop through the array
                 foreach ($booking->barber_proposal->slots as $index => $slot) {
                    // Split the time range by " - "
                    list($start, $end) = explode('-', $slot);

                    // Set the first start time
                    if ($index === 0) {
                        $startTime = $start;
                    }

                    // Always update the last end time
                    $endTime = $end;
                }

                $booking->barber_proposal_start_time = $start ?? "";
                $booking->barber_proposal_end_time = $end ?? "";
                $booking->process_status = "pending";
                $booking->minute_start_and_end_minute_left = "";


            }


             if (!empty($booking)) {
                return view('Frontend.Booking.my-booking-detail', compact('data','booking'));
            }




    }



    public function cancelBooking($id)
    {

        try {


            $booking_id = Crypt::decryptString($id);
            $data = Booking::find($booking_id);

            $data->status = "cancel";
            $data->update();

            if(!empty($data)) {
                return redirect('my-booking-appointment-today')->with('status', __('message.Booking cancel successfully'));
            } else {
                return redirect()->with('error', __('message.Somthing went wrong'));
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

            $booking_id = Crypt::decryptString($id);
            $data = Booking::find($booking_id);
            // $data->status = "rescheduled";
            // $data->update();

            $booking = Booking::with('customer_detail', 'booking_service_detailss.main_service', 'booking_service_detailss.sub_service')->find($data->id);
            $booking['service_Ids'] = $booking->booking_service_detailss()->pluck('service_id')->toArray();
            $booking['total_services'] = $booking->booking_service_detailss()->count();
            $booking['barber_schedule'] = BarberSchedule::where('barber_id', $data->barber_id)->first();


            $barber_data = User::with('barber_schedule','barber_rating')->find($data->barber_id);
            $barber_data->encrypt_id = $id;
            $barber_data->average_rating = $barber_data->averageRating();
            $barber_data['barber_services'] = BarberServices::with('service_detail', 'sub_service_detail')->where('barber_id', $data->barber_id)->get();
            $data = Pagies::with("meta_content")->find(15);


            // dd($booking);
            if ($booking) {
                return view('Frontend.Booking.book-an-appointment-reshedule', compact('data','booking','barber_data'));
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
            $booking_id = Crypt::encryptString($data->id);
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
                $booking->total_price = $data->total_price;
                $booking->start_time = $startTime;
                $booking->end_time = $endTime;
                $booking->status = "pending";
                $booking->booking_type = "booking";
                $booking->is_reschedule = 1;
                $booking->save();
                $booking_new_id = Crypt::encryptString($booking->id);


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

            if (!empty($booking)) {
                resechedule_booking($request->booking_id,$booking->id);
                return response()->json(['status' => 1, 'message' => __('message.Booking reshedule succusfully'), 'booking_id' => $booking_new_id]);
            }


        // DB::commit()
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }


    public function ratingSubmit(Request $request)
    {


        $id = Auth::user()->id;
        $validated = [];
        $validated['rating'] = "required";

        $customMessages = [
            'rating.required' => __('error.The rating field is required.'),
        ];

        $request->validate($validated, $customMessages);


        try {

            $data = new  BarberRating();
            $data->user_id = Auth::user()->id;
            $data->barber_id = $request->barber_id;
            $data->booking_id = $request->booking_id;
            $data->rating = $request->rating;
            $data->save();

            $booking_id = Crypt::encryptString($request->booking_id);

            sendEmail(Auth::user()->id,'customer-rating-to-barber',$request->booking_id);

            if (!empty($data)) {
                return response()->json(['status' => 1, 'message' => __('message.Rating submit successfully'), 'booking_id' => $booking_id]);
            }

         // DB::commit()
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }





    public function rejectBarberProposal($id)
    {
        try {

           $data = BarberProposal::find($id);
           $data->status = "reject";
           $data->update();

           sendEmail($data->user_id,'customer-chnage-status-for-barber-proposal',$data->booking_id);

           return response()->json([
            'status' => 1,
            'message' => __('message.Barber Proposal reject successfully'),
        ], 200);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()],400
            );
        }
    }




    public function acceptBarberProposal($id)
    {

         try {

           $data = BarberProposal::find($id);
           $data->status = "accept";
           $data->update();

           if($data->status == "accept")
           {
                    $booking_service_detail = BookingServiceDetail::where('booking_id',$data->booking_id)->orderBy('id', 'DESC')->get();
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



                    $booking = Booking::find($data->booking_id);
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
           sendEmail($data->user_id,'customer-chnage-status-for-barber-proposal',$data->booking_id);

           return response()->json([
            'status' => 1,
            'message' => __('message.Barber Proposal accept successfully'),
        ], 200);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()],400
            );
        }
    }










}
