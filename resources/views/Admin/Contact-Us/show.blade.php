<div class="modal-dialog" role="document">
    <?php
    $countrys = getcountries();
    $locale = Illuminate\Support\Facades\App::getLocale();
    $name = 'name_' . $locale;
    ?>
    {{-- <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">{{ __('labels.Contact Us') }}</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"
                onclick="return close_or_clear();"></button>
        </div>

        <div class="row g-3">

            <div class="col-md-12">
                <label class="form-label" for="name">{{ __('labels.First Name') }} :: {{ $data->first_name }}
                </label>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="name">{{ __('labels.Last Name') }} :: {{ $data->last_name }} </label>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="name">{{ __('labels.Email') }} :: {{ $data->email }} </label>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="name">{{ __('labels.Subject') }} :: {{ $data->subject }} </label>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="name">{{ __('labels.Note') }} :: {{ $data->note }} </label>
            </div>

            <div class="col-md-12">
                <label class="form-label" for="name">{{ __('labels.Created At') }} :: {{ date('Y-M-d h:i A', strtotime($data->created_at)) }} </label>
            </div>

            @if ($data->contact_file)
                <div class="col-md-12">
                    <label class="form-label" for="name">{{ __('labels.Contact File') }} :: <a href="{{ static_asset('contact_file/'.$data->contact_file) }}" download> {{ __('labels.Download') }} </a></label>
                </div>
            @endif





        </div>
    </div> --}}


    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">{{ __('labels.Contact Us') }}</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"
                onclick="return close_or_clear();"></button>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">

                        <div class="card-body">

                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label for="validationCustom01">{{ __('labels.First Name') }} ::
                                        {{ $data->first_name }}</label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label for="validationCustom01">{{ __('labels.Last Name') }} ::
                                        {{ $data->last_name }}</label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label for="validationCustom01">{{ __('labels.Email') }} :: {{ $data->email }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label for="validationCustom01">{{ __('labels.Subject') }} ::

                                        @php

                                            $language = config('app.locale');

                                            $subjectNameField = 'name_' . $language;
                                            echo $subject->$subjectNameField;
                                        @endphp
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label for="validationCustom01">{{ __('labels.Note') }} :: {{ $data->note }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label for="validationCustom01">{{ __('labels.Created At') }} ::
                                        {{ date('Y-M-d h:i A', strtotime($data->created_at)) }} </label>
                                </div>
                            </div>


                            @if ($data->contact_file)
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="name">{{ __('labels.Contact File') }} :: <a
                                                href="{{ static_asset('contact_file/' . $data->contact_file) }}"
                                                download> {{ __('labels.Download') }} </a></label>
                                    </div>
                                </div>
                            @endif


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
