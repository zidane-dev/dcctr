@extends('layouts.master')
@section('title') @lang('archives.nom')   @endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/css/archives.css')}}" rel="stylesheet">
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
                    {{Auth::user()->domaine->type}} {{Auth::user()->domaine_fr}}
                </h4>
                <span class="text-muted mt-1 tx-15 mr-2 mb-0">
                    &nbsp;&nbsp;&nbsp;&nbsp; / @lang('archives.nom')
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
                    @lang('archives.nom')
                </h3>
                <div  class="row w-100">
                    <div id="default_a" style="border: thick solid #2c2c2c;" class="col text-center mx-1 py-3">
                        @lang('archives.choix')
                    </div>
                    <div id="attprocs"  
                        style="background: #285cf7; border: medium double #2c2c2c; color: white" class="col text-center py-3 ml-1">
                            @lang('sidebar.attributions')
                    </div>
                    <div id="rhsds"     
                        style="background: #285cf7; border: medium double #2c2c2c; color: white" class="col text-center py-3 ml-1">
                            @lang('sidebar.rhsds')       
                    </div>
                    <div id="bdgs"      
                        style="background: #285cf7; border: medium double #2c2c2c; color: white" class="col text-center py-3 ml-1">
                            @lang('sidebar.budgets')      
                    </div>
                    <div id="indics"    
                        style="background: #285cf7; border: medium double #2c2c2c; color: white" class="col text-center py-3 ml-1">
                            @lang('sidebar.indicateurs') 
                    </div>
                </div>
            </div>
            <div class="card-body" >
                <div id="div_tbl">
                    
                </div>
                <div id="arch_def" class="text-center">
                    <img src="{{URL::asset('img/archive.jpg')}}" style="border: 2px solid black" alt="Archives" height="550" class="mb-1 w-90"/>
                </div>
            </div>
        </div>
    </div>
</div>  
@endsection
@yield('modals')
@section('js')
    <!-- Internal Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}" defer></script>
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
    <script src="{{URL::asset('assets/js/table-data.js')}}" defer></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#example1").hide();
            $("#attprocs").on('click', function(e){
                $("#example1").show();
                $("#arch_def").hide();
                $("#div_tbl").load('/archives/atts/');
            });
            $("#rhsds").on('click', function(f){
                $("#div_tbl").show();
                $("#arch_def").hide();
                $("#div_tbl").load('/archives/rhs/');
            });
            $("#bdgs").on('click', function(d){
                $("#div_tbl").show();
                $("#arch_def").hide();
                $("#div_tbl").load('/archives/rms/');
            });
            $("#indics").on('click', function(g){
                $("#div_tbl").show();
                $("#arch_def").hide();
                $("#div_tbl").load('/archives/ips/');
            });
            $("#default_a").on('click', function(h){
                if(!$("#arch_def").is(":visible")){
                    console.log('aie');
                    $("#div_tbl").hide();
                    $("#arch_def").show();
                }
            });
        });
    </script>
@endsection