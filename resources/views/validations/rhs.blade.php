@extends('layouts.master')
@section('title') @lang('sidebar.liste rhsd')   @endsection
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
                    @can('dcsasd')
                        @lang('sidebar.rhsds') 
                    @else
                        @if(LaravelLocalization::getCurrentLocale() === 'fr')
                            @lang('sidebar.rhsds') / {{Auth::user()->domaine->type}} - {{Auth::user()->domaine->domaine_fr}}
                        @else
                            @lang('sidebar.rhsds') / {{Auth::user()->domaine->type}} - {{Auth::user()->domaine->domaine_ar}}
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
                        <h3 class="text-center">@lang('axes.nom'): {{$datas->first()->axe->axe}}</h3>
                        <a href="{{route('dashboard.index')}}" class="btn btn-primary" style="color: whitesmoke">
                            <i class="fas fa-arrow-left"></i> @lang('formone.retour') 
                        </a>
                        @can('create-rhsds')
                        <a href="{{route('rhs.create')}}" class="btn btn-primary" style="color: whitesmoke">
                            <i class="fas fa-plus"></i> @lang('rhsd.add') 
                        </a>
                        @endcan
                        <button type="button" class="btn btn-primary" id="btn_update_state" >
                            @lang('parametre.envoyer')
                        </button>
                        <button type="button" class="btn btn-primary" id="btn_reject" >
                            @lang('parametre.rejeter')
                        </button>
                    @else
                        <a href="{{route('dashboard.index')}}" class="btn btn-primary" style="color: whitesmoke">
                            <i class="fas fa-arrow-left"></i> @lang('formone.retour') 
                        </a>
                        @can('create-rhsds')
                        <a href="{{route('rhs.create')}}" class="btn btn-primary" style="color: whitesmoke">
                            <i class="fas fa-plus"></i> @lang('rhsd.add') 
                        </a>
                        @endcan
                    @endif
                    </div>
                @can('list-rhsds')
                    @if($datas->count() > 0)
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table key-buttons text-md-nowrap">
                                    <thead>
                                        <tr>
                                            <th width="10px"><input type="checkbox" name="select_all" id="example-select-all" onclick="CheckAll('box1',this)" class="text-center align-middle"> </th>
                                            <th width="25px" class="border-bottom-0">#</th>
                                            @can('view-region')
                                                <th class="border-bottom-0">@lang('dpcis.nom')</th>
                                            @endcan
                                            <th class="border-bottom-0">@lang('rhsd.nom_qualite')</th>
                                            <th class="border-bottom-0">@lang('parametre.last_modif')</th>
                                            <th class="border-bottom-0">@lang('parametre.annee')</th>
                                            <th class="border-bottom-0">@lang('parametre.nom_objectif')</th>
                                            <th class="border-bottom-0">@lang('parametre.nom_realisation')</th>
                                            <th class="border-bottom-0">@lang('rhsd.user')</th>
                                            <th class="border-bottom-0">@lang('parametre.etat')</th>
                                            <th class="border-bottom-0">@lang('parametre.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($datas as $rhsd)
                                        <tr @if($rhsd->REJETSD == 1) style="background-color: #f5b4b4 !important;}" @endif  
                                            @if($rhsd->ETATSD == 6) style="background-color: #9ae88b  !important;}" @endif>
                                            <td class="text-center align-middle">
                                                @if( $rhsd->ETATSD < 6 AND $rhsd->REJETSD == 0)
                                                    <input type="checkbox" value="{{$rhsd->id}}" class="box1">
                                                @endif
                                            </td>
                                            <td>{{$loop->iteration}}</td>
                                            @can('view-region')
                                                <td>{{$rhsd->domaine->ty}} - {{$rhsd->domaine->domaine}}</td>
                                            @endcan
                                            {{-- <td>{{\Carbon\Carbon::parse($rhsd->date)->format('d/m/y h:m')}}</td> --}}
                                            {{-- <td>{{\Carbon\Carbon::now()->diffForHumans($rhsd->updated_at)}}</td> --}}
                                            <td>{{$rhsd->qualite->qualite}}</td>
                                            <td>{{\Carbon\Carbon::parse($rhsd->date)->format('d/m/y')}} @lang('parametre.at') 
                                                {{\Carbon\Carbon::parse($rhsd->date)->format('H:i')}} 
                                            </td>
                                            <td>{{$rhsd->ANNEESD}}</td>
                                            <td>{{$rhsd->OBJECTIFSD}}</td>
                                            <td>{{$rhsd->REALISATIONSD}}</td>
                                            <td>{{$rhsd->user->name}}</td>
                                            @can('s-a')
                                            <td>
                                                @if($rhsd->ETATSD == 0)
                                                    <label class="badge badge-success">{{ $rhsd->ETATSD }}</label>
                                                @else
                                                    <label class="badge badge-info"> {{$rhsd->ETATSD}}</label>
                                                @endif
                                            </td>
                                            @endcan
                                            @can('view-rejet')
                                                <td>
                                                    @if($rhsd->REJETSD == 1)
                                                        <label class="badge badge-danger">@lang('parametre.rejete')</label>
                                                    @else
                                                        @if($rhsd->ETATSD == 6 OR $rhsd->ETATSD < 2)
                                                        @else
                                                            <label class="badge badge-info">@lang('parametre.non')</label>
                                                        @endif
                                                    @endif
                                                </td>
                                            @endcan
                                            <td class="d-inline-flex text-center align-middle">
                                                <div class="dropdown">
                                                    <button aria-expanded="false" aria-haspopup="true"
                                                            class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                            type="button">
                                                                @lang('parametre.actions')
                                                            <i class="fas fa-caret-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        @can('edit-rhsds')
                                                            <a class="dropdown-item" href="{{route('rhs.edit',$rhsd->id)}}">
                                                                <i class="fas fa-edit" style="color: #239a8a"></i>
                                                                &nbsp;&nbsp;@lang('parametre.edit')
                                                            </a>
                                                        @endcan
                                                        @can('insert-real')
                                                            <a class="dropdown-item" href="{{route('rhs.storereal',$rhsd->id)}}">
                                                                <i class="fas fa-plus-circle"></i>
                                                                &nbsp;&nbsp;@lang('rhsd.ajoutSur')
                                                            </a>
                                                        @endcan
                                                        @can('edit-global-goal')
                                                            <a class="dropdown-item" href="{{route('edit.rhsgoal',$rhsd->id)}}">
                                                                <i class="fas fa-vote-yea"></i>
                                                                &nbsp;&nbsp;@lang('parametre.changeObjectif')
                                                            </a>
                                                        @endcan
                                                        @can('follow-info')
                                                            <a class="dropdown-item" href="{{route('rhs.show',$rhsd->id)}}">
                                                                <i class="fas fa-info"></i>
                                                                &nbsp;&nbsp;@lang('rhsd.viewRh')
                                                            </a>
                                                        @endcan
                                                        @can('delete-rhsds')
                                                            <a class="dropdown-item"  href="javascript:void(0)" data-id="{{ $rhsd->id }}"
                                                            data-toggle="modal" data-target="#modalRhsdSUP">
                                                                <i class="text-danger fas fa-trash-alt"></i>
                                                                &nbsp;&nbsp;@lang('rhsd.supprimer')
                                                            </a>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        @include('partials.emptylist')
                    @endif
                @else
                    @include('partials.emptylist')
                @endcan
            </div>
            @can('view-etats')
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <h3 class="text-center">@lang('parametre.etats actuels')</h3>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        
                        <div class="d-flex flex-wrap even-cols">
                            @foreach ($rows_count as $count)
                                @if($loop->iteration > 1 && $loop->iteration<9)
                                    @can('sd')
                                        @if($loop->iteration>1 && $loop->iteration<6)
                                            <div class="col w-100 inline-block" >
                                                <div class="card" style="height: 180px">
                                                    <div class="card-title mt-2" >@lang('roles.Etat '.($loop->iteration-2))(@lang('parametre.etat') {{$loop->iteration -2}})</div>
                                                    <div class="card-body">
                                                        <h2>{{$count}}</h2>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        @endif
                                    @elsecan('dcsasd')
                                        <div class="col w-100 inline-block" >
                                            <div class="card" style="height: 180px">
                                                <div class="card-title mt-2" ><h2>{{$count}}</h2></div>
                                                <div class="card-body">
                                                    @lang('roles.Etat '.($loop->iteration-2))(@lang('parametre.etat') {{$loop->iteration -2}})
                                                </div>
                                                
                                            </div>
                                        </div>
                                    @endcan
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div>
                        @lang('rhsd.total lignes')
                        @can('sd')
                            @lang('rhsd.de votre') {{Auth::user()->domaine->type}} 
                        @endcan
                        : {{$rows_count->rows}}
                    </div>
                </div>
            </div>
            @endcan
        </div>
    </div>

    <!-- Envoi -->
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

                <form action="{{route('update_etat')}}" method="POST">
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

    <!-- Rejet -->
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

                <form action="{{route('rejet')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="re_id" id="re_id" value="">
                        <div style="text-align: center;">
                            <img width="45%" height="200px" src="{{asset('/img/split.svg')}}">
                        </div>
                        <div>@lang('rhsd.rejet confirmation')</div>
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

    @can('dcsasd')
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
