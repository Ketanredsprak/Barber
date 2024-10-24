<div class="modal-dialog modal-xl" role="document">

    <?php  $permission_group = getPermission(); ?>

    <div class="modal-content">

        <div class="modal-header">

            <h5 class="modal-title" id="exampleModalLabel1">{{ __('labels.Add Role') }}</h5>

            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>

        </div>

        <div class="modal-body" id="myModal">

            <form class="form-bookmark" method="post" action="{{ route('role.store') }}" id="role-frm">

                @csrf

                <div class="row g-2">



                    <div class="mb-3 col-md-12">

                        <label class="form-label" for="name">{{ __('labels.Name') }}<span class="text-danger">*</span> </label>

                        <input class="form-control" id="name" name="name" type="text"

                            placeholder="{{ __('labels.Name') }}" aria-label="{{ __('labels.Name') }}">

                        <div id="name_error" style="display: none;" class="text-danger"></div>

                    </div>



                    <div class="mb-3 col-md-12">

                        <div class="col-12">

                            <label for="nameInput" class="form-label">{{ __('labels.Module') }} </label>

                            <br>

                            <input type="checkbox" name="selectall" id="selectall"> {{ __('labels.Select All') }}

                            {{-- <label for="nameInput" class="form-label">{{ __('labels.Select All') }}</label> --}}

                        </div>

                        @foreach ($permission_group as $permission)

                        <hr>

                            <div class="col-12 mb-3">

                                 <div class="card-header">

                                        <h4 class="card-title mb-3">{{ $permission[0]['module_name'] }}</h4>

                                          <div class="row icon-demo-content mb-3">

                                            @foreach ($permission as $p)

                                                <div class="col-sm-3">

                                                    <input type="checkbox" class="checkBoxClass" name="permission[]"

                                                        value="{{ $p->name }}">

                                                    {{ $p->name }}

                                                </div>

                                            @endforeach

                                        </div>

                                 </div>

                            </div>

                        <hr>

                        @endforeach

                    </div>

                </div>

                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="countrySubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> {{ __('labels.Submit') }}</button>

                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"

                    id="is_close">{{ __('labels.Close') }}</button>

            </form>

        </div>

    </div>

</div>





