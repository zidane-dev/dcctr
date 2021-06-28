@extends('layouts.master')

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
    @include('parametres.3.partials.breadcrumb_index')
@endsection

@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div id="attributions_card" class="card mg-b-20">
                @include('layouts.errors_success')
                <div class="card-header pb-0 ">
                    <div class="d-flex justify-content-center text-center">
                        <h3 class="col-5">
                            @if($data_v[0]->count() > 0)
                                @lang('axes.nom'): {{$data_v[0]->first()->axe->axe}}
                            @endif
                        </h3>
                    </div>
                    <div class="row d-flex">
                        <div class="col p-4 ">
                                <a href="{{url()->previous()}}" class="btn btn-primary" style="color: whitesmoke">
                                    <i class="fas fa-arrow-left"></i> @lang('formone.retour') 
                                </a>
                        </div>
                        @include('parametres.partials.filter')
                    </div>

                </div>
                @if($data_v[0]->count() > 0)
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example"  class="table key-buttons text-md-nowrap width-100" >
                                <thead>
                                <tr>
                                    <th width="25px" class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">@lang('parametre.annee')</th>
                                    @cannot('view-province')
                                        <th class="border-bottom-0">@lang('dpcis.nom')</th>
                                        <th class="border-bottom-0">@lang('attproc.niveau')</th>
                                    @endcannot
                                    <th class="border-bottom-0">@lang('attproc.transferts')</th>
                                    <th class="border-bottom-0">@lang('parametre.action')</th>
                                    <th class="border-bottom-0">@lang('attproc.statut')</th>
                                    <th class="border-bottom-0 no-wrap">@lang('parametre.last_update')</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($data_v[0] as $attribution)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$attribution->ANNEE}}</td>
                                        @cannot('view-province')
                                            <td>{{$attribution->domaine->ty}} - {{$attribution->domaine->domaine}}</td>
                                            <td>{{$attribution->niveau->niveau}}</td>                                        
                                        @endcannot
                                        <td>{{$attribution->attribution->attribution}}</td>
                                        <td>{{$attribution->action->action}}</td>                                        
                                        <td>{{$attribution->STATUT}}</td>
                                        <td>{{\Carbon\Carbon::parse($attribution->date)->format('d/m/y')}} @lang('parametre.at') 
                                            {{\Carbon\Carbon::parse($attribution->date)->format('H:i')}} 
                                        </td>
                                        
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @cannot('view-select')
                            <div class="card-text p-2">
                                <h4> @lang('attproc.vos_attributions') {{$count->a}} </h4>
                            
                            </div>
                        @endcannot
                    </div>  
                @else
                    @include('partials.emptylist')
                @endif
            </div>

            <div id="delegations_card" class="card mg-b-20">
                @include('layouts.errors_success')
                <div class="card-header pb-0 ">
                    <div class="d-flex justify-content-center text-center">
                        <h3 class="col-5">
                            @if($data_v[1]->count() > 0)
                                @lang('axes.nom'): {{$data_v[1]->first()->axe->axe}}
                            @endif
                        </h3>
                    </div>

                </div>
                @if($data_v[1]->count() > 0)
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example_copy"  class="table key-buttons text-md-nowrap width-100" >
                                <thead>
                                <tr>
                                    <th width="25px" class="border-bottom-0">#</th>
                                    @cannot('view-province')
                                        <th class="border-bottom-0">@lang('dpcis.nom')</th>
                                    @endcannot
                                    <th class="border-bottom-0">@lang('parametre.annee')</th>
                                    <th class="border-bottom-0">@lang('attproc.niveau')</th>
                                    <th class="border-bottom-0">@lang('attproc.delegations')</th>
                                    <th class="border-bottom-0">@lang('parametre.action')</th>
                                    <th class="border-bottom-0">@lang('attproc.statut')</th>
                                    <th class="border-bottom-0">@lang('parametre.last_update')</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($data_v[1] as $delegation)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$delegation->ANNEE}}</td>
                                        @cannot('view-province')
                                            <td>{{$delegation->domaine->ty}} - {{$delegation->domaine->domaine}}</td>
                                        @endcannot
                                        <td>{{$delegation->niveau->niveau}}</td>  
                                        <td>{{$delegation->attribution->attribution}}</td>
                                        <td>{{$delegation->action->action}}</td>  
                                        <td>{{$delegation->STATUT}}</td>  
                                        <td>{{\Carbon\Carbon::parse($delegation->date)->format('d/m/y')}} @lang('parametre.at') 
                                            {{\Carbon\Carbon::parse($delegation->date)->format('H:i')}} 
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @cannot('view-select')
                            <div class="card-text p-2">
                                <h4> @lang('attproc.vos_delegations') {{$count->b}} </h4>
                            </div>
                        @endcannot
                    </div>  
                @else
                    @include('partials.emptylist')
                @endif
            </div>

            @include('parametres.partials.meta_frame')
            
        </div>
    </div>

    <!-- Suppression -->
    <div class="modal" id="modalRhsdSUP">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">@lang('rhsd.modal supprimer')</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                                                                      type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="rhs/destroy" method="post">
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('rhsd.modal validation close')</button>
                        <button type="submit" class="btn btn-danger">@lang('rhsd.modal validation confirm')</button>
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

    <!--suppression -->
    <script>
        $('#modalRhsdSUP').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #rhsd_id').val(id);
        })
    </script>
    @can('view-select')
        @include('parametres.partials.filter_script')
    @endcan
@endsection