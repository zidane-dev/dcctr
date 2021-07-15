@extends('parametres.2.master.index')
@section('title')
     @lang('sidebar.liste attribution')  
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">
                    @lang('sidebar.attributions')
                </h4>
                <span class="text-muted mt-1 tx-14 mr-2 mb-0">
                    /  @lang('sidebar.liste attribution')
                </span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection

@section('add_buton')
    <a href="{{route('attributions.create')}}" class="btn btn-primary" style="color: whitesmoke">
        <i class="fas fa-plus"></i> 
        @lang('attributions.add') 
    </a>
@endsection
@section('header_one')@lang('attributions.nom_attribution')
@endsection
@section('header_two')@lang('attributions.nom_secteur')
@endsection
@section('table_body')
    @foreach($datas as $data)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$data->name}}</td>
            <td>{{$data->secteur->secteur}}</td>
            @include('parametres.2.partials.action')
        </tr>
    @endforeach
@endsection
@section('modal_delete')
    <div class="modal" id="supprimer_data">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">@lang('attributions.modal supprimer')</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="datas/destroy" method="post">
                    @method('DELETE')
                    @csrf
                    <div class="modal-body">
                        <p>@lang('formone.modal validation supprision')</p><br>
                        <input type="hidden" name="id" id="id" value="">
                        <input class="form-control" name="data_name" id="data_name" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('formone.modal validation close')</button>
                        <button type="submit" class="btn btn-danger">@lang('formone.modal validation confirm')</button>
                    </div>

                </form>
            </div>
        </div>
@endsection