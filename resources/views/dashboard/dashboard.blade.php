@extends('layouts.master')

@section('css')
    <!--  Owl-carousel css -->
    <link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet" />
    <!-- Maps css -->
    <link href="{{URL::asset('assets/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
    <!--Internal Chartjs-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
@endsection
@section('page-header')

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Bienvenue {{Auth::user()->name}} !</h2>
                @include('layouts.errors_success')
            </div>
        </div>
        <div class="main-dashboard-header-right">
            <div class="text-center">
                <label class="tx-13">@lang('roles.vos_validations')</label>
                <h5>{{$data['total']}}</h5>
            </div>
            
        </div>
    </div>
    <!-- /breadcrumb -->
@endsection
@section('content')
    <!-- row op -->
    <div class="row row-sm">
        {{-- <div class="col-md-12 col-lg-12 col-xl-7">
            <div class="card">
                <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">Order status</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 text-muted mb-0">Order Status and Tracking. Track your order from ship date to arrival. To begin, enter your order number.</p>
                </div>
                <div class="card-body">
                    <div class="total-revenue">
                        <div>
                            <h4>120,750</h4>
                            <label><span class="bg-primary"></span>Objectif</label>
                        </div>
                        <div>
                            <h4>56,108</h4>
                            <label><span class="bg-success"></span>Realisation</label>
                        </div>
                        <div>
                            <h4>32,895</h4>
                            <label><span class="bg-warning"></span>Ecart</label>
                        </div>
                    </div>
                    <div id="pie" class="donut-pie mt-4"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-xl-5">
            <div class="card card-dashboard-map-one">
                <label class="main-content-label">Regions</label>
                <span class="d-block mg-b-20 text-muted tx-12">Indicateurs de Performance de toutes les regions du maroc</span>
                <div class="">
                    <div class="vmap-wrapper ht-180" id="vmap2"></div>
                </div>
            </div>
        </div> --}}
        <div class="col-6 align-self-center">
            <div class="card text-center">
                <label class="main-content-label  my-3">@lang('general.construction')</label>
                <div class="">
                    <img width="auto" height="700px" src="{{asset('assets/img/svgicons/construction.svg')}}">
                </div>
            </div>
        </div>
        <div class="col-6 align-self-center">
            <div class="card text-center">
                <div class="card-header">
                <label class="main-content-label  my-3">Caract??risations de l'utilisateur</label>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Structure</th>
                                <th>R??le</th>
                                <th>Port??e</th>
                            </tr>
                        </thead>
                        <tbody>
                            <td>
                                {{$data['structure']}}
                            </td>
                            <td>
                                {{$data['role']}}
                            </td>
                            <td>
                                {{$data['portee']}}
                            </td>
                        </tbody>
                    </table>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Attributions et D??l??gations</th>
                                <th>Ressources Humaines</th>
                                <th>Ressources Mat??rielles</th>
                                <th>Indicateurs de Performance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <td>
                                {{session()->get('rh_count')}}
                            </td>
                            <td>
                                {{session()->get('bdg_count')}}
                            </td>
                            <td>
                                {{session()->get('attproc_count')}}
                            </td>
                            <td>
                                <span class="font-weight-light font-italic">(@lang('general.construction'))<span>
                            </td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- row clos -->
@endsection

@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
    <!-- Moment js -->
    <script src="{{URL::asset('assets/plugins/raphael/raphael.min.js')}}"></script>
    <!--Internal  Flot js-->
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js')}}"></script>
    <script src="{{URL::asset('assets/js/dashboard.sampledata.js')}}"></script>
    <script src="{{URL::asset('assets/js/chart.flot.sampledata.js')}}"></script>
    <!--Internal Apexchart js-->
    <script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>
    
    <!-- Internal Map -->
    <script src="{{URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.africa.js')}}"></script>
    <script src="{{URL::asset('assets/js/modal-popup.js')}}"></script>
    <!--Internal  index js -->
    <script src="{{URL::asset('assets/js/index.js')}}"></script>
    <script src="{{URL::asset('assets/js/jquery.vmap.sampledata.js')}}"></script>
@endsection