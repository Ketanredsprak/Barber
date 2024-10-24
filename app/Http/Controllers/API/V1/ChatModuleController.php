<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ChatListResource;
use App\Http\Resources\Api\OneToOneChatResource;
use App\Models\ChatList;
use App\Models\Chats;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatModuleController extends Controller
{

    public function getMyChatList(Request $request)
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

        // Validation for user_type

        $validated['user_type'] = "required";

        $customMessages = [

            'user_type.required' => __('error.The user type field is required.'),

        ];

        $request->validate($validated, $customMessages);

        try {

            // Determine the user ID field based on user_type

            $user_id = $request->user_type == "customer" ? "user_id1" : "user_id2";

            $search = $request->search ?? '';

            // Split search input into first and last names if applicable

            $names = explode(' ', $search);

            $firstName = $names[0] ?? '';

            $lastName = $names[1] ?? '';

            // Retrieve the chat data with search filtering

            $data = Chats::with('barber_detail', 'customer_detail', 'last_message')

                ->where($user_id, Auth::user()->id)

                ->where(function ($query) use ($firstName, $lastName) {

                    $query->whereHas('barber_detail', function ($q) use ($firstName, $lastName) {

                        if ($firstName && $lastName) {

                            // Search by both first name and last name

                            $q->where('first_name', 'like', '%' . $firstName . '%')

                                ->where('last_name', 'like', '%' . $lastName . '%');

                        } else {

                            // Search by either first name or last name

                            $q->where(function ($q) use ($firstName, $lastName) {

                                if ($firstName) {

                                    $q->where('first_name', 'like', '%' . $firstName . '%');

                                }

                                if ($lastName) {

                                    $q->Where('last_name', 'like', '%' . $lastName . '%');

                                }

                            });

                        }

                    })

                        ->orWhereHas('customer_detail', function ($q) use ($firstName, $lastName) {

                            if ($firstName && $lastName) {

                                // Search by both first name and last name

                                $q->where('first_name', 'like', '%' . $firstName . '%')

                                    ->where('last_name', 'like', '%' . $lastName . '%');

                            } else {

                                // Search by either first name or last name

                                $q->where(function ($q) use ($firstName, $lastName) {

                                    if ($firstName) {

                                        $q->where('first_name', 'like', '%' . $firstName . '%');

                                    }

                                    if ($lastName) {

                                        $q->Where('last_name', 'like', '%' . $lastName . '%');

                                    }

                                });

                            }

                        });

                })

                ->paginate(10);

            $total = $data->total(); // Use the total records, not the count of the current page

            // Transform the result

            $result = ChatListResource::collection($data);

            if ($result) {

                return response()->json([

                    'data' => $result,

                    'total' => $total,

                    'status' => 1,

                    'message' => __('message.Data get successfully.'),

                ], 200);

            }

        } catch (Exception $ex) {

            return response()->json([

                'success' => 0,

                'message' => $ex->getMessage(),

            ], 401);

        }

    }

    public function sendMessage(Request $request)
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

        $validated['chat_unique_key'] = "required";

        $validated['message_type'] = "required";

        $validated['message'] = "required_if:message_type,text";

        $validated['file'] = "required_if:message_type,file";

        $validated['receiver_id'] = "required";

        $customMessages = [

            'chat_unique_key.required' => __('error.The chat unique key is required.'),

            'message_type.required' => __('error.The message type is required.'),

            'message.required_if' => __('error.The message is required when message type is text.'),

            'file.required_if' => __('error.The file is required when message type is file.'),

            'receiver_id.required' => __('error.The receiver id is required.'),

        ];

        $request->validate($validated, $customMessages);

        try {

            $chat = new ChatList();

            $chat->sender_id = Auth::user()->id;

            $chat->receiver_id = $request->receiver_id;

            $chat->message = $request->message;

            $chat->message_type = $request->message_type;

            $chat->chat_unique_key = $request->chat_unique_key;

            $chat->status = 0;

            // for file

            if ($request->hasFile('file')) {

                $file = $request->file('file');

                $uploaded = time() . '_file.' . $file->getClientOriginalExtension();

                $destinationPath = public_path('/file');

                $file->move($destinationPath, $uploaded);

                $chat->file = $uploaded;

            }

            $chat->save();

            if (Auth::user()->user_type == 3) {
                sendPushNotificationChatNotification($chat->receiver_id, 'message-send-to-reciver-to-customer', 'new-message', 'new-message',$chat);
            }
            if (Auth::user()->user_type == 4) {
                sendPushNotificationChatNotification($chat->receiver_id, 'message-send-to-reciver-to-barber', 'new-message', 'new-message',$chat);
            }

            $data = new OneToOneChatResource($chat);

            if ($data) {

                return response()->json(

                    [

                        'data' => $data,

                        'status' => 1,

                        'message' => __('message.Message send successfully.'),

                    ], 200);

            }

        } catch (Exception $ex) {

            return response()->json(

                ['success' => 0, 'message' => $ex->getMessage()], 401

            );

        }

    }

    public function getOneToOneChat(Request $request)
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

        $validated['chat_unique_key'] = "required";

        $customMessages = [

            'chat_unique_key.required' => __('error.The chat unique key is required.'),

        ];

        $request->validate($validated, $customMessages);

        try {

            $query = ChatList::with('sender_detail', 'receiver_detail')->where('chat_unique_key', $request->chat_unique_key)->orderBy('created_at', 'DESC');

            $total = $query->count();

            $data = $query->paginate(10);

            foreach ($data as $chat) {

                $authid = Auth::user()->id;

                if ($authid == $chat->receiver_id) {

                    $update_chat_flag = ChatList::find($chat->id);

                    $update_chat_flag->status = 1;

                    $update_chat_flag->update();

                }

            }

            $result = OneToOneChatResource::collection($data);

            if ($result) {

                return response()->json(

                    [

                        'data' => $result,

                        'total' => $total,

                        'status' => 1,

                        'message' => __('message.Data get successfully.'),

                    ], 200);

            }

        } catch (Exception $ex) {

            return response()->json(

                ['success' => 0, 'message' => $ex->getMessage()], 401

            );

        }

    }

}
