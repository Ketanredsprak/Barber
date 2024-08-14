<div class="modal-dialog modal-lg" role="document">
    <?php
    $locale = Illuminate\Support\Facades\App::getLocale();
    $name = "name_".$locale;
    ?>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">{{ __('labels.Edit Subject') }}</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('subject.update', $data->id) }}" id="subject-edit-form">
                @csrf
                <div class="row g-2">

                  




                    <div class="col-md-6">
                        <label class="form-label" for="name_en">{{ __('labels.Subject Name English') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="name_en" name="name_en" type="text"
                            placeholder="{{ __('labels.Subject Name English') }}" aria-label="{{ __('labels.Subject Name English') }}" value="{{ $data->name_en}}">
                        <div id="name_en_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="name_ar">{{ __('labels.Subject Name Arabic') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="name_ar" name="name_ar" type="text"
                            placeholder="{{ __('labels.Subject Name Arabic') }}" aria-label="{{ __('labels.Subject Name Arabic') }}" value="{{ $data->name_ar}}">
                        <div id="name_ar_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="name_ur">{{ __('labels.Subject Name Urdu') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="name_ur" name="name_ur" type="text"
                            placeholder="{{ __('labels.Subject Name Urdu') }}" aria-label="{{ __('labels.Subject Name Urdu') }}" value="{{ $data->name_ur}}">
                        <div id="name_ur_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="name_tr">{{ __('labels.Subject Name Turkish') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="name_tr" name="name_tr" type="text"
                            placeholder="{{ __('labels.Subject Name Turkish') }}" aria-label="{{ __('labels.Subject Name Turkish') }}" value="{{ $data->name_tr}}">
                        <div id="name_tr_error" style="display: none;" class="text-danger"></div>
                    </div>


              

                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="subjectSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> {{ __('labels.Submit') }}</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close">{{ __('labels.Close') }}</button>
            </form>
        </div>
    </div>
</div>



