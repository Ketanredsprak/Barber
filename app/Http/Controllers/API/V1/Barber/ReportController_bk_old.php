<?php

namespace App\Http\Controllers\API\V1\Barber;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    //
    public function report_bk(Request $request)
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
        // $validated['barber_id'] = "required";
        $validated['booking_date'] = "required";
        $validated['end_date'] = "required";

        $customMessages = [
            'date.required' => __('error.The date field is required.'),
        ];

        $request->validate($validated, $customMessages);

        try {

            $total_booking = Booking::where('barber_id', Auth::user()->id)->where('booking_date', '>=', $request->booking_date)->where('booking_date', '<=', $request->end_date)->count();
            $total_amount = Booking::where('barber_id', Auth::user()->id)->where('booking_date', '>=', $request->booking_date)->where('booking_date', '<=', $request->end_date)->sum('total_price');

            return response()->json(
                [
                    'total_booking' => $total_booking,
                    'total_amount' => $total_amount,
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

    public function report(Request $request)
    {
        // Validate request
        // $request->validate([
        //     'booking_date' => 'required|date',
        //     'end_date' => 'required|date|after_or_equal:booking_date',
        // ]);
        $validated = [];
        // $validated['barber_id'] = "required";
        $validated['start_date'] = "required";
        $validated['end_date'] = "required";

        $customMessages = [
            'date.required' => __('error.The date field is required.'),
        ];

        $request->validate($validated, $customMessages);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);


        // Fetch data for the four arrays
        $dailyData = $this->getDailyData($startDate, $endDate);
        $weeklyData = $this->getWeeklyData($startDate, $endDate);
        $monthlyData = $this->getMonthlyData($startDate, $endDate);
        $annuallyData = $this->getAnnuallyData($startDate, $endDate);

        // Return response
        return response()->json([
            'daily' => $dailyData,
            'weekly' => $weeklyData,
            'monthly' => $monthlyData,
            'annually' => $annuallyData,
        ]);
    }

    private function getDailyData($startDate, $endDate)
    {
        // Generate an array of dates from the start date to the end date
        $dateRange = collect();
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $dateRange->push($currentDate->format('Y-m-d'));
            $currentDate->addDay();
        }

        // Get bookings within the date range
        $bookings = Booking::selectRaw('DATE(booking_date) as date, COUNT(*) as total_bookings')
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->groupBy('date')
            ->pluck('total_bookings', 'date');

        // Map the date range and fill in missing dates with 0
        return $dateRange->map(function ($date) use ($bookings) {
            return [
                'date' => $date,
                'total_bookings' => $bookings->get($date, 0), // Get the booking count or default to 0
            ];
        });
    }

    // private function getDailyData($startDate, $endDate)
    // {
    //     return Booking::selectRaw('DATE(booking_date) as date, COUNT(*) as total_bookings')
    //         ->whereBetween('booking_date', [$startDate, $endDate])
    //         ->groupBy('date')
    //         ->get();
    // }

    private function getWeeklyData($startDate, $endDate)
    {
        $weekRange = collect();
        $currentWeek = $startDate->copy()->startOfWeek();

        while ($currentWeek->lte($endDate)) {
            $weekRange->push($currentWeek->format('Y-W')); // Year-Week format
            $currentWeek->addWeek();
        }

        // Get bookings within the week range
        $bookings = Booking::selectRaw('YEAR(booking_date) as year, WEEK(booking_date) as week, COUNT(*) as total_bookings')
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->groupBy('year', 'week')
            ->get()
            ->mapWithKeys(function ($booking) {
                return [$booking->year . '-' . $booking->week => $booking->total_bookings];
            });

        // Map the week range and fill in missing weeks with 0
        return $weekRange->map(function ($week) use ($bookings) {
            return [
                'week' => $week,
                'total_bookings' => $bookings->get($week, 0), // Get the booking count or default to 0
            ];
        });
    }

    // private function getWeeklyData($startDate, $endDate)
    // {
    //     return Booking::selectRaw('WEEK(booking_date) as week, COUNT(*) as total_bookings')
    //         ->whereBetween('booking_date', [$startDate, $endDate])
    //         ->groupBy('week')
    //         ->get();
    // }


    private function getMonthlyData($startDate, $endDate)
    {
        $monthRange = collect();
        $currentMonth = $startDate->copy()->startOfMonth();

        while ($currentMonth->lte($endDate)) {
            $monthRange->push($currentMonth->format('Y-m')); // Year-Month format
            $currentMonth->addMonth();
        }

        // Get bookings within the month range
        $bookings = Booking::selectRaw('YEAR(booking_date) as year, MONTH(booking_date) as month, COUNT(*) as total_bookings')
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->groupBy('year', 'month')
            ->get()
            ->mapWithKeys(function($booking) {
                return [$booking->year . '-' . $booking->month => $booking->total_bookings];
            });

        // Map the month range and fill in missing months with 0
        return $monthRange->map(function($month) use ($bookings) {
            return [
                'month' => $month,
                'total_bookings' => $bookings->get($month, 0), // Get the booking count or default to 0
            ];
        });
    }


    // private function getMonthlyData($startDate, $endDate)
    // {
    //     return Booking::selectRaw('MONTH(booking_date) as month, COUNT(*) as total_bookings')
    //         ->whereBetween('booking_date', [$startDate, $endDate])
    //         ->groupBy('month')
    //         ->get();
    // }


    private function getAnnuallyData($startDate, $endDate)
{
    $yearRange = collect();
    $currentYear = $startDate->copy()->startOfYear();

    while ($currentYear->lte($endDate)) {
        $yearRange->push($currentYear->format('Y')); // Year format
        $currentYear->addYear();
    }

    // Get bookings within the year range
    $bookings = Booking::selectRaw('YEAR(booking_date) as year, COUNT(*) as total_bookings')
        ->whereBetween('booking_date', [$startDate, $endDate])
        ->groupBy('year')
        ->pluck('total_bookings', 'year');

    // Map the year range and fill in missing years with 0
    return $yearRange->map(function($year) use ($bookings) {
        return [
            'year' => $year,
            'total_bookings' => $bookings->get($year, 0), // Get the booking count or default to 0
        ];
    });
}



    // private function getAnnuallyData($startDate, $endDate)
    // {
    //     return Booking::selectRaw('YEAR(booking_date) as year, COUNT(*) as total_bookings')
    //         ->whereBetween('booking_date', [$startDate, $endDate])
    //         ->groupBy('year')
    //         ->get();
    // }

}
