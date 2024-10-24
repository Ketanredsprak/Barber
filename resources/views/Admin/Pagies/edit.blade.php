@extends('Admin.layouts.app')

@section('content')

    <?php

    $url = URL::to('admin/page');

    ?>



    <div class="container-fluid">

        <div class="page-title">

        </div>

    </div>

    <!-- Container-fluid starts-->

    <div class="container-fluid">

        <div class="row">

            <div class="col-xl-12">

                <div class="card height-equal">

                    <div class="card-header">

                        <h4>{{ __('labels.Update Page Content') }}</h4>

                    </div>

                    <div class="card-body custom-input">

                        <form class="form-bookmark" method="post" action="{{ route('page.update', $data->id) }}"

                            id="page-edit-frm">

                            @csrf

                            @method('put')





                            <div class="">

                                <h4>{{ __('labels.Page Detail') }}</h4>

                                <hr>

                            </div>

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

                                        placeholder="{{ __('labels.Enter Page Name') }} "

                                        @error('key') is-invalid @enderror value="{{ $data->page_name_tr }}">

                                </div>





                            </div>

                            <hr>





                            <div class="">

                                <h4>{{ __('labels.Page Meta Detail') }}</h4>

                                <hr>

                            </div>



                            <div class="row g-2">



                                <div class="col-md-6">

                                    <label class="col-form-label">

                                        <span class="required">{{ __('labels.English Meta Title') }} <span

                                                class="text-danger">*</span></span>

                                    </label>

                                    <input type="text" name="meta_title_en" id="key" class="form-control"

                                        placeholder="{{ __('labels.Enter Page Name') }} "

                                        @error('key') is-invalid @enderror

                                        value="{{ $data->meta_content->meta_title_en }}">

                                </div>





                                <div class="col-md-6">

                                    <label class="col-form-label">

                                        <span class="required">{{ __('labels.Arabic Meta Title') }} <span

                                                class="text-danger">*</span></span>

                                    </label>

                                    <input type="text" name="meta_title_ar" id="key" class="form-control"

                                        placeholder="{{ __('labels.Enter Page Name') }} "

                                        @error('key') is-invalid @enderror

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

                                        placeholder="{{ __('labels.Enter Page Name') }} "

                                        @error('key') is-invalid @enderror

                                        value="{{ $data->meta_content->meta_title_ur }}">

                                </div>





                                <div class="col-md-6">

                                    <label class="col-form-label">

                                        <span class="required">{{ __('labels.Turkish Meta Title') }} <span

                                                class="text-danger">*</span></span>

                                    </label>

                                    <input type="text" name="meta_title_tr" id="key" class="form-control"

                                        placeholder="{{ __('labels.Enter Page Name') }} "

                                        @error('key') is-invalid @enderror

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



                            </div><br>





                            <div class="">

                                <h4>{{ __('labels.Page Section Detail') }}</h4>

                            </div><br>



                            @foreach ($data->cms_content as $key => $cms)

                                <input type="hidden" name="record_ids[]" id="key" class="form-control"

                                    @error('key') is-invalid @enderror value="{{ $cms->id }}">





                                <h4>{{ __('labels.' . $cms->slug . '') }}</h4>

                                <hr>



                                <div class="row g-2">





                                    <div class="col-sm-10 @if(empty($cms->cms_image)) d-none  @endif" >

                                        <label class="form-label"

                                            for="cms_image">{{ __('labels.Cms Image') }}</label>

                                        <input class="form-control" id="cms_image" type="file" name="cms_image[{{ $cms->id }}]"

                                            accept=".png, .jpg, .jpeg">

                                        <div id="cms_image_error" style="display: none;" class="text-danger"></div>

                                    </div>

                                    <div class="col-sm-2 @if(empty($cms->cms_image)) d-none  @endif">

                                        <label class="form-label" for="cms_image"></label><br>

                                        <img src="@if (!empty($cms->cms_image)) {{ static_asset('cms_image/' . $cms->cms_image) }} @endif"

                                            class="" style="height:28px">

                                    </div>



                                    <div class="col-md-6">

                                        <label class="col-form-label">

                                            <span class="required">{{ __('labels.English Title') }} <span

                                                    class="text-danger">*</span></span>

                                        </label>

                                        <input type="text" name="title_en[]" id="key" class="form-control"

                                            placeholder="{{ __('labels.Enter English Title') }} "

                                            @error('key') is-invalid @enderror value="{{ $cms->title_en }}">

                                    </div>





                                    <div class="col-md-6">

                                        <label class="col-form-label">

                                            <span class="required">{{ __('labels.Arabic Title') }} <span

                                                    class="text-danger">*</span></span>

                                        </label>

                                        <input type="text" name="title_ar[]" id="key" class="form-control"

                                            placeholder="{{ __('labels.Enter Arabic Title') }} "

                                            @error('key') is-invalid @enderror value="{{ $cms->title_ar }}">

                                    </div>



                                    <div class="col-md-6 @if(empty($cms->sub_title_en)) d-none  @endif">

                                        <label class="col-form-label">

                                            <span class="required">{{ __('labels.English Sub Title') }} <span

                                                    class="text-danger">*</span></span>

                                        </label>

                                        <input type="text" name="sub_title_en[]" id="key" class="form-control"

                                            placeholder="{{ __('labels.Enter English Sub Title') }} "

                                            @error('key') is-invalid @enderror value="{{ $cms->sub_title_en }}">

                                    </div>





                                    <div class="col-md-6 @if(empty($cms->sub_title_ar)) d-none  @endif">

                                        <label class="col-form-label">

                                            <span class="required">{{ __('labels.Arabic Sub Title') }} <span

                                                    class="text-danger">*</span></span>

                                        </label>

                                        <input type="text" name="sub_title_ar[]" id="key" class="form-control"

                                            placeholder="{{ __('labels.Enter Arabic Sub Title') }} "

                                            @error('key') is-invalid @enderror value="{{ $cms->sub_title_ar }}">

                                    </div>





                                    <div class="col-md-6 @if(empty($cms->content_en)) d-none  @endif">

                                        <label class="col-form-label ">

                                            <span class="required">{{ __('labels.English Content') }} <span

                                                    class="text-danger">*</span></span>

                                        </label>

                                        <textarea class="form-control" rows="5" id="content" name="content_en[]">{{ $cms->content_en }}</textarea>

                                    </div>



                                    <div class="col-md-6 @if(empty($cms->content_ar)) d-none  @endif">

                                        <label class="col-form-label ">

                                            <span class="required">{{ __('labels.Arabic Content') }} <span

                                                    class="text-danger">*</span></span>

                                        </label>

                                        <textarea class="form-control" rows="5" id="content" name="content_ar[]">{{ $cms->content_ar }}</textarea>

                                    </div>





                                    <div class="col-md-6">

                                        <label class="col-form-label">

                                            <span class="required">{{ __('labels.Urdu Title') }} <span

                                                    class="text-danger">*</span></span>

                                        </label>

                                        <input type="text" name="title_ur[]" id="key" class="form-control"

                                            placeholder="{{ __('labels.Enter Urdu Title') }} "

                                            @error('key') is-invalid @enderror value="{{ $cms->title_ur }}">

                                    </div>





                                    <div class="col-md-6">

                                        <label class="col-form-label">

                                            <span class="required">{{ __('labels.Turkish Title') }} <span

                                                    class="text-danger">*</span></span>

                                        </label>

                                        <input type="text" name="title_tr[]" id="key" class="form-control"

                                            placeholder="{{ __('labels.Enter Turkish Title') }} "

                                            @error('key') is-invalid @enderror value="{{ $cms->title_tr }}">

                                    </div>





                                    <div class="col-md-6  @if(empty($cms->sub_title_ur)) d-none  @endif">

                                        <label class="col-form-label">

                                            <span class="required">{{ __('labels.Urdu Sub Title') }} <span

                                                    class="text-danger">*</span></span>

                                        </label>

                                        <input type="text" name="sub_title_ur[]" id="key" class="form-control"

                                            placeholder="{{ __('labels.Enter Urdu Sub Title') }} "

                                            @error('key') is-invalid @enderror value="{{ $cms->sub_title_ur }}">

                                    </div>





                                    <div class="col-md-6  @if(empty($cms->sub_title_tr)) d-none  @endif">

                                        <label class="col-form-label">

                                            <span class="required">{{ __('labels.Turkish Sub Title') }} <span

                                                    class="text-danger">*</span></span>

                                        </label>

                                        <input type="text" name="sub_title_tr[]" id="key" class="form-control"

                                            placeholder="{{ __('labels.Enter Turkish Sub Title') }} "

                                            @error('key') is-invalid @enderror value="{{ $cms->sub_title_tr }}">

                                    </div>





                                    <div class="col-md-6 @if(empty($cms->content_tr)) d-none  @endif">

                                        <label class="col-form-label ">

                                            <span class="required">{{ __('labels.Urdu Content') }} <span

                                                    class="text-danger">*</span></span>

                                        </label>

                                        <textarea class="form-control" rows="5" id="content" name="content_ur[]">{{ $cms->content_ur }}</textarea>

                                    </div>



                                    <div class="col-md-6 @if(empty($cms->content_tr)) d-none  @endif">

                                        <label class="col-form-label ">

                                            <span class="required">{{ __('labels.Turkish Content') }} <span

                                                    class="text-danger">*</span></span>

                                        </label>

                                        <textarea class="form-control" rows="5" id="content" name="content_tr[]">{{ $cms->content_tr }}</textarea>

                                    </div>





                                </div>

                            @endforeach

                            <button class="btn btn-primary btn-sm btn-custom mt-4" type="submit" id="pageSubmit"><i

                                    class="fa fa-spinner fa-spin d-none icon"></i> {{ __('labels.Submit') }}</button>

                                    <a href="{{ route('page.index') }}" class="btn btn-light mt-4">{{ __('labels.Close') }}</a>

                        </form>

                    </div>

                </div>

            </div>



        </div>

    </div>

