<?php

namespace App\Http\Controllers\API\V1\Barber;

use Carbon\Carbon;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

        $validated = [];
        $validated['start_date'] = 'nullable|date';
        $validated['end_date'] = 'nullable|date|after_or_equal:start_date';

        $customMessages = [
            'start_date.required' => __('error.The start date field is required.'),
            'end_date.required' => __('error.The end date field is required.'),
        ];

        $request->validate($validated, $customMessages);

        // Determine date range based on input or default to last 7 days/weeks/months/years
        $startDate = $request->has('start_date') ? Carbon::parse($request->start_date) : null;
        $endDate = $request->has('end_date') ? Carbon::parse($request->end_date) : null;

        if (!$startDate && !$endDate) {
            // If no dates are passed, use the last 7 days/weeks/months/years
            $endDate = Carbon::today();
            $startDate = $endDate->copy()->subDays(6);

            // Fetch data for the four arrays
            $dailyData = $this->getDailyData7Record();
            $weeklyData = $this->getWeeklyData7Record();
            $monthlyData = $this->getMonthlyData7Record();
            $annuallyData = $this->getAnnuallyData7Record();

            //get last 7 years record start
            $totalBookingData = collect();
            $totalAmountData = collect();

// Get the current year and the last 7 years
            $currentYear = Carbon::today()->year;
            $startYear = Carbon::today()->subYears(6)->startOfYear();
            $endYear = Carbon::today()->endOfYear(); // Current year end

            $total_booking = 0;
            $total_amount = 0;

// Get the current year
            $currentYear = Carbon::today()->year;

// Loop through the last 7 years to get the total bookings and sum of total_price for each year
            for ($i = 0; $i < 7; $i++) {
                $year = $currentYear - 6 + $i;

                $yearStartDate = Carbon::createFromDate($year)->startOfYear();
                $yearEndDate = Carbon::createFromDate($year)->endOfYear();

                // Get total bookings for the year and accumulate
                $total_booking += Booking::where('barber_id', Auth::user()->id)
                    ->whereBetween('booking_date', [$yearStartDate, $yearEndDate])
                    ->count();

                // Get total amount for the year and accumulate
                $total_amount += Booking::where('barber_id', Auth::user()->id)
                    ->whereBetween('booking_date', [$yearStartDate, $yearEndDate])
                    ->sum('total_price');
            }

        } else {

            // Fetch data for the four arrays
            $dailyData = $this->getDailyData($startDate, $endDate);
            $weeklyData = $this->getWeeklyData($startDate, $endDate);
            $monthlyData = $this->getMonthlyData($startDate, $endDate);
            $annuallyData = $this->getAnnuallyData($startDate, $endDate);

            $total_booking = Booking::where('barber_id', Auth::user()->id)->where('booking_date', '>=', $request->start_date)->where('booking_date', '<=', $request->end_date)->count();
            $total_amount = Booking::where('barber_id', Auth::user()->id)->where('booking_date', '>=', $request->start_date)->where('booking_date', '<=', $request->end_date)->sum('total_price');

        }



        // Return response
        return response()->json([
            'daily' => $dailyData->sortByDesc('date')->values()->all(),
            'weekly' => $weeklyData->sortByDesc('week')->values()->all(),
            'monthly' => $monthlyData->sortByDesc('month')->values()->all(),
            'annually' => $annuallyData->sortByDesc('year')->values()->all(),
            'total_booking' => $total_booking,
            'total_amount' => $total_amount,
            'message' => __('message.Data get successfully.'),
            'status' => 1,
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
        $bookings = Booking::where('barber_id', Auth::user()->id)->selectRaw('DATE(booking_date) as date, COUNT(*) as total_bookings')
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->orderBy('id', 'DESC') // Order by latest record first
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
        // Create a collection to hold the weeks
        $weekRange = collect();

        // Initialize the current week to the start of the week for the start date
        $currentWeek = $startDate->copy()->startOfWeek();

        // Loop through and add weeks until we reach the end date
        while ($currentWeek->lte($endDate)) {
            $weekRange->push($currentWeek->format('Y-W')); // Format: Year-Week
            $currentWeek->addWeek(); // Move to the next week
        }

        // Fetch bookings within the date range grouped by year and week
        $bookings = Booking::where('barber_id', Auth::user()->id)
            ->selectRaw('YEAR(booking_date) as year, WEEK(booking_date, 1) as week, COUNT(*) as total_bookings')
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->groupBy('year', 'week')
            ->orderBy('id', 'DESC') // Order by latest record first
            ->get()
            ->mapWithKeys(function ($booking) {
                return [$booking->year . '-' . str_pad($booking->week, 2, '0', STR_PAD_LEFT) => $booking->total_bookings];
            });

        // Map the week range and fill in missing weeks with 0
        return $weekRange->map(function ($week, $index) use ($bookings) {
            return [
                'week' => $index + 1, // Weeks starting from 1
                'total_bookings' => $bookings->get($week, 0), // Default to 0 if no bookings
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
        $bookings = Booking::where('barber_id', Auth::user()->id)->selectRaw('YEAR(booking_date) as year, MONTH(booking_date) as month, COUNT(*) as total_bookings')
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->groupBy('year', 'month')
            ->orderBy('id', 'DESC') // Order by latest record first
            ->get()
            ->mapWithKeys(function ($booking) {
                return [$booking->year . '-' . $booking->month => $booking->total_bookings];
            });

        // Map the month range and fill in missing months with 0
        return $monthRange->map(function ($month) use ($bookings) {
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
        $bookings = Booking::where('barber_id', Auth::user()->id)->selectRaw('YEAR(booking_date) as year, COUNT(*) as total_bookings')
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->groupBy('year')
            ->orderBy('id', 'DESC') // Order by latest record first
            ->pluck('total_bookings', 'year');

        // Map the year range and fill in missing years with 0
        return $yearRange->map(function ($year) use ($bookings) {
            return [
                'year' => $year,
                'total_bookings' => $bookings->get($year, 0), // Get the booking count or default to 0
            ];
        });
    }

    private function getDailyData7Record()
    {
        // Get the last 7 days
        $endDate = Carbon::today();
        $startDate = $endDate->copy()->subDays(6);

        // Generate the date range (last 7 days)
        $dateRange = collect();
        for ($i = 0; $i < 7; $i++) {
            $dateRange->push($startDate->copy()->addDays($i)->format('Y-m-d'));
        }

        // Fetch booking data for these days
        $bookings = Booking::where('barber_id', Auth::user()->id)->selectRaw('DATE(booking_date) as date, COUNT(*) as total_bookings')
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->orderBy('id', 'DESC') // Order by latest record first
            ->groupBy('date')
            ->get()
            ->mapWithKeys(function ($booking) {
                return [$booking->date => $booking->total_bookings];
            });

        // Return the last 7 days with missing days filled with 0
        return $dateRange->map(function ($date) use ($bookings) {
            return [
                'date' => $date,
                'total_bookings' => $bookings->get($date, 0), // Fill missing days with 0
            ];
        });
    }

    private function getWeeklyData7Record()
    {
        // Get the current week number and generate the last 7 weeks
        $endDate = Carbon::today();
        $startDate = $endDate->copy()->subWeeks(6);

        // Generate the week range (last 7 weeks)
        $weekRange = collect();
        for ($i = 0; $i < 7; $i++) {
            $weekRange->push($startDate->copy()->addWeeks($i)->format('Y-W')); // Year-Week format
        }

        // Fetch booking data for these weeks
        $bookings = Booking::where('barber_id', Auth::user()->id)->selectRaw('YEAR(booking_date) as year, WEEK(booking_date) as week, COUNT(*) as total_bookings')
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->groupBy('year', 'week')
            ->orderBy('id', 'DESC') // Order by latest record first
            ->get()
            ->mapWithKeys(function ($booking) {
                return [$booking->year . '-' . str_pad($booking->week, 2, '0', STR_PAD_LEFT) => $booking->total_bookings];
            });

        // Return the last 7 weeks with missing weeks filled with 0
        return $weekRange->map(function ($week) use ($bookings) {
            return [
                'week' => $week,
                'total_bookings' => $bookings->get($week, 0), // Fill missing weeks with 0
            ];
        });
    }

    private function getMonthlyData7Record()
    {
        // Get the current month and generate the last 7 months
        $endDate = Carbon::today()->startOfMonth();
        $startDate = $endDate->copy()->subMonths(6);

        // Generate the month range (last 7 months)
        $monthRange = collect();
        for ($i = 0; $i < 7; $i++) {
            $monthRange->push($startDate->copy()->addMonths($i)->format('Y-m')); // Year-Month format
        }

        // Fetch booking data for these months
        $bookings = Booking::where('barber_id', Auth::user()->id)->selectRaw('YEAR(booking_date) as year, MONTH(booking_date) as month, COUNT(*) as total_bookings')
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->groupBy('year', 'month')
            ->orderBy('id', 'DESC') // Order by latest record first
            ->get()
            ->mapWithKeys(function ($booking) {
                return [$booking->year . '-' . str_pad($booking->month, 2, '0', STR_PAD_LEFT) => $booking->total_bookings];
            });

        // Return the last 7 months with missing months filled with 0
        return $monthRange->map(function ($month) use ($bookings) {
            return [
                'month' => $month,
                'total_bookings' => $bookings->get($month, 0), // Fill missing months with 0
            ];
        });
    }

    private function getAnnuallyData7Record()
    {
        // Get the current year and generate the last 7 years
        $currentYear = Carbon::today()->year;
        $startDate = Carbon::today()->subYears(6)->startOfYear(); // Start 6 years ago from the start of the year
        $endDate = Carbon::today()->endOfYear(); // End of the current year

        // Generate the year range (last 7 years)
        $yearRange = collect();
        for ($i = 0; $i < 7; $i++) {
            $yearRange->push($currentYear - 6 + $i); // Last 7 years, including the current year
        }

        // Fetch booking data for these years
        $bookings = Booking::where('barber_id', Auth::user()->id)->selectRaw('YEAR(booking_date) as year, COUNT(*) as total_bookings')
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->groupBy('year')
            ->orderBy('id', 'DESC') // Order by latest record first
            ->get()
            ->mapWithKeys(function ($booking) {
                return [$booking->year => $booking->total_bookings];
            });

        // Return the last 7 years with missing years filled with 0
        return $yearRange->map(function ($year) use ($bookings) {
            return [
                'year' => (string) $year,
                'total_bookings' => $bookings->get($year, 0), // Fill missing years with 0
            ];
        });
    }


    public function generateExcel(Request $request)
    {

        $validated = [];
        $validated['start_date'] = 'required|date';
        $validated['end_date'] = 'required|date|after_or_equal:start_date';

        $customMessages = [
            'start_date.required' => __('error.The start date field is required.'),
            'end_date.required' => __('error.The end date field is required.'),
        ];

        $request->validate($validated, $customMessages);

        // Fetch records between start and end date
        $data = Booking::with("barber_detail", "customer_detail")->where('barber_id', Auth::user()->id)->where('booking_date', '>=', $request->start_date)->where('booking_date', '<=', $request->end_date)->get();

        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set spreadsheet headers
        $sheet->setCellValue('A1', 'ID')
            ->setCellValue('B1', 'Barber Name')
            ->setCellValue('C1', 'Customer Name')
            ->setCellValue('D1', 'Booking Date')
            ->setCellValue('E1', 'Booking Type')
            ->setCellValue('F1', 'Total Price')
            ->setCellValue('G1', 'Status')
            ->setCellValue('H1', 'Booking Start Time')
            ->setCellValue('I1', 'Booking End Time');

        // Fill spreadsheet with data
        $row = 2; // Starting from row 2, row 1 is the header
        foreach ($data as $record) {
            $sheet->setCellValue('A' . $row, $record->id)
                ->setCellValue('B' . $row, ($record->barber_detail->first_name ?? "") . " " . ($record->barber_detail->last_name ?? ""))
                ->setCellValue('C' . $row, ($record->customer_detail->first_name ?? "") . " " . ($record->customer_detail->last_name ?? ""))
                ->setCellValue('D' . $row, $record->booking_date)
                ->setCellValue('E' . $row, $record->booking_type)
                ->setCellValue('F' . $row, $record->total_price)
                ->setCellValue('G' . $row, $record->status)
                ->setCellValue('H' . $row, $record->start_time)
                ->setCellValue('I' . $row, $record->end_time);
            $row++;
        }

        // Create writer instance and save to a temporary file
        $writer = new Xlsx($spreadsheet);
        $fileName = 'report_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        // Define the destination path
        $destinationPath = public_path('/reports/' . $fileName);
        // Create writer instance and save directly to the public/report folder
        $writer->save($destinationPath);

        return response()->json([
            'file_path' => URL::to('/public') . '/reports/' . ($fileName),
            'status' => 1,
            'message' => __('message.Booking report generate successfully'),
        ], 200);

    }

}
