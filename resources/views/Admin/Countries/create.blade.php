<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Add Country</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('country.store') }}" id="country-frm">
                @csrf
                <div class="row g-2">

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="country_short_name">Country Short Name <span class="text-danger">*</span> </label>
                        <input class="form-control" id="country_short_name" name="country_short_name" type="text"
                            placeholder="Country Short Name" aria-label="Country Short Name">
                        <div id="country_short_name_error" style="display: none;" class="text-danger custom-error"></div>
                    </div>


                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="country_name_en">Country Name En <span class="text-danger">*</span> </label>
                        <input class="form-control" id="country_name_en" name="country_name_en" type="text"
                            placeholder="Country Name En" aria-label="Country Name En">
                        <div id="country_name_en_error" style="display: none;" class="text-danger custom-error"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="country_name_ar">Country Name ar <span class="text-danger">*</span> </label>
                        <input class="form-control" id="country_name_ar" name="country_name_ar" type="text"
                            placeholder="Country Name ar" aria-label="Country Name ar">
                        <div id="country_name_ar_error" style="display: none;" class="text-danger custom-error"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="country_name_ur">Country Name Ur <span class="text-danger">*</span> </label>
                        <input class="form-control" id="country_name_ur" name="country_name_ur" type="text"
                            placeholder="Country Name ur" aria-label="Country Name ur">
                        <div id="country_name_ur_error" style="display: none;" class="text-danger custom-error"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="country_phone_code">Country Phone Code <span class="text-danger">*</span> </label>
                        <input class="form-control" id="country_phone_code" name="country_phone_code" type="text"
                            placeholder="Country Phone Code" aria-label="Country Phone Code">
                        <div id="country_phone_code_error" style="display: none;" class="text-danger custom-error"></div>
                    </div>

                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="countrySubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Submit</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close">Close</button>
            </form>
        </div>
    </div>
</div>
