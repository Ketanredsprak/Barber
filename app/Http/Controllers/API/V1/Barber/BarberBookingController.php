<?php

namespace App\Http\Controllers\API\V1\Barber;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Barber\BarberBookingDetailResource;
use App\Http\Resources\Api\Barber\BarberBookingResource;
use App\Models\BarberProposal;
use App\Models\BarberSchedule;
use App\Models\Booking;
use App\Models\BookingServiceDetail;
use App\Models\Chats;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarberBookingController extends Controller
{
    //
    public function getAllBarberAppointments(Request $request)
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

        $validated = $request->validate(
            ['status' => 'required'],
            ['status.required' => __('error.The status field is required.')]
        );

        try {
            $currentDate = Carbon::now()->toDateString(); // Current date
            $currentTime = Carbon::now()->toTimeString(); // Current time

            $query = Booking::with('customer_detail', 'booking_service_detailss')->where('barber_id', Auth::user()->id)->orderBy('id', 'DESC');

            if ($request->status == "all") {
                // No additional conditions needed for "all"
            } elseif ($request->status == "upcoming") {
                $query->where(function ($q) use ($currentDate, $currentTime) {
                    $q->where('booking_type', 'booking')->where('booking_date', '>', $currentDate)
                        ->orWhere(function ($q) use ($currentDate, $currentTime) {
                            $q->where('booking_date', '=', $currentDate)
                                ->where('start_time', '>=', $currentTime);
                        });
                });
            } elseif ($request->status == "finished") {
                $query->where('status', 'finished')->where('booking_type', 'booking');
            } elseif ($request->status == "waitlist") {
                $query->where('booking_type', 'waitlist');
            }

            $total = $query->count();
            $data = $query->paginate(10);

            if ($data->isNotEmpty()) {
                $results = BarberBookingResource::collection($data);
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

    public function getBarberAppointmentDetail($id, Request $request)
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

        try {
            $data = Booking::with('customer_detail', 'booking_service_detailss.main_service', 'booking_service_detailss.sub_service', 'customer_prefrences')->where('barber_id', Auth::user()->id)->find($id);

            if ($data->booking_type == "waitlist") {
                if ($data->barber_proposal_status == 1) {
                    $data->barber_proposal = BarberProposal::where("booking_id", $data->id)->first();
                }
            }

            if (count($data->customer_prefrences) == 1) {
                $data->direct_accept = 1;
            } else {
                $data->direct_accept = 0;
            }

            $results = new BarberBookingDetailResource($data);
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

    public function acceptOrRejectCustomerAppointment(Request $request)
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

        try {
            $data = Booking::find($request->booking_id);
            $data->status = $request->status;
            $data->update();

            $check = Chats::where('user_id1', $data->user_id)->where('user_id2', $data->barber_id)->exists();
            if ($check == null) {
                $create_chat = new Chats();
                $create_chat->user_id1 = $data->user_id;
                $create_chat->user_id2 = $data->barber_id;
                $create_chat->chat_unique_key = chat_unique_key();
                $create_chat->save();

            }

            if ($request->status == "accept") {
                creditPoint('booking', $data->user_id);
                creditPoint('active_referral', $data->user_id);
                loyalClient($data->user_id, $data->barber_id);
            }

            sendEmail($data->user_id, 'barber-booking-status-chnage', $data->id);
            sendPushNotification($data->user_id, 'barber-booking-status-change-to-customer', 'barber-booking-status-change', 'barber-booking-status-change');

            return response()->json([
                'status' => 1,
                'message' => __('message.Record Update Successfully'),
            ], 200);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()], 400
            );
        }

    }

    public function acceptOrRejectCustomerWithJoinWaitlistAppointment(Request $request)
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
            'status' => 'required',
            'booking_date' => 'required_if:status,accept',
            'slots' => 'required_if:status,accept|array',
            'booking_id' => 'required',
            'user_id' => 'required',
            'barber_id' => 'required',
        ], [
            'status.required' => __('error.The status field is required.'),
            'booking_date.required_if' => __('error.The booking date field is required when the status is accept.'),
            'slots.required_if' => __('error.The time field is required when the status is accept.'),
            'booking_id.required' => __('error.The booking id field is required.'),
            'user_id.required' => __('error.The user id field is required.'),
            'barber_id.required' => __('error.The barber id field is required.'),
        ]);

        try {

            if ($request->status == "accept") {
                $data = Booking::find($request->booking_id);
                $data->barber_proposal_status = 1;
                // $data->status = $request->status;
                $data->update();

                $BarberProposal = new BarberProposal();
                $BarberProposal->booking_date = $request->booking_date;
                $BarberProposal->booking_id = $request->booking_id;
                $BarberProposal->slots = $request->slots;
                $BarberProposal->user_id = $request->user_id;
                $BarberProposal->barber_id = $request->barber_id;
                $BarberProposal->status = "pending";
                $BarberProposal->save();

                $check = Chats::where('user_id1', $request->user_id)->where('user_id2', $request->barber_id)->exists();
                if ($check == null) {
                    $create_chat = new Chats();
                    $create_chat->user_id1 = $request->user_id;
                    $create_chat->user_id2 = $request->barber_id;
                    $create_chat->chat_unique_key = chat_unique_key();
                    $create_chat->save();
                }

                sendEmail($request->user_id, 'barber-send-proposal-to-customer', $request->booking_id);
                sendPushNotification($data->user_id, 'barber-proposal-for-booking-to-customer', 'barber-send-proposal-for-booking', 'barber-send-proposal-for-booking');

                return response()->json([
                    'status' => 1,
                    'message' => __('message.New Proposal send to customer for appointment.'),
                ], 200);

            } else {
                $data = Booking::find($request->booking_id);
                $data->status = $request->status;
                $data->update();

                $check_chat_create = Chats::where('user_id1', $data->user_id)->where('user_id2', $data->barber_id)->first();
                if ($check_chat_create == null) {
                    $create_chat = new Chats();
                    $create_chat->user_id1 = $data->user_id;
                    $create_chat->user_id2 = $data->barber_id;
                    $create_chat->chat_unique_key = chat_unique_key();
                    $create_chat->save();
                }

                loyalClient($data->user_id, $data->barber_id);

                return response()->json([
                    'status' => 1,
                    'message' => __('message.Record Update Successfully'),
                ], 200);
            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()], 400
            );
        }

    }

    public function directAcceptWaitlist(Request $request)
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
            'booking_id' => 'required',
        ], [
            'booking_id.required' => __('error.The booking id field is required.'),
        ]);

        try {

            $data = Booking::with('barber_detail', 'customer_detail', 'booking_service_detailss', 'barber_proposal', 'customer_prefrences')->find($request->booking_id);
            if ($data) {
                if ($data->customer_prefrences) {

                    $count = count($data->customer_prefrences);
                    $service_count = count($data->booking_service_detailss);

                    if ($count == 1) {

                        $from_time = $data->customer_prefrences[0]->from_time;
                        $to_time = $data->customer_prefrences[0]->to_time;
                        $selected_date = $data->customer_prefrences[0]->selected_date;
                        $select_time = $data->customer_prefrences[0]->select_time;

                        $day_name = date('l', strtotime($selected_date));
                        $check_barber_schedule = BarberSchedule::where("barber_id", $data->barber_id)->first();
                        $day_is_holiday = strtolower($day_name) . '_is_holiday';
                        $day_start_time = strtolower($day_name) . '_start_time';
                        $day_end_time = strtolower($day_name) . '_end_time';

                        if ($check_barber_schedule->$day_is_holiday == 1) {
                            return response()->json([
                                'status' => 0,
                                'message' => __('message.Holiday found for this date'),
                            ], 400);

                        }

                        if ($check_barber_schedule->$day_is_holiday == 0) {
                            $day_start = $check_barber_schedule->$day_start_time;
                            $day_end = $check_barber_schedule->$day_end_time;

                            $start_time_ts = strtotime($from_time);
                            $end_time_ts = strtotime($to_time);
                            $day_start_ts = strtotime($day_start);
                            $day_end_ts = strtotime($day_end);

                            // Check if $start_time and $end_time are within the range of $day_start and $day_end
                            if ($start_time_ts >= $day_start_ts && $end_time_ts <= $day_end_ts) {

                                if ($select_time == 1) {

                                    $booking_checking = Booking::where('barber_id', $data->barber_id)->where("booking_type", "booking")->where('booking_date', $selected_date)->whereBetween('start_time', [$from_time, $to_time])->get();

                                    if ($booking_checking->isEmpty()) {

                                        //time calcution
                                        // Convert the start time to a DateTime object
                                        $start_time = new DateTime($from_time);

                                        // Each service adds 30 minutes, so calculate the total duration
                                        $total_minutes = $service_count * 30;

                                        // Add the total minutes to the start time to get the end time
                                        $end_time = clone $start_time;
                                        $end_time->modify("+{$total_minutes} minutes");

                                        $data = Booking::find($request->booking_id);
                                        $data->booking_date = $selected_date;
                                        $data->start_time = $start_time->format('H:i');
                                        $data->end_time = $end_time->format('H:i');
                                        $data->status = "accept";
                                        $data->booking_type = "booking";
                                        $data->update();

                                        $start_time = "";
                                        $start_time = new DateTime($data->start_time); // Initialize with the given start time
                                        $duration_per_service = 30; // Each service adds 30 minutes

                                        foreach ($data->booking_service_detailss as $index => $booking_detail) {
                                            // Find the booking detail record
                                            $update_booking_detail = BookingServiceDetail::find($booking_detail->id);

                                            // Set start and end times for the current record
                                            $update_booking_detail->start_time = $start_time->format('H:i');

                                            // Calculate the end time by adding 30 minutes to the start time
                                            $end_time = clone $start_time;
                                            $end_time->modify("+{$duration_per_service} minutes");
                                            $update_booking_detail->end_time = $end_time->format('H:i');

                                            // Update the record in the database
                                            $update_booking_detail->update();

                                            // Set the new start time for the next record
                                            $start_time = clone $end_time;
                                        }

                                        return response()->json([
                                            'status' => 1,
                                            'message' => __('message.Booking accept successfully'),
                                        ], 200);

                                    } else {
                                        return response()->json([
                                            'status' => 0,
                                            'message' => __('message.Already booking found for this date and time'),
                                        ], 400);
                                    }

                                } else {
                                    return response()->json([
                                        'status' => 0,
                                        'message' => __('message.Please send proposal to customer'),
                                    ], 400);
                                }
                            } else {

                                return response()->json([
                                    'status' => 0,
                                    'message' => __('message.Booking is outside the your working hours'),
                                ], 400);

                            }

                        }

                    } else {
                        return response()->json([
                            'status' => 0,
                            'message' => __('message.Please send proposal to customer'),
                        ], 400);
                    }

                } else {

                    return response()->json([
                        'status' => 0,
                        'message' => __('message.Somthing went wrong'),
                    ], 400);

                }

            } else {
                return response()->json([
                    'status' => 0,
                    'message' => __('message.Somthing went wrong'),
                ], 400);

            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()], 400
            );
        }

    }

}
