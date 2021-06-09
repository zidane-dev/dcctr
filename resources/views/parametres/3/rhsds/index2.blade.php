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
                    @lang('sidebar.rhsds') de la {{Auth::user()->domaine_fr}}
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
    <div class="row row-sm ">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                
                @include('layouts.errors_success')
                <div class="card-header pb-0">
                    <h3 class="text-center">
                        Choisissez une province
                    </h3>
                </div>
                <div class="card-body mx-auto" width="450px">
                    <div class="m-5 p-5">
                        <form method="GET" action="{{route('indexByQuery')}}">
                            @csrf
                            <div id="typeDiv" class="form-group row">
                                <label for="type" class="control-label  mx-2">@lang('dpcis.type')</label>
                                <select id="type" name="type" class="form-control SlectBox mx-2" >
                                    <option value="" selected disabled> @lang('dpcis.type')</option> {{-- this year by default --}}
                                    <option value="1">SD</option>
                                    <option value="2">AC</option>
                                </select>
                            </div>
                            <div id="regDiv" class="form-group row">
                                <label for="region" class="control-label  mx-2">@lang('drs.nom')</label>
                                <select id="region" name="region" class="form-control SlectBox mx-2" >
                                    <option value="" selected disabled> @lang('drs.nom')</option> {{-- this year by default --}}
                                        @foreach($regions as $r)
                                            @if($r->id==13)
                                            <option class="d-none" value="{{$r->id}}" {{ (collect(old('region'))->contains($r->region)) ? 'selected':'' }}>
                                                {{$r->region}}
                                            </option>
                                            @else
                                                <option value="{{$r->id}}" {{ (collect(old('region'))->contains($r->region)) ? 'selected':'' }}>
                                                    {{$r->region}}
                                                </option>
                                            @endif
                                        @endforeach
                                </select>
                            </div>
                            <div id="provDiv" class="form-group row">
                                <label for="province" class="control-label  mx-2">@lang('dpcis.nom')</label>
                                <select id="selectProvince" name="province" class="form-control SlectBox mx-2" >
                                    <option id="optionProvince" value="" > @lang('dpcis.nom')</option> {{-- this year by default --}}
                                </select>
                            </div>
                            <input type="submit" class="btn mx-auto my-4" value="GO" id="submit" style="width:450px; background-color:lightgreen; color:whitesmoke;">
                        </form>
                    </div>
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

    <script type="text/javascript">
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function(){
            var provinceSel = $('#provDiv');
            var regionSel = $('#regDiv');
            $('#submit').hide();
            provinceSel.hide();
            regionSel.hide();
 
            $('#type').on('change', function(e){
                var type = e.target.value;
                $('select[name="province"]').empty();
                if(type==1){
                    regionSel.show();
                    provinceSel.hide();
                }else if(type==2){
                    regionSel.hide();
                    const element = document.querySelector('#region');
                    const e = new Event("change");
                    element.value = 13;
                    element.dispatchEvent(e);
                }
            })
            $('#region').on('change', function(e){
                var cat_id = e.target.value;
                $.ajax({
                    url:"{{route('subReg')}}",
                    type: "GET",
                    data:{
                        region_id: cat_id,
                    },
                    success : function(data){
                        provinceSel.show();
                        $('select[name="province"]').empty();
                        var id, type, nom;
                        for(var i = 0; i<data['provinces'].length; i++){
                            if(i==0){
                            $('#selectProvince').append('<option value="" selected disabled></option>');
                                
                            }
                            id = data["provinces"][i]['id'];
                            type = data["provinces"][i]['t'];
                            nom = data["provinces"][i]['name'];
                            $('#selectProvince').append('<option value="'+id+'">'+type+' - '+nom+'</option>');
                        }
                    }
                });
            });
            $('#selectProvince').on('change', function(e){
                $('#submit').show();
            })
        });
    </script>
@endsection