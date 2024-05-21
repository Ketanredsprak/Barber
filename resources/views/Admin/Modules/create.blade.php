<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">{{ __('labels.Add Module') }}</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('module.store') }}" id="module-frm">
                @csrf
                <div class="row g-2">

                    <div class="mb-3 col-md-12">
                        <label class="form-label" for="name">{{ __('labels.Name') }}<span class="text-danger">*</span> </label>
                        <input class="form-control" id="name" name="name" type="text"
                            placeholder="{{ __('labels.Name') }}" aria-label="{{ __('labels.Name') }}">
                        <div id="name_error" style="display: none;" class="text-danger"></div>
                    </div>

                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="moduleSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> {{ __('labels.Submit') }}</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close">{{ __('labels.Close') }}</button>
            </form>
        </div>
    </div>
</div>
