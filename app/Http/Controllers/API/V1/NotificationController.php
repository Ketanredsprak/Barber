<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\NotificationResource;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    //

    public function getAllNotification(Request $request)
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


        $language_code = $request->header('language');
        $id = Auth::user()->id;
        $data = Notification::where("user_id", $id)->select('id', 'notification_type','notification_data','notification_message', 'is_read', 'created_at')->orderBy('id', 'Desc');
        $total = $data->count();
        $data = $data->paginate(10);
        $result = NotificationResource::collection($data);

        foreach ($data as $notification) {
            $notification = Notification::find($notification->id);
            $notification->is_read = 1;
            $notification->update();
        }

        if ($result) {
            return response()->json(
                [
                    'data' => $result,
                    'total' => $total,
                    'status' => 1,
                    'message' => __('message.Notification list successfully.'),
                ], 200);
        }

    }

    public function notificationOnOrOff(Request $request)
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

        $language_code = $request->header('language');

        $data = User::find(Auth::user()->id);
        $data->notification_status = $request->notification_status;
        $data->update();
        if ($request->notification_status == 1) {
            return response()->json(
                [
                    'notification_status' => $data->notification_status,
                    'status' => 1,
                    'message' => __('message.Notification off successfully.'),
                ], 200);
        } else {
            return response()->json(
                [
                    'notification_status' => $data->notification_status,
                    'status' => 1,
                    'message' => __('message.Notification on successfully.'),
                ], 200);
        }

    }

}