@endsection





@section('script')

    <script type="text/javascript">

        ///edit cms

        $(document).on('submit', '#page-edit-frm', function(e) {

            e.preventDefault();

            var frm = this;

            var btn = $('#pageSubmit');

            var url = $(this).attr('action');

            var formData = new FormData(frm);



            //for button  to set  progress

            jQuery('.btn-custom').addClass('disabled');

            jQuery('.icon').removeClass('d-none');





            formData.append("_method", 'PATCH');



            $.ajax({

                url: url,

                type: "POST",

                data: formData,

                contentType: false,

                cache: false,

                processData: false,

                success: function(response) {

                    show_toster(response.success)

                    frm.reset();

                    // location.reload();



                    var content = "{{ $url }}";



                    window.setTimeout(function() {

                        window.location.href = content;

                    }, 300);



                    jQuery('.btn-custom').removeClass('disabled');

                    jQuery('.icon').addClass('d-none');





                },

                error: function(xhr) {

                    // $('#send').button('reset');

                    var errors = xhr.responseJSON;

                    $.each(errors.errors, function(key, value) {

                        var ele = "#" + key;

                        toastr.error(value);



                    });



                    jQuery('.btn-custom').removeClass('disabled');

                    jQuery('.icon').addClass('d-none');



                },

            });



        });

        //edit cms end

    </script>

@endsection

