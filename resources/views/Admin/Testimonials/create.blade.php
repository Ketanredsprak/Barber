<div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">

        <div class="modal-header">

            <h5 class="modal-title" id="exampleModalLabel1">{{ __('labels.Add Testimonial') }}</h5>

            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"

                onclick="return close_or_clear();"></button>

        </div>

        <div class="modal-body" id="myModal">

            <form class="form-bookmark" method="post" action="{{ route('testimonial.store') }}" id="testimonial-frm">

                @csrf

                <div class="row g-2">



                    <div class="mb-3 col-md-12">

                        <label class="form-label" for="testimonial_image">{{ __('labels.Image') }}  ({{ __('labels.Accept:png,jpg,jpeg') }}) (80px * 80px)<span class="text-danger">*</span> </label>

                        <input class="form-control" id="testimonial_image" name="testimonial_image" type="file" placeholder="{{ __('labels.Image') }}" accept=".png, .jpg, .jpeg">

                        <div id="testimonial_image_error" style="display: none;" class="text-danger custom-error">

                        </div>

                    </div>



                    <div class="mb-3 col-md-6">

                        <label class="form-label" for="name_en">{{ __('labels.Name English') }} <span class="text-danger">*</span> </label>

                        <input class="form-control" id="name_en" name="name_en" type="text" placeholder="{{ __('labels.Name English') }}">

                        <div id="name_en_error" style="display: none;" class="text-danger custom-error">

                        </div>

                    </div>



                    <div class="mb-3 col-md-6">

                        <label class="form-label" for="designation_en">{{ __('labels.Designation English') }} <span class="text-danger">*</span> </label>

                        <input class="form-control" id="designation_en" name="designation_en" type="text"

                            placeholder="{{ __('labels.Designation English') }}">

                        <div id="designation_en_error" style="display: none;" class="text-danger custom-error"></div>

                    </div>



                    <div class="mb-3 col-md-12">

                        <label class="col-form-label ">

                            <span class="required">{{ __('labels.Testimonial Content English') }}<span class="text-danger">*</span></span>

                        </label>

                        <textarea class="form-control" id="testimonial_content_en" name="testimonial_content_en" rows="5" placeholder="{{ __('labels.Testimonial Content English') }}"></textarea>

                    </div>



                    <div class="mb-3 col-md-6">

                        <label class="form-label" for="name_ar">{{ __('labels.Name Arabic') }} <span class="text-danger">*</span> </label>

                        <input class="form-control" id="name_ar" name="name_ar" type="text" placeholder="{{ __('labels.Name Arabic') }}">

                        <div id="name_ar_error" style="display: none;" class="text-danger custom-error">

                        </div>

                    </div>



                    <div class="mb-3 col-md-6">

                        <label class="form-label" for="designation_ar">{{ __('labels.Designation Arabic') }} <span class="text-danger">*</span> </label>

                        <input class="form-control" id="designation_ar" name="designation_ar" type="text"

                            placeholder="{{ __('labels.Designation Arabic') }}">

                        <div id="designation_ar_error" style="display: none;" class="text-danger custom-error"></div>

                    </div>



                    <div class="mb-3 col-md-12">

                        <label class="col-form-label ">

                            <span class="required">{{ __('labels.Testimonial Content Arabic') }}<span class="text-danger">*</span></span>

                        </label>

                        <textarea class="form-control" id="testimonial_content_ar" name="testimonial_content_ar" rows="5" placeholder="{{ __('labels.Testimonial Content English') }}"></textarea>

                    </div>





                    <div class="mb-3 col-md-6">

                        <label class="form-label" for="name_ur">{{ __('labels.Name Urdu') }} <span class="text-danger">*</span> </label>

                        <input class="form-control" id="name_ur" name="name_ur" type="text" placeholder="{{ __('labels.Name Urdu') }}">

                        <div id="name_ur_error" style="display: none;" class="text-danger custom-error" >

                        </div>

                    </div>



                    <div class="mb-3 col-md-6">

                        <label class="form-label" for="designation_ur">{{ __('labels.Designation Urdu') }} <span class="text-danger">*</span> </label>

                        <input class="form-control" id="designation_ur" name="designation_ur" type="text"

                            placeholder="{{ __('labels.Designation Urdu') }}">

                        <div id="designation_ur_error" style="display: none;" class="text-danger custom-error"></div>

                    </div>



                    <div class="mb-3 col-md-12">

                        <label class="col-form-label ">

                            <span class="required">{{ __('labels.Testimonial Content Urdu') }}<span class="text-danger">*</span></span>

                        </label>

                        <textarea class="form-control" id="testimonial_content_ur" name="testimonial_content_ur" rows="5" placeholder="{{ __('labels.Testimonial Content Urdu') }}"></textarea>

                    </div>



                    <div class="mb-3 col-md-6">

                        <label class="form-label" for="name_tr">{{ __('labels.Name Turkish') }} <span class="text-danger">*</span> </label>

                        <input class="form-control" id="name_tr" name="name_tr" type="text" placeholder="{{ __('labels.Name Turkish') }}">

                        <div id="name_tr_error" style="display: none;" class="text-danger custom-error">

                        </div>

                    </div>



                    <div class="mb-3 col-md-6">

                        <label class="form-label" for="designation_tr">{{ __('labels.Designation Turkish') }} <span class="text-danger">*</span> </label>

                        <input class="form-control" id="designation_tr" name="designation_tr" type="text"

                            placeholder="{{ __('labels.Designation Turkish') }}">

                        <div id="designation_tr_error" style="display: none;" class="text-danger custom-error"></div>

                    </div>



                    <div class="mb-3 col-md-12">

                        <label class="col-form-label ">

                            <span class="required">{{ __('labels.Testimonial Content Turkish') }}<span class="text-danger">*</span></span>

                        </label>

                        <textarea class="form-control" id="testimonial_content_tr" name="testimonial_content_tr" rows="5" placeholder="{{ __('labels.Testimonial Content Turkish') }}"></textarea>

                    </div>





                </div>

                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="testimonialSubmit"><i

                        class="fa fa-spinner fa-spin d-none icon"></i> {{ __('labels.Submit') }}</button>

                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"

                    id="is_close">{{ __('labels.Close') }}</button>

            </form>

        </div>

    </div>

</div>

