<div class="modal-dialog modal-fullscreen" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1"> {{ __('labels.Add Cms Page') }}</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form class="form-bookmark" method="post" action="{{ route('cms.store') }}" id="cms-frm">
                @csrf

                <div class="row g-2">

                    <div class="col-md-12">
                        <label class="col-form-label">
                            <span class="required"> {{ __('labels.Slug') }} <span class="text-danger">*</span></span>
                        </label>
                            <input type="text" name="slug" id="slug" class="form-control" placeholder="{{ __('labels.Enter slug') }}" @error('slug') is-invalid @enderror>
                    </div>


                    <div class="col-md-12">
                        <label class="col-form-label">
                            <span class="required">{{ __('labels.English Title') }}  <span class="text-danger">*</span></span>
                        </label>
                            <input type="text" name="title_en" id="key" class="form-control" placeholder="{{ __('labels.Enter title') }}" @error('key') is-invalid @enderror>
                    </div>
                    <div class="col-md-12">
                            <label class="col-form-label ">
                                <span class="required">{{ __('labels.English Content') }} <span class="text-danger">*</span></span>
                            </label>
                            <textarea  class="form-control  ckeditor" id="content"
                                name="content_en"></textarea>
                    </div>


                    <div class="col-md-12">
                        <label class="col-form-label">
                            <span class="required">{{ __('labels.Arabic Title') }} <span class="text-danger">*</span></span>
                        </label>
                            <input type="text" name="title_ar" id="key" class="form-control" placeholder="{{ __('labels.Enter title') }}" @error('key') is-invalid @enderror>
                    </div>
                    <div class="col-md-12">
                            <label class="col-form-label ">
                                <span class="required">{{ __('labels.Arabic Content') }}  <span class="text-danger">*</span></span>
                            </label>
                            <textarea  class="form-control  ckeditor" id="content"
                                name="content_ar"></textarea>
                    </div>


                    <div class="col-md-12">
                        <label class="col-form-label">
                            <span class="required">{{ __('labels.Urdu Title') }} <span class="text-danger">*</span></span>
                        </label>
                            <input type="text" name="title_ur" id="key" class="form-control" placeholder="{{ __('labels.Enter title') }}" @error('key') is-invalid @enderror>
                    </div>
                    <div class="col-md-12">
                            <label class="col-form-label ">
                                <span class="required">{{ __('labels.Urdu Content') }} <span class="text-danger">*</span></span>
                            </label>
                            <textarea  class="form-control  ckeditor" id="content"
                                name="content_ur"></textarea>
                    </div>



                    <div class="col-md-12">
                        <label class="col-form-label">
                            <span class="required">{{ __('labels.Turkish Title') }} <span class="text-danger">*</span></span>
                        </label>
                            <input type="text" name="title_tr" id="key" class="form-control" placeholder="{{ __('labels.Enter title') }}" @error('key') is-invalid @enderror>
                    </div>
                    <div class="col-md-12">
                            <label class="col-form-label ">
                                <span class="required">{{ __('labels.Turkish Content') }} <span class="text-danger">*</span></span>
                            </label>
                            <textarea  class="form-control  ckeditor" id="content"
                                name="content_tr"></textarea>
                    </div>
                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="cmsSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i>{{ __('labels.Submit') }}  </button>
                {{-- <a class="btn btn-sm" id="is_close" href="{{ route('page.index') }}">{{ __('labels.Close') }}</a> --}}
                <a href="{{ route('page.index') }}" class="btn btn-light">{{ __('labels.Close') }}</a>
            </form>
        </div>
    </div>
</div>
