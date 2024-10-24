<!-- Slot Selection -->
<style>
    .hidden-checkbox {
        display: none;
    }

    .blocked {
        background-color: #ff8800;
        cursor: not-allowed;
        opacity: 0.5;
    }

    .blocked input {
        pointer-events: none;
    }

    .active {
        background-color: #007bff;
        color: white;
    }
</style>
@if (!empty($timeSlots))
    @php $i = 1; @endphp
    @foreach ($timeSlots as $slot)
        <label class="btn btn-light col-sm-3 @if ($slot['is_available'] == 1) blocked @endif">
            <input type="checkbox"
                class="hidden-checkbox slot-checkbox @if ($slot['is_available'] == 1) not-available @endif"
                name="slots[]" id="slot_number_{{ $i }}" value="{{ $slot['start'] }} - {{ $slot['end'] }}"
                @if ($slot['is_available'] == 1) disabled readonly @endif>
            @php
                $start_time = strtotime($slot['start']);
                $start = date('g:i A', $start_time);

                $end_time = strtotime($slot['end']);
                $end = date('g:i A', $end_time);

                $i++;
            @endphp
            <div>{{ $start }} - {{ $end }} <div class="checked-img d-none"><img src="{{ static_asset('frontend/assets/images/check_mark.webp') }}"
            alt="image" height="20px" width="20px"></div></div>

        </label>
    @endforeach
@else
    <label class="btn btn-light col-sm-12">
        <div>{{ __('labels.Today Barber Not Available for This Date..') }}</div>
    </label>
@endif

<script>
    $(document).ready(function() {
        function getSelectedServiceCount() {
            return $('.service-checkbox:checked').length;
        }

        function clearSlots() {
            $('.slot-checkbox').prop('checked', false).parent().removeClass('active');
            $('.checked-img').addClass('d-none'); // Hide all checkmark images
        }

        $(".slot-checkbox").click(function(e) {
            clearSlots();
            const selectedServiceCount = getSelectedServiceCount();

            if (selectedServiceCount > 0) {
                const startIndex = $(".slot-checkbox").index(this);

                let selectedSlots = 0;
                let validSelection = true;
                let availableSlots = 0;

                // Check for available slots from the start index to the end
                $(".slot-checkbox").each(function(index) {
                    if (index >= startIndex) {
                        if (!$(this).hasClass('not-available')) {
                            availableSlots++;
                        }
                    }
                });

                // If there are not enough available slots
                if (availableSlots < selectedServiceCount) {
                    toastr.error(
                        "{{ __('error.Not enough available slots. Please select another slot.') }}");
                    clearSlots();
                    return false;
                }

                // Proceed with selecting the slots
                $(".slot-checkbox").each(function(index) {
                    if (index >= startIndex && selectedSlots < selectedServiceCount) {
                        if ($(this).hasClass('not-available')) {
                            toastr.error(
                                "{{ __('error.Need to select another slot because the next slot is already booked.') }}"
                            );
                            clearSlots();
                            validSelection = false;
                            return false; // Exit the loop and function
                        }
                        $(this).prop('checked', true).parent().addClass('active');
                        $(this).parent().find('.checked-img').removeClass(
                            'd-none'); // Show checkmark image
                        selectedSlots++;
                    }
                });

                if (!validSelection) {
                    return false; // Prevent further execution if invalid selection was found
                }
            } else {
                toastr.error("{{ __('error.Please select service first.') }}");
            }
        });

        // On change of service checkboxes, clear selected slots
        $('.service-checkbox').change(function() {
            clearSlots();
        });
    });
</script>
