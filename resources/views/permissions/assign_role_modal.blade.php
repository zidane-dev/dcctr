<div class="modal" id="assign_modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">@lang('secteurs.modal supprimer')</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <form action="{{route('rights.update')}}" method="POST">
        @csrf
        @method('PUT')
            <div class="modal-body">
                <input type="hidden" name="id" id="id" value="">
                <label for="role_name">@lang('roles.permissions_of_role')</label>
                <input class="form-control" name="role_name" id="role_name" type="text" readonly>
                @foreach ($permissions->chunk(2) as $permissions)
                    <div id="perm_div" class="row m-2" >
                        @foreach ($permissions as $permission)
                            <div class="col-6">
                                <input type="checkbox"  
                                        id="{{$permission->id}}" 
                                        name="permission[]" 
                                        name_perm={{$permission->name}}
                                        value="{{$permission->name}}">
                                <label for="{{$permission->id}}"> {{$permission->name}}</label>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('formone.modal validation close')</button>
                <button type="submit" class="btn btn-danger">@lang('formone.modal validation confirm')</button>
            </div>
        </form>
        </div>
    </div>
</div>