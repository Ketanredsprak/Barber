{{-- <div class="modal-dialog modal-lg" role="document"> --}}
<div class="modal-dialog modal-fullscreen" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">{{ __('labels.Update Page') }}</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form class="form-bookmark" method="post" action="{{ route('page.update', $data->id) }}"
                id="page-edit-frm">
                @csrf
                @method('put')


                <div class="row g-2">

                    <div class="col-md-6">
                        <label class="col-form-label">
                            <span class="required">{{ __('labels.English Page Name') }} <span
                                    class="text-danger">*</span></span>
                        </label>
                        <input type="text" name="page_name_en" id="key" class="form-control"
                            placeholder="{{ __('labels.Enter Page Name') }} " @error('key') is-invalid @enderror
                            value="{{ $data->page_name_en }}">
                    </div>

                    <div class="col-md-6">
                        <label class="col-form-label">
                            <span class="required">{{ __('labels.Arabic Page Name') }} <span
                                    class="text-danger">*</span></span>
                        </label>
                        <input type="text" name="page_name_ar" id="key" class="form-control"
                            placeholder="{{ __('labels.Enter Page Name') }} " @error('key') is-invalid @enderror
                            value="{{ $data->page_name_ar }}">
                    </div>

                    <div class="col-md-6">
                        <label class="col-form-label">
                            <span class="required">{{ __('labels.Urdu Page Name') }} <span
                                    class="text-danger">*</span></span>
                        </label>
                        <input type="text" name="page_name_ur" id="key" class="form-control"
                            placeholder="{{ __('labels.Enter Page Name') }} " @error('key') is-invalid @enderror
                            value="{{ $data->page_name_ur }}">
                    </div>

                    <div class="col-md-6">
                        <label class="col-form-label">
                            <span class="required">{{ __('labels.Turkish Page Name') }} <span
                                    class="text-danger">*</span></span>
                        </label>
                        <input type="text" name="page_name_tr" id="key" class="form-control"
                            placeholder="{{ __('labels.Enter Page Name') }} " @error('key') is-invalid @enderror
                            value="{{ $data->page_name_tr }}">
                    </div>


                </div>


                <h3>Page Meta Detail</h3>

                <div class="row g-2">

                    <div class="col-md-6">
                        <label class="col-form-label">
                            <span class="required">{{ __('labels.English Meta Title') }} <span
                                    class="text-danger">*</span></span>
                        </label>
                        <input type="text" name="meta_title_en" id="key" class="form-control"
                            placeholder="{{ __('labels.Enter Page Name') }} " @error('key') is-invalid @enderror
                            value="{{ $data->meta_content->meta_title_en }}">
                    </div>


                    <div class="col-md-6">
                        <label class="col-form-label">
                            <span class="required">{{ __('labels.Arabic Meta Title') }} <span
                                    class="text-danger">*</span></span>
                        </label>
                        <input type="text" name="meta_title_ar" id="key" class="form-control"
                            placeholder="{{ __('labels.Enter Page Name') }} " @error('key') is-invalid @enderror
                            value="{{ $data->meta_content->meta_title_ar }}">
                    </div>


                    <div class="col-md-6">
                        <label class="col-form-label ">
                            <span class="required">{{ __('labels.English Meta Content') }} <span
                                    class="text-danger">*</span></span>
                        </label>
                        <textarea class="form-control" id="content" name="meta_content_en">{{ $data->meta_content->meta_content_en }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="col-form-label ">
                            <span class="required">{{ __('labels.Arabic Meta Content') }} <span
                                    class="text-danger">*</span></span>
                        </label>
                        <textarea class="form-control" id="content" name="meta_content_ar">{{ $data->meta_content->meta_content_ar }}</textarea>
                    </div>


                    <div class="col-md-6">
                        <label class="col-form-label">
                            <span class="required">{{ __('labels.Urdu Meta Title') }} <span
                                    class="text-danger">*</span></span>
                        </label>
                        <input type="text" name="meta_title_ur" id="key" class="form-control"
                            placeholder="{{ __('labels.Enter Page Name') }} " @error('key') is-invalid @enderror
                            value="{{ $data->meta_content->meta_title_ur }}">
                    </div>


                    <div class="col-md-6">
                        <label class="col-form-label">
                            <span class="required">{{ __('labels.Turkish Meta Title') }} <span
                                    class="text-danger">*</span></span>
                        </label>
                        <input type="text" name="meta_title_tr" id="key" class="form-control"
                            placeholder="{{ __('labels.Enter Page Name') }} " @error('key') is-invalid @enderror
                            value="{{ $data->meta_content->meta_title_tr }}">
                    </div>


                    <div class="col-md-6">
                        <label class="col-form-label ">
                            <span class="required">{{ __('labels.Urdu Meta Content') }} <span
                                    class="text-danger">*</span></span>
                        </label>
                        <textarea class="form-control" id="content" name="meta_content_ur">{{ $data->meta_content->meta_content_ur }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="col-form-label ">
                            <span class="required">{{ __('labels.Turkish Meta Content') }} <span
                                    class="text-danger">*</span></span>
                        </label>
                        <textarea class="form-control" id="content" name="meta_content_tr">{{ $data->meta_content->meta_content_tr }}</textarea>
                    </div>

                </div>



                @foreach ($data->cms_content as $key=>$cms)

                <input type="hidden" name="record_ids[]" id="key" class="form-control"
                                @error('key') is-invalid @enderror
                                value="{{ $cms->id }}">

                    <div class="row g-2">
                         <div class="col-md-6">
                            <label class="col-form-label">
                                <span class="required">{{ __('labels.English Title') }} <span
                                        class="text-danger">*</span></span>
                            </label>
                            <input type="text" name="title_en[]" id="key" class="form-control"
                                placeholder="{{ __('labels.EnterEnglish Title') }} " @error('key') is-invalid @enderror
                                value="{{ $cms->title_en }}">
                        </div>


                        <div class="col-md-6">
                            <label class="col-form-label">
                                <span class="required">{{ __('labels.Arabic Title') }} <span
                                        class="text-danger">*</span></span>
                            </label>
                            <input type="text" name="title_ar[]" id="key" class="form-control"
                                placeholder="{{ __('labels.Enter Arabic Title') }} " @error('key') is-invalid @enderror
                                value="{{ $cms->title_ar }}">
                        </div>


                        <div class="col-md-6">
                            <label class="col-form-label ">
                                <span class="required">{{ __('labels.English Content') }} <span
                                        class="text-danger">*</span></span>
                            </label>
                            <textarea class="form-control" rows="5" id="content" name="content_en[]">{{ $cms->content_en }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="col-form-label ">
                                <span class="required">{{ __('labels.Arabic Content') }} <span
                                        class="text-danger">*</span></span>
                            </label>
                            <textarea class="form-control" rows="5" id="content" name="content_ar[]">{{ $cms->content_ar }}</textarea>
                        </div>


                        <div class="col-md-6">
                            <label class="col-form-label">
                                <span class="required">{{ __('labels. Urdu Title') }} <span
                                        class="text-danger">*</span></span>
                            </label>
                            <input type="text" name="title_ur[]" id="key" class="form-control"
                                placeholder="{{ __('labels.Enter Urdu Title') }} " @error('key') is-invalid @enderror
                                value="{{ $cms->title_ur }}">
                        </div>


                        <div class="col-md-6">
                            <label class="col-form-label">
                                <span class="required">{{ __('labels.Turkish Title') }} <span
                                        class="text-danger">*</span></span>
                            </label>
                            <input type="text" name="title_tr[]" id="key" class="form-control"
                                placeholder="{{ __('labels.Enter Turkish Title') }} " @error('key') is-invalid @enderror
                                value="{{ $cms->title_tr }}">
                        </div>


                        <div class="col-md-6">
                            <label class="col-form-label ">
                                <span class="required">{{ __('labels.Urdu Content') }} <span
                                        class="text-danger">*</span></span>
                            </label>
                            <textarea class="form-control" rows="5" id="content" name="content_ur[]">{{ $cms->content_ur }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="col-form-label ">
                                <span class="required">{{ __('labels.Turkish Content') }} <span
                                        class="text-danger">*</span></span>
                            </label>
                            <textarea class="form-control"  rows="5" id="content" name="content_tr[]">{{ $cms->content_tr }}</textarea>
                        </div>




                    </div>

                @endforeach






                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="pageSubmit"><i
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
