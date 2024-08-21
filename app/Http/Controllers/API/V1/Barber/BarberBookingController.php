<?php

namespace App\Http\Controllers\API\V1\Barber;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Barber\BarberBookingDetailResource;
use App\Http\Resources\Api\Barber\BarberBookingResource;
use App\Models\BarberProposal;
use App\Models\Booking;
use App\Models\Chats;
use App\Models\WaitList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarberBookingController extends Controller
{
    //
    public function getAllBarberAppointments(Request $request)
    {
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

        try {
            $data = Booking::with('customer_detail', 'booking_service_detailss.main_service', 'booking_service_detailss.sub_service', 'customer_prefrences')->where('barber_id', Auth::user()->id)->find($id);

            if ($data->booking_type == "waitlist") {
                $data->waitlist = WaitList::where('booking_id', $data->id)->get();
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
                loyalClient($data->user_id,$data->barber_id);
            }

            sendEmail($data->user_id, 'barber-booking-status-chnage', $data->id);

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
                // $data = Booking::find($request->booking_id);
                // $data->status = $request->status;
                // $data->update();

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

                loyalClient($data->user_id,$data->barber_id);


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

}
