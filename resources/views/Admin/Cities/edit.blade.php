<div class="modal-dialog" role="document">
    <?php
            $countrys = getcountries();
            $locale = Illuminate\Support\Facades\App::getLocale();
            $name = "name_".$locale;
     ?>
     <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">{{ __('labels.Edit City') }}</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('city.update', $data->id) }}" id="city-edit-form">
                @csrf
                <div class="row g-2">

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="validationServer01">{{ __('labels.Country Name') }}</label>
                        <select class="form-select country_id_edit" name="country_id" id="validationDefault04">
                            <option value="">{{ __('labels.Select Country') }}</option>
                                 @foreach ($countrys as $country)
                                     <option value="{{ $country->id }}" @if($data->country_id == $country->id) selected @endif>{{ $country->$name }}</option>
                                 @endforeach
                            </select>
                            <div id="country_id_error" style="display:none;" class="text-danger"></div>
                    </div>

                    <div class="mb-3 col-md-6 @if(empty($data->state_id)) d-none @endif" id="states">
                            <div class="form-group" >
                                <label class="form-label" for="validationServer01">{{ __('labels.State Name') }}</label>
                                <select class="form-control editstateData" name="state_id" id="editstateData" id="validationDefault04">
                                    @if($data->state_id)
                                                 <option value="{{ $data->state_id }}" selected >{{ $data_state[$name] }}</option>
                                    @endif
                                </select>
                                <div id="state_id_error" style="display: none;" class="text-danger"></div>
                            </div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="city_name_en">{{ __('labels.City Name English') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="city_name_en" name="city_name_en" type="text"
                            placeholder="{{ __('labels.City Name English') }}" aria-label="{{ __('labels.City Name English') }}" value="{{ $data->name_en }}">
                        <div id="city_name_en_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="city_name_ar">{{ __('labels.City Name Arabic') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="city_name_ar" name="city_name_ar" type="text"
                            placeholder="{{ __('labels.City Name Arabic') }}" aria-label="{{ __('labels.City Name Arabic') }}" value="{{ $data->name_ar }}">
                        <div id="city_name_ar_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="city_name_ur">{{ __('labels.City Name Urdu') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="city_name_ur" name="city_name_ur" type="text"
                            placeholder="{{ __('labels.City Name Urdu') }}" aria-label="{{ __('labels.City Name Urdu') }}" value="{{ $data->name_ur }}">
                        <div id="city_name_ur_error" style="display: none;" class="text-danger"></div>
                    </div>

                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="citySubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> {{ __('labels.Submit') }}</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close">{{ __('labels.Close') }}</button>
            </form>
        </div>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function() {
        $('.country_id_edit').on('change', function() {
                var name = "{{ $name }}";
                var country =this.value ;
                var state_id = $('#state_id').val();
                $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "{{ route('state.list') }}",
                data: {
                    country: country
                },
                success: function(response) {
                    $('#states').removeClass('d-none');
                    $('#editstateData').empty();
                    jQuery.each(response, function(index, item) {
                        $('#editstateData').append(' <option value='+ item['id'] + ' >'+ item[name] +'</option>  ')
                    });
                }
                });
            });
    });
</script>
