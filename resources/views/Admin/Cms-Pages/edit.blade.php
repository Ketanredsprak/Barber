{{-- <div class="modal-dialog modal-lg" role="document"> --}}
<div class="modal-dialog modal-fullscreen" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">{{ __('labels.Update Cms Page') }}</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form class="form-bookmark" method="post" action="{{ route('cms.update', $data->id) }}" id="cms-edit-frm">
                @csrf
                @method('put')


                <div class="row g-2">

                    <div class="col-md-6">
                        <label class="col-form-label">
                            <span class="required">{{ __('labels.English Title') }} <span
                                    class="text-danger">*</span></span>
                        </label>
                        <input type="text" name="title_en" id="key" class="form-control"
                            placeholder="{{ __('labels.Enter title') }} " @error('key') is-invalid @enderror
                            value="{{ $data->title_en }}">
                    </div>

                    <div class="col-md-6">
                        <label class="col-form-label">
                            <span class="required">{{ __('labels.Arabic Title') }} <span
                                    class="text-danger">*</span></span>
                        </label>
                        <input type="text" name="title_ar" id="key" class="form-control"
                            placeholder="{{ __('labels.Enter title') }} " @error('key') is-invalid @enderror
                            value="{{ $data->title_ar }}">
                    </div>

                    <div class="col-md-6">
                        <label class="col-form-label ">
                            <span class="required">{{ __('labels.English Content') }} <span
                                    class="text-danger">*</span></span>
                        </label>
                        <textarea class="form-control  ckeditoredit" id="content" name="content_en">{{ $data->content_en }}</textarea>
                    </div>



                    <div class="col-md-6">
                        <label class="col-form-label ">
                            <span class="required">{{ __('labels.Arabic Content') }} <span
                                    class="text-danger">*</span></span>
                        </label>
                        <textarea class="form-control  ckeditoredit" id="content" name="content_ar">{{ $data->content_ar }}</textarea>
                    </div>


                    <div class="col-md-6">
                        <label class="col-form-label">
                            <span class="required">{{ __('labels.Urdu Title') }} <span
                                    class="text-danger">*</span></span>
                        </label>
                        <input type="text" name="title_ur" id="key" class="form-control"
                            placeholder="{{ __('labels.Enter title') }} " @error('key') is-invalid @enderror
                            value="{{ $data->title_ur }}">
                    </div>


                    <div class="col-md-6">
                        <label class="col-form-label">
                            <span class="required">{{ __('labels.Turkish Title') }} <span
                                    class="text-danger">*</span></span>
                        </label>
                        <input type="text" name="title_tr" id="key" class="form-control"
                            placeholder="{{ __('labels.Enter title') }} " @error('key') is-invalid @enderror
                            value="{{ $data->title_tr }}">
                    </div>

                    <div class="col-md-6">
                        <label class="col-form-label ">
                            <span class="required">{{ __('labels.Urdu Content') }} <span
                                    class="text-danger">*</span></span>
                        </label>
                        <textarea class="form-control  ckeditoredit" id="content" name="content_ur">{{ $data->content_ur }}</textarea>
                    </div>


                    <div class="col-md-6">
                        <label class="col-form-label ">
                            <span class="required">{{ __('labels.Turkish Content') }}<span
                                    class="text-danger">*</span></span>
                        </label>
                        <textarea class="form-control  ckeditoredit" id="content" name="content_tr">{{ $data->content_tr }}</textarea>
                    </div>



                </div>


                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="cmsSubmit"><i
                        class="fa fa-spinner fa-spin d-none icon"></i> {{ __('labels.Submit') }}</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close">{{ __('labels.Close') }}</button>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        CKEDITOR.replaceAll('ckeditoredit_');
    });
</script>
