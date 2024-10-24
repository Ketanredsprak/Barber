<style>
    .friend-drawer.active {
        background-color: #ffd086;
        /* Dark blue background color */
        color: white;
        /* White text color */
        border-radius: 5px;
    }
</style>
@if (count($data) > 0)
    @foreach ($data as $chat)
        @php
            if (empty($chat->barber_detail->profile_image)) {
                $profile_image = 'default.png';
            } else {
                $profile_image = $chat->barber_detail->profile_image;
            }

            $message = $chat->last_message->message ?? '';
            $firstWord = strtok($message, ' ');
            $displayText = !empty($firstWord) ? $firstWord : __('labels.Chat');
        @endphp

        <div class="friend-drawer friend-drawer--onhover" data-id="{{ $chat->chat_unique_key }}">
            <img class="profile-image" src="{{ static_asset('profile_image/' . $profile_image) }}" alt="">
            <div class="text">
                <h6>{{ $chat->barber_detail->first_name }} {{ $chat->barber_detail->last_name }}</h6>
                @php
                    $words = explode(' ', $displayText);
                    $firstTwoWords = implode(' ', array_slice($words, 0, 2)) . '...';
                @endphp
                <p class="text-muted">{{ $firstTwoWords }}</p>
                {{-- <p class="text-muted">{{ $displayText }}</p> --}}
            </div>
            <span class="time text-muted small">
                @if ($chat->last_message != '')
                    {{ $chat->last_message->created_at->format('H:i') }}
                @endif
            </span>
        </div>
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

<!-- Custom Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">{{ __('labels.Confirmation') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="confirmationMessage">
                <!-- Message will be dynamically inserted here -->
                {{-- {{ __('message.Are you sure you want to logout from website?') }} --}}
                {{ __('message.Are you sure to logout?') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('labels.No') }}</button>
                <button type="button" class="btn btn-primary" id="confirmYesButton">{{ __('labels.Yes') }}</button>
            </div>
        </div>
    </div>
</div>
<!-- Custom Confirmation Modal -->


<script>
    $(document).ready(function() {
        $('.friend-drawer').on('click', function() {
            var key = $(this).data('id');

            // Remove the active class from all friend-drawer elements
            $('.friend-drawer').removeClass('active');

            // Add the active class to the clicked friend-drawer
            $(this).addClass('active');

            // Construct the URL for the AJAX request
            var url = "{{ route('get-chat', ['id' => '__ID__']) }}".replace('__ID__', key);

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
        });
    });

    function showConfirmationModal(logoutUrl) {
        // Show the modal
        $('#confirmationModal').modal('show');

        // Set up the "Yes" button to trigger the logout
        $('#confirmYesButton').off('click').on('click', function() {
            // Submit the logout form
            $('#logout-form').attr('action', logoutUrl).submit();
        });
    }
</script>
