<div class="modal-dialog" role="document">
    <div class="modal-content">
        <?php $modules = getmodules(); ?>
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Edit Permisssion</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('permission.update', $data->id) }}" id="permission-edit-form">
                @csrf
                <div class="row g-2">


                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="validationServer01">Module Name</label>
                            <select class="form-select" name="module_name" id="validationDefault04">
                            <option selected="" value="">Select Module</option>
                                @foreach ($modules as $module)
                                    <option value="{{ $module->name }}" @if($module->name == $data->module_name) selected="selected" @endif id=""> {{ $module->name }}</option>
                                @endforeach
                            </select>
                            <div id="module_id_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="name">Name<span class="text-danger">*</span> </label>
                        <input class="form-control" id="name" name="name" type="text"
                            placeholder="Name" aria-label="Name" value="{{ $data->name }}">
                        <div id="name_error" style="display: none;" class="text-danger"></div>
                    </div>

                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="permissionSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Submit</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close">Close</button>
            </form>
        </div>
    </div>
</div>
