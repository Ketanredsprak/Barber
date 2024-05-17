<div class="modal-dialog" role="document">
    <?php $countrys = getcountries(); ?>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Add Country</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('state.store') }}" id="state-frm">
                @csrf
                <div class="row g-2">

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="validationServer01">Country Name</label>
                            <select class="form-select" name="country_id" id="validationDefault04">
                            <option selected="" value="">Select Country</option>
                                @foreach ($countrys as $country)
                                    <option value="{{ $country->id }}">{{ $country->name_en }}</option>
                                @endforeach
                            </select>
                            <div id="country_id_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="state_name_en">State Name En <span class="text-danger">*</span> </label>
                        <input class="form-control" id="state_name_en" name="state_name_en" type="text"
                            placeholder="State Name En" aria-label="State Name En">
                        <div id="state_name_en_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="state_name_ar">State Name ar <span class="text-danger">*</span> </label>
                        <input class="form-control" id="state_name_ar" name="state_name_ar" type="text"
                            placeholder="State Name ar" aria-label="State Name ar">
                        <div id="state_name_ar_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="state_name_ur">State Name Ur <span class="text-danger">*</span> </label>
                        <input class="form-control" id="state_name_ur" name="state_name_ur" type="text"
                            placeholder="State Name ur" aria-label="State Name ur">
                        <div id="state_name_ur_error" style="display: none;" class="text-danger"></div>
                    </div>

                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="stateSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Submit</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close">Close</button>
            </form>
        </div>
    </div>
</div>
