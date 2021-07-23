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
            <div class="card mg-b-20">
                @include('layouts.errors_success')
                <div class="card-header pb-0 ">
                    <div class="d-flex justify-content-center text-center">
                        <h3 class="col-5">
                            @if($data_v->count() > 0)
                                @lang('axes.nom'): {{$data_v->first()->axe->axe}}
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
                @if($data_v->count() > 0)
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example"  class="table key-buttons text-md-nowrap width-100" >
                                <thead>
                                <tr>
                                    <th width="25px" class="border-bottom-0">#</th>
                                    @canany(['view-region','view-select'])
                                        <th class="border-bottom-0">@lang('dpcis.nom')</th>
                                    @endcanany
                                    <th class="border-bottom-0">@lang('rhsd.nom_qualite')</th>
                                    <th class="border-bottom-0">@lang('parametre.annee')</th>
                                    <th class="border-bottom-0">@lang('parametre.nom_objectif')</th>
                                    <th class="border-bottom-0">@lang('parametre.nom_realisation')</th>
                                    <th class="border-bottom-0">@lang('parametre.last_update')</th>
                                    @canany(['add-on','edit-global-goal','follow-info','delete-rhsds'])
                                        <th class="border-bottom-0">@lang('parametre.actions')</th>
                                    @endcanany
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($data_v as $rhsd)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        @canany(['view-region','view-select'])
                                            <td>{{$rhsd->domaine->ty}} - {{$rhsd->domaine->domaine}}</td>
                                        @endcanany
                                        <td>{{$rhsd->qualite->qualite}}</td>
                                        <td>{{$rhsd->ANNEE}}</td>
                                        <td>{{$rhsd->OBJECTIF}}</td>
                                        <td>{{$rhsd->REALISATION}}</td>
                                        <td>{{\Carbon\Carbon::parse($rhsd->date)->format('d/m/y')}} @lang('parametre.at') 
                                            {{\Carbon\Carbon::parse($rhsd->date)->format('H:i')}} </td>
                                        @canany(['add-on','edit-global-goal','follow-info','delete-basethree'])
                                            <td class="mx-auto">
                                                @can('add-on')
                                                    <a class="mx-auto px-1" href="{{route('rhs.storereal',$rhsd->id)}}" title="@lang('rhsd.ajoutSur')">
                                                        <i class="fas fa-plus-circle"></i>
                                                    </a>
                                                @endcan
                                                @can('edit-global-goal')
                                                    <a class="mx-auto px-1" href="{{route('edit.rhsgoal',$rhsd->id)}}" title="@lang('parametre.changeObjectif')">
                                                        <i class="fas fa-vote-yea"></i>
                                                    </a>
                                                @endcan
                                                @can('follow-info')
                                                    <a class="mx-auto px-1" href="{{route('rhs.show',$rhsd->id)}}" title="@lang('rhsd.viewRh')">
                                                        <i class="fas fa-info"></i>
                                                    </a>
                                                @endcan
                                                @can('delete-basethree')
                                                    <a class=""  href="javascript:void(0)" data-id="{{ $rhsd->id }}" title="@lang('rhsd.supprimer')"
                                                    data-toggle="modal" data-target="#modalRhsdSUP">
                                                        <i class="text-danger fas fa-trash-alt"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                        @endcanany
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @cannot('view-select')
                            <div class="card-text p-2">
                                <h4>{{$count->a}}/{{$count->b}} @lang('parametre.objectifs atteints') </h4>
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