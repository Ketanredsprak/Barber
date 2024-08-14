<?php

namespace App\Http\Controllers\Admin;


use DataTables;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookingRequest;
use App\Models\BookingServiceDetail;
use Illuminate\Support\Facades\Crypt;


class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // function __construct()
    // {
    //     $this->middleware('permission:booking-list', ['only' => ['index']]);
    //     $this->middleware('permission:booking-create', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:booking-edit', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:booking-delete', ['only' => ['destroy']]);
    //     $this->middleware('permission:booking-status', ['only' => ['bookingStatus']]);
    // }

    public function index(Request $request)
    {
        //

        if ($request->ajax()) {
            $data = Booking::with(['barber_detail', 'customer_detail'])
                ->orderBy('id', 'DESC')
                ->get();



            // // Print the barber_detail for each booking
            // foreach ($data as $booking) {
            //     dd($booking->barber_detail['first_name']);
            // }


            // Get the user details
            // $user = $data->user;

            $locale = App::getLocale();
            return Datatables::of($data)->addIndexColumn()

                ->addColumn('barber_details', function ($booking) {
                    if ($booking->barber_detail->profile_image == null && $booking->barber_detail->profile_image == "") {
                        return ' <ul>
                        <li>
                          <div class="media"><img class="b-r-8 img-40" src=' . URL::to('/public') . '/admin/assets/images/user/user.png' . '  alt="Generic placeholder image"> <div class="media-body">
                          <div class="row">
                            <div class="col-xl-12">
                            <h6 class="mt-0">&nbsp;&nbsp; ' . $booking->barber_detail->first_name . ' ' . $booking->barber_detail->last_name . '</span></h6>
                            </div>
                          </div>
                          <p>&nbsp;&nbsp; ' . $booking->barber_detail->email . '</p>
                        </div>
                      </div>
                    </li>
                  </ul>';
                    } else {
                        return ' <ul>
                        <li>
                          <div class="media"><img class="b-r-8 img-40" src=' . URL::to('/public') . '/profile_image/' . $booking->barber_detail->profile_image . '  alt="Generic placeholder image">
                            <div class="media-body">
                              <div class="row">
                                <div class="col-xl-12">
                                <h6 class="mt-0">&nbsp;&nbsp; ' . $booking->barber_detail->first_name . ' ' . $booking->barber_detail->last_name . '</span></h6>
                                </div>
                              </div>
                              <p>&nbsp;&nbsp; ' . $booking->barber_detail->email . '</p>
                            </div>
                          </div>
                        </li>
                      </ul>';
                    }
                })

                ->addColumn('user_details', function ($booking) {
                    if ($booking->customer_detail->profile_image == null && $booking->customer_detail->profile_image == "") {
                        return ' <ul>
                        <li>
                          <div class="media"><img class="b-r-8 img-40" src=' . URL::to('/public') . '/admin/assets/images/user/user.png' . '  alt="Generic placeholder image"> <div class="media-body">
                          <div class="row">
                            <div class="col-xl-12">
                            <h6 class="mt-0">&nbsp;&nbsp; ' . $booking->customer_detail->first_name . ' ' . $booking->customer_detail->last_name . '</span></h6>
                            </div>
                          </div>
                          <p>&nbsp;&nbsp; ' . $booking->customer_detail->email . '</p>
                        </div>
                      </div>
                    </li>
                  </ul>';
                    } else {
                        return ' <ul>
                        <li>
                          <div class="media"><img class="b-r-8 img-40" src=' . URL::to('/public') . '/profile_image/' . $booking->customer_detail->profile_image . '  alt="Generic placeholder image">
                            <div class="media-body">
                              <div class="row">
                                <div class="col-xl-12">
                                <h6 class="mt-0">&nbsp;&nbsp; ' . $booking->customer_detail->first_name . ' ' . $booking->customer_detail->last_name . '</span></h6>
                                </div>
                              </div>
                              <p>&nbsp;&nbsp; ' . $booking->customer_detail->email . '</p>
                            </div>
                          </div>
                        </li>
                      </ul>';
                    }
                })

                ->addColumn('booking_date', function ($booking) {
                    // Return the barber's name from the related User model

                    $booking_date = $booking->booking_date;
                    return '<span style="float: right; text-align: right;">' . date('Y-M-d', strtotime($booking_date)) . '</span>';
                })


                ->addColumn('start_time', function ($booking) {
                    // Return the barber's name from the related User model

                    $start_time = $booking->start_time;
                    return '<span style="float: right; text-align: right;">' .  date('h:i A', strtotime($start_time)) . '</span>';
                })

                ->addColumn('end_time', function ($booking) {
                    // Return the barber's name from the related User model

                    $end_time = $booking->end_time;
                    return '<span style="float: right; text-align: right;">' . date('h:i A', strtotime($end_time)) . '</span>';
                })

                ->addColumn('total_price', function ($booking) {
                    // Return the barber's name from the related User model

                    $total_price = $booking->total_price;
                    return '<span style="float: right; text-align: right;">' . $total_price . '</span>';
                })

                ->addColumn('action', function ($row) {
                    $btn = "";
                    $encrypted_Id = Crypt::encryptString($row->id);
                    $btn = $btn . '<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                      <div class="btn-group" role="group">
                        <button class="btn btn-light dropdown-toggle text-primary" id="btnGroupDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                    /*
                    if ($row->status == 1) {
                        $btn = $btn . '<a    href="' . route('booking.status', $row->id) . '" title="' . __('labels.Inactive') . '" class="dropdown-item status-change" data-url="' . route('booking.status', $row->id) . '">' . __('labels.Inactive') . '</a>';
                    } else if ($row->status == 0) {
                        $btn = $btn . '<a   href="javascript:void(0)" href="' . route('booking.status', $row->id) . '"   class="dropdown-item status-change" title="' . __('labels.Active') . '" data-url="' . route('booking.status', $row->id) . '">' . __('labels.Active') . '</a>';
                    } else {
                        $btn = $btn . '<a   href="javascript:void(0)" href="' . route('booking.status', $row->id) . '"   class="dropdown-item status-change" title="' . __('labels.Active') . '" data-url="' . route('booking.status', $row->id) . '">' . __('labels.Active') . '</a>';
                    }
                    */
                    /*
                    $btn = $btn . '<a class="edit-data dropdown-item"  href="javascript:void(0)" title="' . __('labels.Edit') . '" data-url="' . route('booking.edit', $row->id) . '">' . __('labels.Edit') . '</a>';
 /*                   $btn = $btn . '<a href="" data-url="' . route('booking.destroy', $row->id) . '" class="dropdown-item destroy-data" title="' . __('labels.Delete') . '">' . __('labels.Delete') . '</a>';
*/
                    $btn = $btn . '<a href="' . route('booking.show', $encrypted_Id) . '"  class="dropdown-item show-data" title="' . __('labels.Show') . '">' . __('labels.Show') . '</a>';
                    $btn = $btn . '</div>
                      </div>
                    </div>';



                    return $btn;
                })






                ->addColumn('status', function ($row) {
                    // Map status values to badges
                    switch ($row->status) {
                        case 'pending':
                            return '<span class="badge bg-secondary">' . __('labels.Pending') . '</span>';
                        case 'reject':
                            return '<span class="badge bg-danger">' . __('labels.Reject') . '</span>';
                        case 'cancel':
                            return '<span class="badge bg-danger">' . __('labels.Cancel') . '</span>';
                        case 'accept':
                            return '<span class="badge bg-success">' . __('labels.Accept') . '</span>';
                        case 'finished':
                            return '<span class="badge bg-primary">' . __('labels.Finished') . '</span>';
                        case 'rescheduled':
                            return '<span class="badge bg-warning">' . __('labels.Rescheduled') . '</span>';
                        default:
                            return '<span class="badge bg-dark">' . __('labels.Unknown') . '</span>';
                    }
                })


                ->addColumn('name', function ($row) {
                    $locale = App::getLocale();
                    $name = "name_" . $locale;
                    return  $row->$name;
                })






                ->rawColumns(['barber_details', 'user_details', 'booking_date', 'start_time', 'end_time', 'total_price', 'action', 'status'])
                ->make(true);
        }
        return view('Admin.Booking.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.Booking.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookingRequest $request)
    {
        //
        try {
            $post = $request->all();
            $data = new Booking();
            $data->name_en = $request->booking_name_en;
            $data->name_ar = $request->booking_name_ar;
            $data->name_ur = $request->booking_name_ur;
            $data->shortname = $request->booking_short_name;
            $data->phonecode = $request->booking_phone_code;
            $data->status = 1;
            $data->save();
            if (!empty($data)) {
                return response()->json(['status' => '1', 'success' => __('message.Booking Added Successfully.')]);
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $Decrypt_id = Crypt::decryptString($id);

        //    $data = BookingServiceDetail::where('booking_id', $Decrypt_id)->first();

        // Fetch the Booking record
        $booking = Booking::where('id', $Decrypt_id)
            ->with('booking_service_detailss')
            ->first();

        // Check if the Booking record exists
        if ($booking) {

            $serviceDetails = BookingServiceDetail::where('booking_id', $Decrypt_id)
                ->get();

            // Pass data to the view
            return view('Admin.Booking.show', [
                'bdata' => $booking,
                'serviceDetails' => $serviceDetails
            ]);
        } else {
            // Handle case where no records are found
            return redirect()->back()->with('error', 'Booking not found.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        try {
            $data = Booking::find($id);
            if (!empty($data)) {
                return view('Admin.Booking.edit', compact('data'));
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookingRequest $request, string $id)
    {
        //
        try {

            $data =  Booking::find($id);

            $data->shortname = $request->booking_short_name;
            $data->name_en = $request->booking_name_en;
            $data->name_ar = $request->booking_name_ar;
            $data->name_ur = $request->booking_name_ur;
            $data->phonecode = $request->booking_phone_code;
            $data->save();
            if (!empty($data)) {
                return response()->json(['status' => '1', 'success' => __('message.Booking Update Successfully.')]);
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            DB::beginTransaction();
            $data =  Booking::find($id);
            $data->is_delete  = 1;
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => __('message.Booking Deleted Successfully.')]);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function bookingStatus($id)
    {
        try {
            DB::beginTransaction();
            $data = Booking::find($id);
            if ($data->status == 1) {
                $data->status = 0;
                $message =  __('message.Booking Deactived Successfully.');
            } else {
                $data->status = 1;
                $message = __('message.Booking Actived Successfully.');
            }
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => $message]);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
