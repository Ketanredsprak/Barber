<?php

namespace App\Http\Controllers\Api\V1\Barber;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Barber\LoyalClientListResource;
use App\Models\LoyalClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoyalClientController extends Controller
{
    //
    public function getBarberAllLoyalClientList()
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
            $query = LoyalClient::with('user_detail')->where('barber_id', Auth::user()->id);
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
            'title' => 'required',
            'message' => 'required',
        ], [
            'title.required' => __('error.The title is required.'),
            'message.required' => __('error.The message field is required.'),
        ]);

        try {

            $data = LoyalClient::with('user_detail')->where('barber_id', Auth::user()->id)->get();
            foreach ($data as $user) {
                sendPushNotification($user->user_detail->id, "barber_send_notification_to_loyal_client", $request->title, $request->message);
            }

            if (!empty($data)) {
                return response()->json([
                    'status' => 1,
                    'message' => __('message.Notification send successfully.'),
                ], 200);
            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }

}
