<div class="modal-dialog modal-xl" role="document">
    <?php  $permission_group = getPermission(); ?>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Edit Roles</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('role.update', $role->id) }}" id="role-edit-form">
                @csrf
                @method('PATCH')
                <div class="row g-2">

                    <div class="mb-3 col-md-12">
                        <label class="form-label" for="name">Role Name<span class="text-danger">*</span> </label>
                        <input class="form-control" id="name" name="name" type="text"
                            placeholder="Name" aria-label="Name" value="{{ $role->name }}">
                        <div id="name_error" style="display: none;" class="text-danger"></div>
                    </div>

                    <div class="mb-3 col-md-12">
                        <div class="col-12">
                            <label for="nameInput" class="form-label">Module</label>
                            <br>
                            <input type="checkbox" name="selectall" id="selectall">
                            <label for="nameInput" class="form-label">Select All</label>
                        </div>
                        @foreach ($permission_group as $permission)
                            <div class="col-12">
                                <div class="card">

                                    <div class="card-header">
                                        <h4 class="card-title">{{ $permission[0]['module_name'] }}</h4>

                                        <div class="row icon-demo-content">
                                            @foreach ($permission as $p)
                                                <div class="col-sm-3">
                                                    <input type="checkbox" name="permission[]" class="checkBoxClass"
                                                        value="{{ $p->name }}"
                                                        @if ($role->hasPermissionTo($p->name)) checked @endif>
                                                    {{ $p->name }}
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="roleSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Submit</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close">Close</button>
            </form>
        </div>
    </div>
</div>

    <script>
        $(document).ready(function() {
            $("#role-edit-form #selectall").click(function(e) {
                $("#role-edit-form .checkBoxClass").prop('checked', this.checked);
            });
        });
    </script>

