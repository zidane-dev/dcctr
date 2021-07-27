<!-- Restoration -->
<div class="modal" id="modalRhRestore">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                {{-- <h6 class="modal-title">@lang('rhsd.modal supprimer')</h6> --}}
                <h6 class="modal-title">Restauration d'une ligne</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>   
            </div>
            <form action="archives/restore/rh" method="POST">
                @csrf
                <div class="modal-body">
                    {{-- <p>@lang('rhsd.modal validation supprision')</p><br> --}}
                    <p>Vous etes sur le point de restaurer une ligne supprimee. Poursuivre l'action ?</p><br>
                    <input type="hidden" name="id" id="id" value="">
                    <input type="hidden" name="table" id="tbl" value="">
                    <div style="text-align: center;">
                        <img width="50%" height="200px" src="{{asset('/img/ressource_humaine.svg')}}">

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('formone.validation_close')</button>
                    <button type="submit" class="btn btn-danger">@lang('formone.validation_confirm')</button>
                </div>

            </form>
        </div>
    </div>
</div>

<!--Restoration -->
<script>
    $('#modalRhRestore').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var table = button.data('tbl')
        console.log(table)
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #tbl').val(table);
    })
</script>