@extends('layouts.master')
@section('title') @lang('sidebar.liste bdg')   @endsection
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
    <div class="breadcarumb-header justify-content-between">
        <div class="my-auto py-2">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">
                    @can('dc')
                        @lang('sidebar.bdgs') 
                    @else
                        @if(LaravelLocalization::getCurrentLocale() === 'fr')
                            @lang('sidebar.bdgs') / {{Auth::user()->domaine->type}} - {{Auth::user()->domaine->domaine_fr}}
                        @else
                            @lang('sidebar.bdgs') / {{Auth::user()->domaine->type}} - {{Auth::user()->domaine->domaine_ar}}
                        @endif
                    @endcan
                </h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                    &nbsp;&nbsp;&nbsp;&nbsp;/  @lang('sidebar.validation')
                </span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                @include('layouts.errors_success')
                <div class="card-header pb-0">
                    @if($datas->count() > 0)
                        <h3 class="text-center">@lang('axes.nom'): {{$axe->axe}}</h3>
                        <a href="{{route('dashboard.index')}}" class="btn btn-primary" style="color: whitesmoke">
                            <i class="fas fa-arrow-left"></i> @lang('formone.retour') 
                        </a>
                        @can('add-basethree')
                        <a href="{{route('rhs.create')}}" class="btn btn-primary" style="color: whitesmoke">
                            <i class="fas fa-plus"></i> @lang('bdg.add') 
                        </a>
                        @endcan
                        @can('validate')
                        <button type="button" class="btn btn-primary" id="btn_update_state" >
                            @lang('parametre.envoyer')
                        </button>
                        @endcan
                        @can('reject')
                        <button type="button" class="btn btn-primary" id="btn_reject" >
                            @lang('parametre.rejeter')
                        </button>
                        @endcan
                    @else
                        <a href="{{route('dashboard.index')}}" class="btn btn-primary" style="color: whitesmoke">
                            <i class="fas fa-arrow-left"></i> @lang('formone.retour') 
                        </a>
                        @can('add-basethree')
                        <a href="{{route('rhs.create')}}" class="btn btn-primary" style="color: whitesmoke">
                            <i class="fas fa-plus"></i> @lang('bdg.add') 
                        </a>
                        @endcan
                    @endif
                    </div>
                    @if($datas->count() > 0)
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table key-buttons text-md-nowrap">
                                    <thead>
                                        <tr>
                                            <th width="10px"><input type="checkbox" name="select_all" id="example-select-all" onclick="CheckAll('box1',this)" class="text-center align-middle"> </th>
                                            <th width="25px" class="border-bottom-0">#</th>
                                            @canany(['view-region', 'view-select'])
                                                <th class="border-bottom-0">@lang('dpcis.nom')</th>
                                            @endcanany
                                            <th class="border-bottom-0">@lang('bdg.nom_depense')</th>
                                            <th class="border-bottom-0">@lang('parametre.last_modif')</th>
                                            <th class="border-bottom-0">@lang('parametre.annee')</th>
                                            <th class="border-bottom-0">@lang('parametre.nom_objectif')</th>
                                            <th class="border-bottom-0">@lang('parametre.nom_realisation')</th>
                                            <th class="border-bottom-0">@lang('bdg.user')</th>
                                            @canany(['edit-basethree','view-rejets','add-on','follow-info','delete-basethree'])
                                                <th class="border-bottom-0">@lang('parametre.action')</th>
                                            @endcanany
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($datas as $bdg)
                                        <tr @if($bdg->REJET == 1) style="background-color: #f5b4b4 !important;}" @endif>
                                            <td class="text-center align-middle">
                                                @if($bdg->REJET == 0)
                                                    <input type="checkbox" value="{{$bdg->id}}" class="box1">
                                                @endif
                                            </td>
                                            <td>{{$loop->iteration}}</td>
                                            @canany(['view-region', 'view-select'])
                                                <td>{{$bdg->ty}} - {{$bdg->domaine}}</td>
                                            @endcanany
                                            {{-- <td>{{\Carbon\Carbon::parse($bdg->date)->format('d/m/y h:m')}}</td> --}}
                                            {{-- <td>{{\Carbon\Carbon::now()->diffForHumans($bdg->updated_at)}}</td> --}}
                                            <td>{{$bdg->depense}}</td>
                                            <td>
                                                {{\Carbon\Carbon::parse($bdg->date)->format('d/m/y')}} 
                                                @lang('parametre.at') 
                                                {{\Carbon\Carbon::parse($bdg->date)->format('H:i')}} 
                                            </td>
                                            <td>{{$bdg->ANNEE}}</td>
                                            <td>{{$bdg->OBJECTIF}}</td>
                                            <td>{{$bdg->REALISATION}}</td>
                                            <td>{{$bdg->username}}</td>
                                            @canany(['edit-basethree','view-rejets', 'add-on','follow-info','delete-basethree'])
                                                <td class="d-inline-flex text-center align-middle">
                                                    <div class="dropdown">
                                                        <button aria-expanded = "false" 
                                                                aria-haspopup = "true"
                                                                class = "btn ripple btn-primary btn-sm" 
                                                                data-toggle = "dropdown"
                                                                type = "button">
                                                                    @lang('parametre.actions')
                                                                <i class="fas fa-caret-down"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            @can('edit-basethree') 
                                                                <a class="dropdown-item" href="{{route('rhs.edit',$bdg->id)}}">
                                                                    <i class="fas fa-edit" style="color: #239a8a"></i>
                                                                    &nbsp;&nbsp;@lang('parametre.edit')
                                                                </a>
                                                            @endcan
                                                            @can('add-on')
                                                                <a class="dropdown-item" href="{{route('rhs.storereal',$bdg->id)}}">
                                                                    <i class="fas fa-plus-circle"></i>
                                                                    &nbsp;&nbsp;@lang('bdg.ajoutSur')
                                                                </a>
                                                            @endcan
                                                            @can('follow-info')
                                                                <a class="dropdown-item" href="{{route('rhs.show',$bdg->id)}}">
                                                                    <i class="fas fa-info"></i>
                                                                    &nbsp;&nbsp;@lang('parametre.follow_line')
                                                                </a>
                                                            @endcan
                                                            @if ($bdg->REJET == 1)
                                                                @can('view-rejets')
                                                                    <a class="dropdown-item" href="{{--route('rhs.storereal',$bdg->id)--}}">
                                                                        <i class="fas fa-plus-circle"></i>
                                                                        &nbsp;&nbsp;@lang('parametre.view_rejet')
                                                                    </a>
                                                                @endcan
                                                            @endif
                                                            @can('delete-basethree')
                                                                <a class="dropdown-item"  href="javascript:void(0)" data-id="{{ $bdg->id }}"
                                                                data-toggle="modal" data-target="#modalbdgSUP">
                                                                    <i class="text-danger fas fa-trash-alt"></i>
                                                                    &nbsp;&nbsp;@lang('bdg.supprimer')
                                                                </a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </td>
                                            @endcanany
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        @include('partials.emptylist')
                    @endif
            </div>
            @can('view-etats')
                @include('validations.partials.states_summary')
            @endcan
        </div>
    </div>
    @can('delete-basethree')
        @include('modals.suppr_bdg')
    @endcan
    <!-- Envoi -->
    @can('validate')
        <div class="modal fade" id="update_state" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                            {{ trans('parametre.envoyer') }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="{{route('valider.'.$class)}}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="update_state_id" id="update_state_id" value="">
                            <div style="text-align: center;">
                                <img width="45%" height="200px" src="{{asset('/img/resource_humaine_send.svg')}}">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('formone.modal validation close')</button>
                            <button type="submit" class="btn btn-danger">@lang('formone.modal validation confirm')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan

    <!-- Rejet -->
    @can('reject')
        <div class="modal fade" id="modal_rejet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                            {{ trans('parametre.rejeter') }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="{{route('rejeter.'.$class)}}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="re_id" id="re_id" value="">
                            <div style="text-align: center;">
                                <img width="45%" height="200px" src="{{asset('/img/split.svg')}}">
                            </div>
                            <div>@lang('bdg.rejet confirmation')</div>
                            <div class="container">
                                <div class="d-flex justify-content-around flex-column ">
                                    <div class="p-2 mx-auto">
                                        <div class="form-group">
                                            <label for="inputMotif" class="control-label">@lang('parametre.motif')</label>
                                            <input type="text" class="form-control align-self-center" name="motif" id="motif" required>
                                        </div>
                                    </div>
                                    <div class="p-2">
                                        <div class="form-group">
                                            <label for="inputDesc" class="control-label">@lang('parametre.description')</label>
                                            <textarea class="form-control" name="desc" id="desc" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('formone.modal validation close')</button>
                            <button type="submit" class="btn btn-danger">@lang('formone.modal validation confirm')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan

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

    @can('dc')
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/fixedheader/3.1.9/js/dataTables.fixedHeader.min.js"></script>
        <script>
        $(document).ready(function() {
            // Setup - add a text input to each footer cell
            $('#example1 thead tr').clone(true).appendTo( '#example1 thead' );
            
            $('#example1 thead tr:eq(1) th').each( function (i) {
                if(i==0||i==1||i==9){}
                else{
                    var title = $(this).text();
                    $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
                }
                
        
                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
            var table = $('#example1').DataTable( {
                orderCellsTop: true,
                fixedHeader: true,
                
            } );
            $('#example-a_filter').hide()
        } );
        </script>
    @endcan

    

    <!-- rejet -->
    <script>
        $('#modal_rejet').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #re_id').val(id);
        })
    </script>

    <!-- envoi/validation -->
    <script type="text/javascript">
        $(function() {
            $("#btn_update_state").click(function() {
                var selected = new Array();
                $("#example1 input[type=checkbox]:checked").each(function() {
                    selected.push(this.value);
                });
                if (selected.length > 0) {
                    $('#update_state').modal('show')
                    $('input[id="update_state_id"]').val(selected);
                }
            });
            $("#btn_reject").click(function() {
                var selected = new Array();
                $("#example1 input[type=checkbox]:checked").each(function() {
                    selected.push(this.value);
                });
                if (selected.length > 0) {
                    $('#modal_rejet').modal('show')
                    $('input[id="re_id"]').val(selected);
                }
            });
        });
    </script>

@endsection
