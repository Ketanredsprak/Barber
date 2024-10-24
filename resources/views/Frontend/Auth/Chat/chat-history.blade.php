<style>
    /* Hide scrollbar but allow scrolling */
    .chat-panel {
        max-height: 400px;
        overflow-y: scroll;
        -ms-overflow-style: none;
        /* For Internet Explorer and Edge */
        scrollbar-width: none;
        /* For Firefox */
    }

    .chat-panel::-webkit-scrollbar {
        display: none;
        /* For Chrome, Safari, and Opera */
    }

    .right-chat-wrapper .chat-bubble--right audio {
        width: 100%;
    }

    .chat-bubble--left audio {
        width: 100%;
    }
    .custom-border {
    border: 1px solid #ccc; /* Define the border thickness, style, and color */
    padding: 10px; /* Add padding to make the input look nicer */
    border-radius: 5px;
    border-color: #463a27;/* Optional: Add rounded corners */
}


</style>

<div class="settings-tray">
    <div class="friend-drawer no-gutters friend-drawer--grey">
        @php
            if (empty($sender_detail->barber_detail->profile_image)) {
                $profile_image = 'default.png';
            } else {
                $profile_image = $sender_detail->barber_detail->profile_image;
            }
        @endphp
        <img class="profile-image" src="{{ static_asset('profile_image/' . $profile_image) }}" alt="Friend Profile">
        <div class="text">
            <h6>{{ $sender_detail->barber_detail->first_name }} {{ $sender_detail->barber_detail->last_name }}</h6>
            <p>{{ $sender_detail->barber_detail->gender }}</p>
        </div>
    </div>
</div>

<div class="chat-panel">
    <input type="hidden" value="{{ $sender_detail->chat_unique_key }}" id="chat_unique_key" name="chat_unique_key">
    <input type="hidden" value="{{ $sender_detail->user_id2 }}" id="user_id2" name="user_id2">


    @if (count($data) > 0)
        {{-- @foreach ($data as $chat)
            @php
                // Determine if the current user is the sender
                $isSender = $chat->sender_id == $user_id;
            @endphp

            @if ($isSender)


                    <div class="right-chat-wrapper">
                        <div class="chat-bubble chat-bubble--right">
                           {{ $chat->message }}
                        </div>
                    </div>

            @else

                <div class="row no-gutters">
                    <div class="col-md-4">
                        <div class="chat-bubble chat-bubble--left">
                            {{ $chat->message }}
                        </div>
                    </div>
                </div>

            @endif
        @endforeach --}}

        @foreach ($data as $chat)
            @php
                // Determine if the current user is the sender
                $isSender = $chat->sender_id == $user_id;
            @endphp

            @if ($isSender)
                <div class="right-chat-wrapper">
                    <div class="chat-bubble chat-bubble--right">
                        @if ($chat->message_type == 'text')
                            {{ $chat->message }}
                        @elseif($chat->message_type == 'file')
                            <!-- Display audio player -->
                            <audio controls>
                                <source src="{{ static_asset('file/' . $chat->file) }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        @endif
                    </div>
                </div>
            @else
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <div class="chat-bubble chat-bubble--left">
                            @if ($chat->message_type == 'text')
                                {{ $chat->message }}
                            @elseif($chat->message_type == 'file')
                                <!-- Display audio player -->
                                <audio controls>
                                    <source src="{{ static_asset('file/' . $chat->file) }}" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <div class="white-box">
            <div class="col-sm-12">
                <div class="no-record">
                    <img src="{{ static_asset('frontend/assets/images/no-record.png') }}" class="img-fluid">
                </div>
            </div>
        </div>
    @endif
</div>

<div class="row">
    <div class="col-12">
        <div class="chat-box-tray">
            <input type="text" placeholder="{{ __('labels.send_us_message') }}" name="message" id="message"
       class="input1 ml-0 custom-border">
            {{-- <a href="#"><img src="{{ static_asset('frontend/assets/images/symbols_mic.png') }}"></a> --}}
            <i class="send-btn">
                <a href="#" id="send-message-btn">
                    <img src="{{ static_asset('frontend/assets/images/icon-send.png') }}" alt="Send Icon">
                </a>
            </i>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var chatUniqueKey = $('#chat_unique_key').val();
        // Set interval to reload chat list every 20 seconds if chatUniqueKey is not blank
        // if (chatUniqueKey) {
        //     setInterval(reloadChatList, 20000); // 20000 milliseconds = 20 seconds
        // }

        // Send message on Enter key press
        $('#message').on('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Prevent the default form submission on Enter key press
                sendMessage();
            }
        });

        // Send message on clicking the send button
        $('#send-message-btn').on('click', function(e) {
            e.preventDefault(); // Prevent the default anchor click behavior
            sendMessage();
        });

        function sendMessage() {
            // Get the chat unique key and message
            var chatUniqueKey = $('#chat_unique_key').val();
            var receiver_id = $('#user_id2').val();
            var message = $('#message').val().trim();

            var messageRequired = "{{ __('error.The message field is required.') }}";

            if (message === '') {
                toastr.error(messageRequired); // Show the translated error message
                return;
            }

            // Make AJAX request
            $.ajax({
                url: "{{ route('send.message') }}", // Your route for sending messages
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}", // CSRF token for security
                    sender_id: "{{ $user_id }}",
                    receiver_id: receiver_id,
                    chat_unique_key: chatUniqueKey,
                    message: message
                },
                success: function(response) {
                    $('#message').val("");
                    reloadChatList();
                    $(".chat-panel").animate({
                        scrollTop: 500000
                    }, 800);
                },
            });
        }

        function reloadChatList() {
            var chatUniqueKey = $('#chat_unique_key').val();
            // Construct the URL for the AJAX request
            var url = "{{ route('get-chat', ['id' => '__ID__']) }}".replace('__ID__', chatUniqueKey);

            // Make AJAX request using jQuery
            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    // Append the response data to the chat container
                    $('.chat-container').html(data);
                    $(".chat-panel").animate({
                        scrollTop: 500000
                    }, 800);
                },
            });
        }
    });
</script>
