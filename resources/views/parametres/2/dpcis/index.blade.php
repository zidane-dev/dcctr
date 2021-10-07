@extends('parametres.2.master.index')
@section('title') 
    @lang('sidebar.liste dpci')  
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">
                    @lang('sidebar.dpcis')
                </h4>
                <span class="text-muted mt-1 tx-14 mr-2 mb-0">
                    /  @lang('sidebar.liste dpci')
                </span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection

@section('add_button')
    <a href="{{route('dpcis.create')}}" class="btn btn-primary" style="color: whitesmoke"><i class="fas fa-plus"></i>
        @lang('dpcis.add')
    </a>
@endsection
@section('header_one')
    @lang('dpcis.nom')
@endsection
@section('header_two')
    @lang('dpcis.type')
@endsection
@section('more_headers')
    <th class="border-bottom-0">@lang('dpcis.niveau')</th>
    <th class="border-bottom-0">@lang('regions.nom')</th>
@endsection
@section('table_body')
    @foreach($datas as $data)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$data->name}}</td>
            <td>{{$data->type}}</td>
            <td>{{$data->niveau->name}}</td>
            <td>{{$data->region->name}}</td>
            @include('parametres.2.partials.action')
        </tr>
    @endforeach
@endsection
@section('modal_delete')
    <div class="modal" id="supprimer_data">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">@lang('dpcis.modal supprimer')</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="dpcis/destroy" method="post">
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
    </div>
@endsection