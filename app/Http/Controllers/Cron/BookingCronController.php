<?php

namespace App\Http\Controllers\Cron;

use Carbon\Carbon;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingCronController extends Controller
{
    //

    public function bookingFinished()
    {
         $data = Booking::where('status','accept')->get();



         // Get current date and time
         $currentDateTime = Carbon::now();
         $currentDate = $currentDateTime->toDateString(); // 'Y-m-d'

         foreach($data  as $booking)
         {
            $bookingDate = $booking->booking_date; // e.g., '2024-07-31'
            $startTime = $booking->start_time; // e.g., '11:30:00'
            $endTime = $booking->end_time; // e.g., '12:30:00'
            $currentDateTime = Carbon::now();


            if($bookingDate != "" && $startTime != "" && $endTime != "") {
            // Create Carbon instances for booking start and end times
            $bookingStartDateTime = Carbon::createFromFormat('Y-m-d H:i:s', "$bookingDate $startTime");
            $bookingEndDateTime = Carbon::createFromFormat('Y-m-d H:i:s', "$bookingDate $endTime");

            // Determine process status based on the comparison
            $booking_check = $currentDateTime->greaterThan($bookingEndDateTime) ? 'old' : 'upcoming';
            if($booking_check  == "old")
            {
                    $select_booking = Booking::find($booking->id);
                    $select_booking->status = "finished";
                    $select_booking->update();

                    finished_booking($select_booking->id);
                    sendPushNotification($booking->user_id,'booking-finished-to-customer','booking-finished-to-customer','booking-finished-to-customer');
                    sendPushNotification($booking->barber_id,'booking-finished-to-barber','booking-finished-to-barber','booking-finished-to-barber');


                }

            }

         }


         echo "Cron Runnning Done";

    }


    public function cancelPendingBooking()
    {
         $data = Booking::where('status','pending')->where('booking_type','booking')->get();

         // Get current date and time
         $currentDateTime = Carbon::now();
         $currentDate = $currentDateTime->toDateString(); // 'Y-m-d'

         foreach($data  as $booking)
         {
            $bookingDate = $booking->booking_date; // e.g., '2024-07-31'
            $startTime = $booking->start_time; // e.g., '11:30:00'
            $endTime = $booking->end_time; // e.g., '12:30:00'
            $currentDateTime = Carbon::now();

            // Create Carbon instances for booking start and end times
            $bookingStartDateTime = Carbon::createFromFormat('Y-m-d H:i:s', "$bookingDate $startTime");
            $bookingEndDateTime = Carbon::createFromFormat('Y-m-d H:i:s', "$bookingDate $endTime");

            // Determine process status based on the comparison
            $booking_check = $currentDateTime->greaterThan($bookingEndDateTime) ? 'old' : 'upcoming';
            if($booking_check  == "old")
            {
                    $select_booking = Booking::find($booking->id);
                    $select_booking->status = "cancel";
                    $select_booking->update();

                    cancel_booking($select_booking->id);
                    sendPushNotification($booking->user_id,'cancel-booking-when-barber-not-respond-to-customer','your-appointment-cancel-due-to-a-barber-busy-schedule','your-appointment-cancel-due-to-a-barber-busy-schedule');

            }

         }


          echo "Cron Runnning Done";

    }


    public function notificationDemo(Request $request)
    {
                 sendPushNotification(114, "notification_type_demo", "title", "message checking");
    }








}
