<?php

namespace App\Http\Controllers\Api\V1\Barber;

use App\Models\LoyalClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Api\Barber\LoyalClientListResource;

class LoyalClientController extends Controller
{
    //
    public function getBarberAllLoyalClientList()
    {
            try {
              $query = LoyalClient::with('user_detail')->where('barber_id',Auth::user()->id);
              $total = $query->count();
              $data = $query->paginate(10);

              if (!empty($data)) {
                $result = LoyalClientListResource::collection($data);
                return response()->json([
                    'data' => $result,
                    'total' => $total,
                    'status' => 1,
                    'message' => __('message.Get barber loyal client list successfully.'),
                ], 200);
            }
            } catch (Exception $ex) {
                return response()->json(
                    ['success' => false, 'message' => $ex->getMessage()]
                );
            }
    }



    public function barberSendNotificationToLoyalClient(Request $request)
    {

        $validated = $request->validate([
            'message' => 'required',
        ], [
            'message.required' => __('error.The message field is required.'),
        ]);

            try {


                $data = LoyalClient::where('barber_id',Auth::user()->id)->get();




                dd($request->all());



            } catch (Exception $ex) {
                return response()->json(
                    ['success' => false, 'message' => $ex->getMessage()]
                );
            }
    }




}
