<?php

namespace App\Http\Controllers\Front\Customer;

use App\Http\Controllers\Controller;
use App\Models\ChatList;
use App\Models\Chats;
use App\Models\Pagies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatModuleController extends Controller
{
    //

    public function myChat()
    {
        // dd("hello");
        $data = Pagies::with("meta_content", "cms_content")->find(23);
        $data['subscription_data'] = getSubscription("customer");
        $data['current_subscription'] = getCurrentSubscription(Auth::user()->id);
        return view('Frontend.Auth.Chat.chat-module', compact('data'));
    }

    public function chatList(Request $request)
    {

        $user_id = Auth::user()->id;
        // Start by checking if $request->search is set
        if ($request->search) {
            $searchTerm = '%' . $request->search . '%';

            // Apply the search filter to the query
            $data = Chats::with(['customer_detail', 'barber_detail', 'last_message'])
                ->where("user_id1", $user_id)
                ->whereHas('barber_detail', function ($query) use ($searchTerm) {
                    $query->whereRaw(
                        'CONCAT(first_name, " ", last_name) LIKE ?',
                        [$searchTerm]
                    );
                })
                ->get();
        } else {
            // If no search term is provided, fetch all data
            $data = Chats::with(['customer_detail', 'barber_detail', 'last_message'])
                ->where("user_id1", $user_id)
                ->get();
        }

        // Return the rendered view as a JSON response
        return response()->json(view('Frontend.Auth.Chat.chat-list', compact('data'))->render());

    }

    // ChatController.php
    public function getChat($id)
    {
        $user_id = Auth::id();
        $sender_detail = Chats::with('barber_detail')->where("chat_unique_key", $id)->first();
        $data = ChatList::where('chat_unique_key', $id)->with('sender_detail', 'receiver_detail')->orderBy('id', 'ASC')->get();
        return response()->json(view('Frontend.Auth.Chat.chat-history', compact('data', 'user_id', 'sender_detail'))->render());

    }

    // ChatController.php
    public function sendMessage(Request $request)
    {
        $validated['chat_unique_key'] = "required";
        $validated['message'] = "required_if:message_type,text";
        $validated['file'] = "required_if:message_type,file";
        $validated['receiver_id'] = "required";
        $validated['sender_id'] = "required";

        $customMessages = [
            'chat_unique_key.required' => __('error.The chat unique key is required.'),
            'message.required_if' => __('error.The message is required when message type is text.'),
            'file.required_if' => __('error.The file is required when message type is file.'),
            'receiver_id.required' => __('error.The receiver id is required.'),
            'sender_id.required' => __('error.The sender id is required.'),
        ];
        $request->validate($validated, $customMessages);
        try {

            $chat = new ChatList();
            $chat->sender_id = $request->sender_id;
            $chat->receiver_id = $request->receiver_id;
            $chat->message = $request->message;
            $chat->message_type = "text";
            $chat->chat_unique_key = $request->chat_unique_key;
            $chat->status = 0;
            $chat->save();

            sendPushNotificationChatNotification($chat->receiver_id,'message-send-to-reciver-to-barber','new-message','new-message',$chat->message);


            if ($chat) {
                return response()->json(
                    [
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

}
