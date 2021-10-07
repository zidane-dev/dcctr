<!-- Suppression -->
<div class="modal" id="modalRhsdSUP">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">@lang('rhsd.modal supprimer')</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="axe/rhs/destroy" method="post">
                @method('DELETE')
                @csrf
                <div class="modal-body">
                    <p>@lang('rhsd.modal validation supprision')</p><br>
                    <input type="hidden" name="rhsd_id" id="rhsd_id" value="">

                    <div style="text-align: center;">
                        <img width="50%" height="200px" src="{{asset('/img/ressource_humaine.svg')}}">

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('rhsd.modal_validation_close')</button>
                    <button type="submit" class="btn btn-danger">@lang('rhsd.modal_validation_confirm')</button>
                </div>

            </form>
        </div>
    </div>
</div>

<!--suppression -->
    @section('modal_suppr')
        <script>
            $('#modalRhsdSUP').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')
                var modal = $(this)
                modal.find('.modal-body #rhsd_id').val(id);
            })
        </script>
    @endsection