<?php

namespace App\Http\Controllers\Front\Customer;

use App\Http\Controllers\Controller;
use App\Models\BarberProposal;
use App\Models\BarberRating;
use App\Models\BarberSchedule;
use App\Models\BarberServices;
use App\Models\BarberSlotDisable;
use App\Models\Booking;
use App\Models\BookingServiceDetail;
use App\Models\Chats;
use App\Models\Pagies;
use App\Models\Services;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\WaitList;
use App\Rules\SameCount;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class BookingController extends Controller
{
    //
    public function getBookingPage($id)
    {

        $barber_id = Crypt::decryptString($id);
        $barber_data = User::with('barber_schedule', 'barber_rating')->find($barber_id);
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

            //check booking date and time
            $booking = Booking::where('user_id', Auth::user()->id)->where('booking_date', $request->booking_date)->whereIn('status', ['accept', 'finished'])
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->whereBetween('start_time', [$startTime, $endTime])
                        ->orWhereBetween('end_time', [$startTime, $endTime])
                        ->orWhere(function ($query) use ($startTime, $endTime) {
                            $query->where('start_time', '<=', $startTime)
                                ->where('end_time', '>=', $endTime);
                        });
                })
                ->get();

            if (!$booking->isEmpty()) {
                return response()->json(['status' => 0, 'message' => __('message.Already booking found for this date and time')]);
            }
            //check booking date and time

            //check user booking balance
            $user_sub = UserSubscription::where("user_id", Auth::user()->id)->where('status', 'active')->first();
            if (!empty($user_sub)) {

                if ($user_sub->availble_booking == 0) {
                    return response()->json(['status' => 0, 'message' => __('message.reach maximum booking limit..')]);
                } else {
                    // Decrement the available bookings
                    $user_sub->availble_booking -= 1;
                    // Save the updated record to the database
                    $user_sub->update();

                    if ($user_sub->availble_booking == 0) {
                        $basic_subscription = Subscription::find(1);
                        $user_sub->availble_booking = $basic_subscription->number_of_booking ?? 0;
                        $user_sub->update();
                    }
                }

            } else {
                return response()->json(['status' => 0, 'message' => __('message.reach maximum booking limit..')]);
            }

            $booking = new Booking();
            $booking->user_id = Auth::user()->id;
            $booking->barber_id = $request->barber_id;
            $booking->booking_date = $request->booking_date;
            $booking->total_price = 0;
            $booking->status = "accept";
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

            sendEmail($booking->user_id, 'booking', $booking->id);
            sendPushNotification($booking->user_id, 'booking', 'booking', 'booking');
            sendPushNotification($booking->barber_id, 'booking', 'booking', 'booking');
            sendPushNotification(Auth::user()->id, 'remaining-booking', 'remaining-booking', 'remaining-booking');

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

        $booking_ids = Booking::where('barber_id', $request->barber_id)
            ->whereIn('status', ['accept', 'finished'])
            ->pluck('id')->toArray();

        $bookingDate = DateTime::createFromFormat('d/m/Y', $request->booking_date);
        $booking_date_y_m_d = $bookingDate->format('Y-m-d');
        $current_date = date('Y-m-d');
        $current_time = date('H:i');

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
        $dateObject = DateTime::createFromFormat('d/m/Y', $booking_date);
        $dayOfWeek = strtolower($dateObject->format('l'));

        $holiday = $dayOfWeek . "_is_holiday";
        $start_time = $dayOfWeek . "_start_time";
        $end_time = $dayOfWeek . "_end_time";
        $barber_schedule = BarberSchedule::where('barber_id', $request->barber_id)
            ->select('id', 'barber_id', $holiday, $start_time, $end_time)
            ->first();

        $holiday = $barber_schedule->$holiday;
        $start_time = $barber_schedule->$start_time;
        $end_time = $barber_schedule->$end_time;

        if ($holiday == 0) {
            $interval = 30 * 60;
            $startTimestamp = strtotime($start_time);
            $endTimestamp = strtotime($end_time);
            $timeSlots = [];

            while ($startTimestamp < $endTimestamp) {
                $endTimestampSlot = $startTimestamp + $interval;
                $timeSlots[] = [
                    'start' => date('H:i', $startTimestamp),
                    'end' => date('H:i', $endTimestampSlot),
                    'is_available' => 0,
                ];
                $startTimestamp = $endTimestampSlot;
            }
        } else {
            $timeSlots = [];
        }

        foreach ($timeSlots as &$item) {
            foreach ($results as $availability) {
                if ($item['start'] === $availability['start_time'] && $item['end'] === $availability['end_time']) {
                    $item['is_available'] = 1;
                    break;
                }
            }

            // If the booking date is today, check if the slot time has passed
            if ($booking_date_y_m_d == $current_date && $item['start'] < $current_time) {
                $item['is_available'] = 1; // Mark past slots as unavailable
            }
        }

        $disableSlotRecordAll = BarberSlotDisable::where('barber_id', $request->barber_id)
            ->where('date', $booking_date_y_m_d)
            ->where('all_slots', 1)
            ->first();

        if ($disableSlotRecordAll) {
            foreach ($timeSlots as &$slot) {
                $slot['is_available'] = 1;
            }
        }

        $disableSlotRecords = BarberSlotDisable::where('barber_id', $request->barber_id)
            ->where('date', $booking_date_y_m_d)
            ->where('all_slots', 0)
            ->get();

        if (count($disableSlotRecords) >= 0) {
            foreach ($disableSlotRecords as $disableRecord) {
                $disableSlotTime = $disableRecord->slot;

                foreach ($timeSlots as &$slot) {
                    if ($slot['is_available'] == 1) {
                        continue;
                    }

                    if ($slot['start'] == $disableSlotTime) {
                        $slot['is_available'] = 1;
                    }
                }
            }
        }

        //getting barber disbale slot

        return response()->json(view('Frontend.Barber.slot-list-reshedule', compact('timeSlots'))->render());

    }

    public function getBarberSlots(Request $request)
    {

        $booking_ids = Booking::where('barber_id', $request->barber_id)->whereIn('status', ['accept', 'finished'])->pluck('id')->toArray();

        $bookingDate = DateTime::createFromFormat('d/m/Y', $request->booking_date);
        $booking_date_y_m_d = $bookingDate->format('Y-m-d');
        $current_date = date('Y-m-d');
        $current_time = date('H:i');

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
        $dateObject = DateTime::createFromFormat('d/m/Y', $booking_date);
        $dayOfWeek = strtolower($dateObject->format('l'));

        $holiday = $dayOfWeek . "_is_holiday";
        $start_time = $dayOfWeek . "_start_time";
        $end_time = $dayOfWeek . "_end_time";
        $barber_schedule = BarberSchedule::where('barber_id', $request->barber_id)
            ->select('id', 'barber_id', $holiday, $start_time, $end_time)
            ->first();

        $holiday = $barber_schedule->$holiday;
        $start_time = $barber_schedule->$start_time;
        $end_time = $barber_schedule->$end_time;

        if ($holiday == 0) {
            $interval = 30 * 60;
            $startTimestamp = strtotime($start_time);
            $endTimestamp = strtotime($end_time);
            $timeSlots = [];

            while ($startTimestamp < $endTimestamp) {
                $endTimestampSlot = $startTimestamp + $interval;
                $timeSlots[] = [
                    'start' => date('H:i', $startTimestamp),
                    'end' => date('H:i', $endTimestampSlot),
                    'is_available' => 0,
                ];
                $startTimestamp = $endTimestampSlot;
            }
        } else {
            $timeSlots = [];
        }

        foreach ($timeSlots as &$item) {
            foreach ($results as $availability) {
                if ($item['start'] === $availability['start_time'] && $item['end'] === $availability['end_time']) {
                    $item['is_available'] = 1;
                    break;
                }
            }

            // If the booking date is today, check if the slot time has passed
            if ($booking_date_y_m_d == $current_date && $item['start'] < $current_time) {
                $item['is_available'] = 1; // Mark past slots as unavailable
            }
        }

        $disableSlotRecordAll = BarberSlotDisable::where('barber_id', $request->barber_id)
            ->where('date', $booking_date_y_m_d)
            ->where('all_slots', 1)
            ->first();

        if ($disableSlotRecordAll) {
            foreach ($timeSlots as &$slot) {
                $slot['is_available'] = 1;
            }
        }

        $disableSlotRecords = BarberSlotDisable::where('barber_id', $request->barber_id)
            ->where('date', $booking_date_y_m_d)
            ->where('all_slots', 0)
            ->get();

        if (count($disableSlotRecords) >= 0) {
            foreach ($disableSlotRecords as $disableRecord) {
                $disableSlotTime = $disableRecord->slot;

                foreach ($timeSlots as &$slot) {
                    if ($slot['is_available'] == 1) {
                        continue;
                    }

                    if ($slot['start'] == $disableSlotTime) {
                        $slot['is_available'] = 1;
                    }
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
        $Today_Appointments = Booking::with('barber_proposal', 'barber_detail', 'booking_service_detailss')->where('user_id', $userId)->where('booking_date', '>=', $todayDate)->where('status', '!=', 'finished')->orderBy('id', 'DESC')->paginate(5);
        $data = Pagies::with("meta_content")->find(10);
        return view('Frontend.Booking.my-booking-appointments-today', compact('data', 'Today_Appointments'));
    }

    //
    public function myBookingAppointmentHistory()
    {
        $userId = Auth::user()->id;
        $todayDate = Carbon::today()->toDateString();
        $Old_Appointments = Booking::with('barber_detail')->where('user_id', $userId)->where('status', 'finished')->orderBy('id', 'DESC')->paginate(5);
        $data = Pagies::with("meta_content")->find(10);
        return view('Frontend.Booking.my-booking-appointments-history', compact('data', 'Old_Appointments'));
    }

    public function myBookingAppointmentDetail($id)
    {
        try {
            $data = Booking::with('barber_detail', 'customer_detail', 'booking_service_detailss.main_service', 'booking_service_detailss.sub_service')->find($id);
            $barber_id = Crypt::encryptString($data->barber_id);
            if (!empty($data)) {
                return view('Frontend.Booking.my-appointment-detail', compact('data', 'barber_id'));
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
            $user_sub = UserSubscription::where("user_id", Auth::user()->id)->where('status', 'active')->first();
            $data['booking'] = Booking::with('barber_detail', 'customer_detail', 'booking_service_detailss')->find($id);

            if (!empty($data)) {
                return view('Frontend.Booking.my-booking-appointment-seccess', compact('data', 'user_sub'));
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

            //check user booking balance
            $user_sub = UserSubscription::where("user_id", Auth::user()->id)->where('status', 'active')->first();
            if ($user_sub->availble_booking == 0) {
                return response()->json(['status' => 0, 'message' => __('message.reach maximum booking limit..')]);
            } else {
                // Decrement the available bookings
                $user_sub->availble_booking -= 1;
                // Save the updated record to the database
                $user_sub->update();

                if ($user_sub->availble_booking == 0) {
                    $basic_subscription = Subscription::find(1);
                    $user_sub->availble_booking = $basic_subscription->number_of_booking ?? 100;
                    $user_sub->update();
                }

            }

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
                return response()->json(['status' => 1, 'message' => __('message.Continue with next step'), 'booking_id' => $booking_id]);
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
                $selected_date = $request->input('booking_date');
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

                    if (isset($selected_date)) {
                        $wait_list->select_date = 1;
                        $wait_list->selected_date = $selected_date;
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
        $booking = Booking::with('customer_prefrences', 'customer_detail', 'barber_detail', 'booking_service_detailss.main_service', 'booking_service_detailss.sub_service', 'barber_reting', 'barber_proposal')->find($id);

        $booking_encrypt_id = Crypt::encryptString($booking->id);
        $booking->booking_encrypt_id = $booking_encrypt_id;

        if ($booking->booking_type == "booking") {
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

             // Determine if the user can reschedule
             $canReschedule = $currentDateTime->diffInMinutes($bookingStartDateTime) > 30 ? 1 : 0;
             $booking->can_reschedule = $canReschedule;


             // Determine if the user can reschedule
             $canCancel = $currentDateTime->diffInMinutes($bookingStartDateTime) > 60 ? 1 : 0;
             $booking->can_cancel = $canCancel;


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

        } else {

            if (!empty($booking->barber_proposal->slots))
            // Loop through the array
            {
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
            }

            $booking->barber_proposal_start_time = $start ?? "";
            $booking->barber_proposal_end_time = $end ?? "";
            $booking->process_status = "pending";
            $booking->minute_start_and_end_minute_left = "";

        }

        $barber_data = User::with('barber_rating')->find($booking->barber_id);
        $barber_data->average_rating = $barber_data->averageRating();

        if (!empty($booking)) {
            return view('Frontend.Booking.my-booking-detail', compact('data', 'booking', 'barber_data'));
        }

    }

    public function cancelBooking($id)
    {

        try {


            $booking_id = Crypt::decryptString($id);

            $data = Booking::find($booking_id);

            $data->status = "cancel";
            $data->update();

            sendPushNotification($data->user_id, 'cancel-booking-when-to-customer', 'cancel-booking-when-to-customer', 'cancel-booking-when-to-customer');
            sendPushNotification($data->barber_id, 'cancel-booking-when-to-barber', 'cancel-booking-when-to-barber', 'cancel-booking-when-to-barber');

            if (!empty($data)) {
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

            $barber_data = User::with('barber_schedule', 'barber_rating')->find($data->barber_id);
            $barber_data->encrypt_id = $id;
            $barber_data->average_rating = $barber_data->averageRating();
            $barber_data['barber_services'] = BarberServices::with('service_detail', 'sub_service_detail')->where('barber_id', $data->barber_id)->get();
            $data = Pagies::with("meta_content")->find(15);

            // dd($booking);
            if ($booking) {
                return view('Frontend.Booking.book-an-appointment-reshedule', compact('data', 'booking', 'barber_data'));
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
            if (!empty($data)) {

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

                if (!empty($booking)) {
                    $bookingServiceDetail = BookingServiceDetail::where('booking_id', $data->id)->get();
                    if (!empty($bookingServiceDetail)) {
                        foreach ($bookingServiceDetail as $key => $booking_detail) {

                            list($start, $end) = explode('-', $request->slots[$key]);
                            $booking_reschesule_detail = new BookingServiceDetail();
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

            } else {
                return response()->json(['status' => 0, 'message' => __('message.Somthing went wrong')]);
            }

            if (!empty($booking)) {
                resechedule_booking($request->booking_id, $booking->id);
                sendPushNotification($booking->user_id, 'booking-reschedule-from-customer-info-to-customer', 'booking-reschedule', 'booking-reschedule');
                sendPushNotification($booking->barber_id, 'booking-reschedule-from-customer-info-to-barber', 'booking-reschedule-from-customer', 'booking-reschedule-from-customer');
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

            $data = new BarberRating();
            $data->user_id = Auth::user()->id;
            $data->barber_id = $request->barber_id;
            $data->booking_id = $request->booking_id;
            $data->rating = $request->rating;
            $data->save();

            $booking_id = Crypt::encryptString($request->booking_id);

            sendEmail(Auth::user()->id, 'customer-rating-to-barber', $request->booking_id);

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

            sendEmail($data->user_id, 'customer-chnage-status-for-barber-proposal', $data->booking_id);
            sendPushNotification($data->barber_id, 'customer-chnage-status-for-barber-proposal-to-barber', 'customer-chnage-status-for-barber-proposal', 'customer-chnage-status-for-barber-proposal');

            return response()->json([
                'status' => 1,
                'message' => __('message.Barber Proposal reject successfully'),
            ], 200);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()], 400
            );
        }
    }

    public function acceptBarberProposal($id)
    {

        try {

            $data = BarberProposal::find($id);
            $data->status = "accept";
            $data->update();

            if ($data->status == "accept") {
                $booking_service_detail = BookingServiceDetail::where('booking_id', $data->booking_id)->orderBy('id', 'DESC')->get();
                foreach ($booking_service_detail as $key => $service_detail) {
                    list($start, $end) = explode('-', $data->slots[$key]);
                    $booking_detail = BookingServiceDetail::find($service_detail->id);
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

                $check = Chats::where('user_id1', $data->user_id)->where('user_id2', $data->barber_id)->exists();
                if ($check == null) {
                    $create_chat = new Chats();
                    $create_chat->user_id1 = $data->user_id;
                    $create_chat->user_id2 = $data->barber_id;
                    $create_chat->chat_unique_key = chat_unique_key();
                    $create_chat->save();
                }

            }

            //helper
            creditPoint('booking', $booking->user_id);
            creditPoint('active_referral', $booking->user_id);
            loyalClient($booking->user_id, $booking->barber_id);

            sendEmail($data->user_id, 'customer-chnage-status-for-barber-proposal', $data->booking_id);
            sendPushNotification($data->barber_id, 'customer-chnage-status-for-barber-proposal-to-barber', 'Customer chnage status for barber proposal', 'Customer chnage status for barber proposal');

            return response()->json([
                'status' => 1,
                'message' => __('message.Barber Proposal accept successfully'),
            ], 200);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()], 400
            );
        }
    }

    public function bookingInvoice($id)
    {
        try {
            // Fetch the booking data and service details
            $bdata = Booking::where('id', $id)
                ->with('booking_service_detailss', 'customer_detail', 'barber_detail')
                ->first();

            $serviceDetails = BookingServiceDetail::where('booking_id', $id)
                ->get();

            // Load the view and generate the PDF
            $pdf = Pdf::loadView('PDF.invoice', compact('bdata', 'serviceDetails'));

            // Automatically download the PDF
            return $pdf->download('invoice.pdf');

        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()], 400
            );
        }

    }

}
