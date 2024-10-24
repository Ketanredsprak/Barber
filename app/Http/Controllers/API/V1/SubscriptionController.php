<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\UserSubscription;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Api\SubscriptionResource;

class SubscriptionController extends Controller
{
    //
    public function getAllSubscriptions(Request $request)
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

        $validated['user_type'] = "required";

        $customMessages = [
            'user_type.required' => __('error.The user type field is required.'),
        ];

        $request->validate($validated, $customMessages);

        try {

            $user = "";
            if (auth('api')->check()) {
                $user = auth('api')->user();
            }
            $current_subscription = "";
            if (!empty($user)) {
                $current_subscription = UserSubscription::where('user_id', $user->id)->where('status', 'active')->first();
                $subscription = Subscription::where('subscription_type', $request->user_type)->where('status', 1)->where('is_delete', 0)->get();
            } else {
                $subscription = Subscription::where('subscription_type', $request->user_type)->where('status', 1)->where('is_delete', 0)->get();
            }

            $data = SubscriptionResource::collection($subscription);

            return response()->json(
                [
                    'data' => $data,
                    'current_subscription' => $current_subscription->subscription_id ?? "",
                    'status' => 1,
                    'message' => __('message.Subscription get successfully.'),
                ], 200);



        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }
    }





    public function updateSubscription($id)
    {

        try {

            $user_subscription = setUserPermissionBaseOnSubscription(Auth::user()->id, $id);
            if($user_subscription == "success")
            {

                return response()->json(
                       [
                           'status' => 1,
                           'message' => __('message.Subscription update successfully'),
                       ], 200);
            }
            else
            {
                return response()->json(
                    [
                        'status' => 0,
                        'message' => __('message.Somthing went wrong'),
                    ], 200);
            }


        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }





}
