@extends('layouts.master')
@section('title') @lang('sidebar.liste type_credit')  @endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">
                    @lang('sidebar.type_credits')
                </h4>
                <span class="text-muted mt-1 tx-14 mr-2 mb-0">
                    /  @lang('sidebar.liste type_credit')
                </span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- row -->
    <div class="row row-sm">

        <div class="col-xl-12">
            <div class="card mg-b-20">
                @include('layouts.errors_success')
                <div class="card-header pb-0">
                    <a href="{{route('typecredits.create')}}" class="btn btn-primary" style="color: whitesmoke">
                        <i class="fas fa-plus"></i> @lang('type_credit.add') 
                    </a>
                </div>
                @if($type_credits->count() > 0)
                    <div class="card-body">
                        <!-- Table -->
                        <div class="table-responsive">
                            <table id="example1" class="table key-buttons text-md-nowrap">
                                <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">@lang('type_credit.nom_type_credit')</th>
                                    <th class="border-bottom-0">@lang('formone.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 0 ?>
                                @forelse($type_credits as $type_credit)
                                    <tr>
                                        <td>{{$type_credit->id}}</td>
                                        <td>{{$type_credit->type_credit}}</td>
                                        <td>
                                            <a class="btn btn-sm btn-info"  href="{{route('typecredits.edit',$type_credit->id)}}" title="@lang('type_credit.title edit')"><i class="las la-pen"></i></a>
                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-id="{{ $type_credit->id }}"
                                            data-type_credit_name="{{ $type_credit->type_credit }}" data-toggle="modal" href="#supprimer_type_credit" title="@lang('type_credit.title supprimer')">
                                                <i class="las la-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>                          
                @else
                    <div>
                        <img width="100%" height="300px" src="{{asset('assets/img/svgicons/no-data.svg')}}">
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal" id="supprimer_type_credit">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">@lang('type_credit.modal supprimer')</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="typecredits/destroy" method="post">
                    @method('DELETE')
                    @csrf
                    <div class="modal-body">
                        <p>@lang('formone.modal validation supprision')</p><br>
                        <input type="hidden" name="id" id="id" value="">
                        <input class="form-control" name="type_credit_name" id="type_credit_name" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('formone.modal validation close')</button>
                        <button type="submit" class="btn btn-danger">@lang('formone.modal validation confirm')</button>
                    </div>

                </form>
            </div>
        </div>

@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>

    <script>
        $('#supprimer_type_credit').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var type_credit_name = button.data('type_credit_name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #type_credit_name').val(type_credit_name);
        })
    </script>
@endsection