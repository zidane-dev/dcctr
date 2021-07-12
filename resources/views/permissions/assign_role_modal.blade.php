<div class="modal" id="assign_modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">@lang('secteurs.modal supprimer')</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="permissions/update" method="post">
                @csrf
                {{--
                    <p>@lang('secteurs.modal validation supprision')</p><br>
                    <input type="hidden" name="id" id="id" value="">
                    <input class="form-control" name="secteur_name" id="secteur_name" type="text" readonly  >
                --}}
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="">
                    <label for="role_name">@lang('roles.role')</label>
                    <input class="form-control" name="role_name" id="role_name" type="text" readonly>
                    {{var_dump($role->name)}}
{{-- , $role->permissions->pluck('name') --}}
                    @foreach ($permissions->chunk(3) as $permissions)
                            <div class="row m-2" >
                                @foreach ($permissions as $permission)
                                    <div class="col-4 no-wrap">
                                    <input type="checkbox" id="{{$permission->name}}" name="{{$permission->name}}" value="{{$permission->id}}"
                                        @if (in_array($permission->name, $role->permissions->pluck('name')->all()))
                                            checked
                                        @endif
                                    >
                                    <label for="{{$permission->name}}"> {{$permission->name}}</label>
                                    </div>
                                @endforeach
                            </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('secteurs.modal validation close')</button>
                    <button type="submit" class="btn btn-danger">@lang('secteurs.modal validation confirm')</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- @section('role_modal_js')
    <script>
        $('#assign_modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var role_name = button.data('role_name')
            var permissions = button.data('all_permissions')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #role_name').val(role_name);
        })
    </script>
@endsection --}}