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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">
                    @lang('sidebar.rhsds') de la {{Auth::user()->domaine->type}} {{Auth::user()->domaine_fr}}
                </h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                    &nbsp;&nbsp;&nbsp;&nbsp;/  @lang('sidebar.liste rhsd')
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
                    <h3 class="text-center">
                        @if($rhsds->count() > 0)
                            Progression des realisations
                        @endif
                    </h3>
                    @can('create-rhsds')
                    <a href="{{route('rhs.create')}}" class="btn btn-primary" style="color: whitesmoke">
                        <i class="fas fa-plus"></i> @lang('rhsd.add') 
                    </a>
                    @endcan
                </div>

                @can('list-rhsds')
                    @if($rhsds->count() > 0)
                        <div class="card-body">
                            <div id='commonInfo' class="card-text px-5 py-2">
                                @lang('rhsd.nom_qualite') : {{$rhsds->first()->qualite->qualite}} <br>
                                @lang('rhsd.nom_objectif') : {{$rhsds->first()->OBJECTIFSD}} <br>
                                @lang('dpcis.nom') : {{$rhsds->first()->domaine->type}} {{$rhsds->first()->domaine->domaine}} <br>
                            </div>
                            <div class="table-responsive">
                                <table id="example1" class="table key-buttons text-md-nowrap">
                                    <thead>
                                        <tr>
                                            <th width="25px" class="border-bottom-0">#</th>
                                            @can('view-region')
                                                <th class="border-bottom-0">@lang('dpcis.type')</th>
                                                <th class="border-bottom-0">@lang('dpcis.nom')</th>
                                            @endcan
                                            <th class="border-bottom-0">@lang('rhsd.modif_at')</th>
                                            <th class="border-bottom-0">@lang('rhsd.par')</th>
                                            <th class="border-bottom-0">@lang('rhsd.nom_realisation')</th>
                                            <th class="border-bottom-0">@lang('rhsd.annee')</th>
                                            <th class="border-bottom-0">@lang('rhsd.nom_objectif')</th>
                                            <th class="border-bottom-0">@lang('rhsd.etat')</th>
                                            <th class="border-bottom-0">@lang('rhsd.motif')</th>
                                            <th class="border-bottom-0">@lang('rhsd.description')</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($rhsds as $rhsd)
                                        <tr>
                                            <td>
                                                {{$loop->iteration}}
                                            </td>
                                            @can('view-region')
                                                <td>{{$rhsd->domaine->ty}}</td>
                                                <td>{{$rhsd->domaine->domaine}}</td>
                                            @endcan
                                            <td>{{\Carbon\Carbon::parse($rhsd->date)->format('d/m/y')}} @lang('rhsd.at') 
                                                {{\Carbon\Carbon::parse($rhsd->date)->format('H:i')}} 
                                            </td>
                                            <td>{{$rhsd->user->name}}</td>
                                            <td>{{$rhsd->REALISATIONSD}}</td>
                                            <td>{{$rhsd->ANNEESD}}</td>
                                            <td>{{$rhsd->OBJECTIFSD}}</td>
                                            @hasanyrole('s-a')
                                            <td>
                                                @if($rhsd->ETATSD == 0)
                                                    <label class="badge badge-success">{{ $rhsd->ETATSD }}</label>
                                                @else
                                                    <label class="badge badge-info"> {{$rhsd->ETATSD}}</label>
                                                @endif
                                            </td>
                                            @endhasanyrole
                                            <td>
                                                @if($rhsd->ETATSD == 6)
                                                    <label class="badge badge-success">@lang('rhsd.validated')</label>
                                                @elseif($rhsd->REJETSD == 1)
                                                    <label class="badge badge-danger">@lang('rhsd.rejete')</label>
                                                @else
                                                    <label class="badge badge-secondary">@lang('rhsd.encours')</label>
                                                @endif
                                            </td>
                                            @if($rhsd->REJETSD == 1)
                                            <td>{{$rhsd->Motif}}</td>
                                            <td>
                                                @if($rhsd->Description != "")
                                                    {{\Illuminate\Support\Str::limit($rhsd->Description,30,'...')}}
                                                @else
                                                    <span><a href="" style="color: #47484a;margin-left: 32%;"><i class="fas fa-plus-circle" ></i></a></span>

                                                @endif
                                            </td>
                                            @else
                                                <td>- - -</td>
                                                <td>- - -</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                    @else
                        @include('partials.emptylist')
                    @endif
                @else
                    @include('partials.emptylist')
                @endcan
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

@endsection