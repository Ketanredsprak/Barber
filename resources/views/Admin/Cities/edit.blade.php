<div class="modal-dialog" role="document">
    <?php $countrys = getcountries(); ?>
     <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Edit City</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('city.update', $data->id) }}" id="city-edit-form">
                @csrf
                <div class="row g-2">

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="validationServer01">Country Name</label>
                        <select class="form-select country_id_edit" name="country_id" id="validationDefault04">
                            <option value="">Select Country</option>
                                 @foreach ($countrys as $country)
                                     <option value="{{ $country->id }}" @if($data->country_id == $country->id) selected @endif>{{ $country->name_en }}</option>
                                 @endforeach
                            </select>
                            <div id="country_id_error" style="display:none;" class="text-danger"></div>
                    </div>

                    <div class="mb-3 col-md-6 @if(empty($data->state_id)) d-none @endif" id="states">
                            <div class="form-group" >
                                <label class="form-label" for="validationServer01">State Name</label>
                                <select class="form-control editstateData" name="state_id" id="editstateData" id="validationDefault04">
                                    @if($data->state_id)
                                                 <option value="{{ $data->state_id }}" selected >{{ $data_state['name_en'] }}</option>
                                    @endif
                                </select>
                                <div id="state_id_error" style="display: none;" class="text-danger"></div>
                            </div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="city_name_en">City Name En <span class="text-danger">*</span> </label>
                        <input class="form-control" id="city_name_en" name="city_name_en" type="text"
                            placeholder="City Name En" aria-label="City Name En" value="{{ $data->name_en }}">
                        <div id="city_name_en_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="city_name_ar">City Name ar <span class="text-danger">*</span> </label>
                        <input class="form-control" id="city_name_ar" name="city_name_ar" type="text"
                            placeholder="City Name ar" aria-label="City Name ar" value="{{ $data->name_ar }}">
                        <div id="city_name_ar_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="city_name_ur">City Name Ur <span class="text-danger">*</span> </label>
                        <input class="form-control" id="city_name_ur" name="city_name_ur" type="text"
                            placeholder="City Name ur" aria-label="City Name ur" value="{{ $data->name_ur }}">
                        <div id="city_name_ur_error" style="display: none;" class="text-danger"></div>
                    </div>

                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="citySubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Submit</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close">Close</button>
            </form>
        </div>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function() {
        $('.country_id_edit').on('change', function() {
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
                        $('#editstateData').append(' <option value='+ item['id'] + ' >'+ item['name_en'] +'</option>  ')
                    });
                }
                });
            });
    });
</script>
