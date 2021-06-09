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

    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    @if(LaravelLocalization::getCurrentLocale() === "ar")
        <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    @else
        <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect.css') }}">

    @endif
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">
                    @lang('sidebar.archives') de la {{Auth::user()->domaine->type}} {{Auth::user()->domaine_fr}}
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
<div class="row row-sm">


    <div class="col-xl-12">
        <div class="card mg-b-20">
            
            @include('layouts.errors_success')
            <div class="card-header pb-0">
                
                <h3 class="text-center">
                    Archives
                </h3>
                <div class="px-2 row">
                    <div class="col-md-4">
                        @can('create-rhsds')
                        <a href="{{route('rhs.create')}}" class="btn btn-primary" style="color: whitesmoke">
                            <i class="fas fa-plus"></i> @lang('rhsd.add') 
                        </a>
                        @endcan
                        <button ype="button" class="btn btn-primary" id="btn_update_state" >
                            @lang('rhsd.envoyer')
                        </button>
                        <button type="button" class="btn btn-primary" id="btn_reject" >
                            @lang('rhsd.rejeter')
                        </button>
                    </div>
                    <div class="col-md-4">
                        <form>
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <select id="axis" name="parametre" class="form-control SlectBox">
                                    <option value="" selected disabled> @lang('archive.choix_param')</option>
                                    {{-- HOPEFULLY THIS CAN COME FROM AXES TABLE --}}
                                    {{-- hardcoded for now :( --}}
                                    <option value="0">@lang('sidebar.rhsds')</option>
                                    <option value="0">@lang('sidebar.budget')</option>
                                    <option value="0">@lang('sidebar.attributions')</option>
                                    <option value="0">@lang('sidebar.indicateurs')</option>
                                </select>
                            </div>
                        </form>
                    </div> 
                </div> 
            </div>

            @can('list-rhsds')
                @if($rhsds->count() > 0)
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1"  class="table key-buttons text-md-nowrap">
                                <thead>
                                <tr>
                                    <th width="10px"><input type="checkbox" name="select_all" id="example-select-all" onclick="CheckAll('box1',this)"> </th>
                                    <th width="25px" class="border-bottom-0">#</th>
                                    @hasanyrole('s-a|d-r')
                                        <th class="border-bottom-0">@lang('dpcis.type')</th>
                                        <th class="border-bottom-0">@lang('dpcis.nom')</th>
                                    @endhasanyrole
                                    <th class="border-bottom-0">@lang('rhsd.nom_qualite')</th>
                                    <th class="border-bottom-0">@lang('rhsd.nom_realisation')</th>
                                    <th class="border-bottom-0">@lang('rhsd.user')</th>
                                    @hasanyrole('s-a')
                                        <th class="border-bottom-0">@lang('rhsd.etat')</th>
                                        @else
                                    @endhasanyrole
                                    <th class="border-bottom-0">@lang('rhsd.rejet')</th>
                                    <th class="border-bottom-0">@lang('rhsd.motif')</th>
                                    <th class="border-bottom-0">@lang('rhsd.deleted_at')</th>
                                    <th class="col-auto mr-auto border-bottom-0">@lang('rhsd.action')</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($rhsds as $rhsd)
                                    <tr style="background-color: hsla(0, 100%, 65%, 0.4) !important;}">
                                        <td>
                                            <input type="checkbox" value="{{$rhsd->id}}" class="box1">
                                        </td>
                                        <td>
                                            {{$loop->iteration}}
                                        </td>
                                        
                                        @hasanyrole('s-a|d-r')
                                            <td>{{$rhsd->domaine->t}}</td>
                                            <td>{{$rhsd->domaine->domaine}}</td>
                                        @endhasanyrole
                                        {{-- <td>{{\Carbon\Carbon::parse($rhsd->date)->format('d/m/y h:m')}}</td> --}}
                                        {{-- <td>{{\Carbon\Carbon::now()->diffForHumans($rhsd->updated_at)}}</td> --}}
                                        <td>{{$rhsd->qualite->qualite}}</td>
                                        <td>{{$rhsd->REALISATIONSD}}</td>
                                        <td>{{$rhsd->user->name}}</td>
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
                                            @if($rhsd->REJETSD == 1)
                                                <label class="badge badge-danger">@lang('rhsd.rejete')</label>
                                            @else
                                                @if($rhsd->ETATSD == 6 OR $rhsd->ETATSD < 2)
                                                @else
                                                <label class="badge badge-info">@lang('rhsd.non')</label>
                                                @endif
                                            @endif
                                        </td>
                                        {{-- <td>
                                            @if($rhsd->Description != "")
                                                {{\Illuminate\Support\Str::limit($rhsd->Description,30,'...')}}
                                            @else
                                                <span><a href="" style="color: #47484a;margin-left: 32%;"><i class="fas fa-plus-circle" ></i></a></span>

                                            @endif
                                        </td> --}}

                                        <td style="text-align: center">
                                            @if($rhsd->Motif != "")
                                                {{\Illuminate\Support\Str::limit($rhsd->Motif,30,'...')}}
                                            @else

                                            @endif

                                        </td>
                                        <td>{{\Carbon\Carbon::parse($rhsd->deleted_at)->format('d/m/y')}} @lang('rhsd.at') 
                                            {{\Carbon\Carbon::parse($rhsd->deleted_at)->format('H:i')}} 
                                        </td>
                                        <td class="d-inline-flex text-center align-middle">
                                            @if($rhsd->ETATSD != 6)
                                                <div class="dropdown">
                                                    <button aria-expanded="false" aria-haspopup="true"
                                                            class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                            type="button">
                                                                @lang('rhsd.actions')
                                                            <i class="fas fa-caret-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        @can('edit-rhsds')
                                                            <a class="dropdown-item" href="{{route('rhs.edit',$rhsd->id)}}">
                                                                <i class=" fas fa-edit" style="color: #239a8a"></i>
                                                                &nbsp;&nbsp;@lang('rhsd.edit')
                                                            </a>
                                                        @endcan

                                                            <a class="dropdown-item" href="{{route('rhs.storereal',$rhsd->id)}}">
                                                                <i class="fas fa-plus-circle"></i>
                                                                &nbsp;&nbsp;@lang('rhsd.ajoutSur')
                                                            </a>

                                                            <a class="dropdown-item" href="{{route('edit.rhsgoal',$rhsd->id)}}">
                                                                <i class="fas fa-vote-yea"></i>
                                                                &nbsp;&nbsp;@lang('rhsd.changeObjectif')
                                                            </a>
                                                        
                                                        @can('delete-rhsds')
                                                            <a class="dropdown-item"  href="javascript:void(0)" data-id="{{ $rhsd->id }}"
                                                            data-toggle="modal" data-target="#modalRhsdSUP">
                                                                <i class="text-danger fas fa-trash-alt"></i>
                                                                &nbsp;&nbsp;@lang('rhsd.supprimer')
                                                            </a>
                                                        @endcan
                                                    </div>
                                                </div>
                                            @else
                                                <span class="badge badge-info" style="background-color: #ffffff; color: black;">@lang('rhsd.validated')</span>
                                                <a class=" px-3" href="{{route('rhs.storereal',$rhsd->id)}}" title="@lang('rhsd.ajoutSurTitle')">
                                                    <i class="fas fa-plus-circle"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div>
                            <img width="100%" height="300px" src="{{asset('assets/img/svgicons/no-data.svg')}}">
                        </div>
                    @endif
                @else
                    <div>
                        <img width="100%" height="300px" src="{{asset('assets/img/svgicons/no-data.svg')}}">
                    </div>
                @endcan
            </div>
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

    <script>
        jQuery(document).ready(function(){
            var axe_nom = null;

            $('#axe_nom').on("change".,)
        })
    </script>
@endsection