<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use App\Models\Chats;
use App\Models\ChatList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Api\ChatListResource;
use App\Http\Resources\Api\OneToOneChatResource;

class ChatModuleController extends Controller
{

    public function getMyChatList(Request $request)
    {

        $validated['user_type'] = "required";
        $customMessages = [
            'user_type.required' => __('error.The user type field is required.'),
        ];
        $request->validate($validated, $customMessages);
        try {

            if($request->user_type == "customer") {

                $user_id = "user_id1";
            }else
            {
                $user_id = "user_id2";

            }

            $firstName = "";
            $lastName = "";
            if ($request->search) {
                $names = explode(' ', $request->search);
                $firstName = $names[0] ?? '';
                $lastName = $names[1] ?? '';
            }


            $data = Chats::with('barber_detail', 'customer_detail', 'last_message')
            ->where($user_id, Auth::user()->id)
            ->where(function ($query) use ($firstName, $lastName) {
                $query->whereHas('barber_detail', function ($q) use ($firstName, $lastName) {
                    $q->where(function ($query) use ($firstName, $lastName) {
                        $query->where('first_name', 'like', '%' . $firstName . '%')
                            ->orWhere('last_name', 'like', '%' . $lastName . '%');
                    });
                });
                $query->orWhereHas('customer_detail', function ($q) use ($firstName, $lastName) {
                    $q->where(function ($query) use ($firstName, $lastName) {
                        $query->where('first_name', 'like', '%' . $firstName . '%')
                            ->orWhere('last_name', 'like', '%' . $lastName . '%');
                    });
                });
            })
            ->paginate(10);
            $total = $data->count();

             $result = ChatListResource::collection($data);

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

    public function sendMessage(Request $request)
    {

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


                $chat = New ChatList();
                $chat->sender_id  = Auth::user()->id;
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

                $data = new OneToOneChatResource($chat);

                if($data) {
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

            $validated['chat_unique_key'] = "required";


            $customMessages = [
                'chat_unique_key.required' => __('error.The chat unique key is required.'),
            ];

            $request->validate($validated, $customMessages);


            try {

                $query = ChatList::where('chat_unique_key',$request->chat_unique_key)->orderBy('created_at', 'ASC');
                $total = $query->count();
                $data = $query->paginate(10);

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
