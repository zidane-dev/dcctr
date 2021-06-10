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
                    @can('dcsasd')
                        {{$query[4]}} - {{$query[3]}}
                    @elsecan('sd')
                        @lang('sidebar.rhsds') / {{Auth::user()->domaine->type.' / '.$rh_v->first()->domaine->domaine}}
                    @endcan
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
                        @if($rh_v->count() > 0)
                            @lang('axes.nom'): {{$rh_v->first()->axe->axe}}
                        @endif
                    </h3>
                    <div>
                        <a href="{{url()->previous()}}" class="btn btn-primary" style="color: whitesmoke">
                            <i class="fas fa-arrow-left"></i> @lang('formone.retour') 
                        </a>
                    </div>
                    @can('dcsasd')
                        @if(!isset($backfirst))
                        <div class="m-4 float-right">
                            <form class="form-inline" method="GET" action="{{route('indexByQuery')}}">
                                @csrf
                                <div id="regDiv">
                                    <label for="region" class="sr-only">@lang('drs.nom')</label>
                                    <select id="region" name="region" class="form-control SlectBox mr-sm-2">
                                        <option value="" selected disabled> @lang('drs.nom')</option> {{-- this year by default --}}
                                            @foreach($regions as $r)
                                            @if(isset($query[1]))
                                                @if($r->id == $query[1])
                                                    <option value="{{$r->id}}" selected>
                                                        {{$r->region}}
                                                    </option>
                                                @else
                                                @endif
                                            @else
                                                @if($r->id==13)
                                                <option class="d-none" value="{{$r->id}}" {{ (collect(old('region'))->contains($r->region)) ? 'selected':'' }}>
                                                    {{$r->region}}
                                                </option>
                                                
                                                @else
                                                    <option value="{{$r->id}}" {{ (collect(old('region'))->contains($r->region)) ? 'selected':'' }}>
                                                        {{$r->region}}
                                                    </option>
                                                @endif
                                            @endif
                                            @endforeach
                                    </select>
                                </div>
                                <div id="provDiv">
                                    <label for="province" class="sr-only">@lang('dpcis.nom')</label>
                                    <select id="selectProvince" name="province" class="form-control SlectBox mr-sm-2" >
                                        <option id="optionProvince" value="{{$query[0]}}" >{{$dp->t}}-{{$dp->domaine}}</option>
                                    </select>
                                </div>
                                <div id ="dateDiv">
                                    <label for="dateFilter" class="sr-only">@lang('parametre.filtrer par')</label>
                                    <select id="dateFilter" name="year" class="form-control SlectBox2 mx-2" >
                                        <option value="null" selected disabled> @lang('parametre.annee')</option> {{-- this year by default --}}
                                        @if(isset($rh_sum) && $rh_sum->count() > 0)
                                            @foreach($rh_sum as $rh_year)
                                                <option value="{{$rh_year->first()->ANNEESD}}" {{ (collect(old('dateFilter'))->contains($rh_year->first()->ANNEESD)) ? 'selected':'' }}>
                                                    {{$rh_year->first()->ANNEESD}}
                                                </option>
                                            @endforeach
                                        @else
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                        @endif
                                    </select>
                                </div>
                                <input type="submit" value="GO" id="submit">
                            </form>
                        </div>
                        @endif
                    @else
                        @if(!isset($backfirst))
                        <form>
                            @csrf
                            <div class="form-inline row m-4 float-right">
                                <label for="dateFilter" class="control-label form-label mx-2">@lang('parametre.filtrer par')</label>
                                <select id="dateFilter" name="dateFilter" class="form-control SlectBox  mx-2" >
                                    <option value="" selected disabled> @lang('parametre.annee')</option> {{-- this year by default --}}
                                    @if(isset($rh_sum) && $rh_sum->count() > 0)
                                        @foreach($rh_sum as $rh_year)
                                            <option value="{{$rh_year->first()->ANNEESD}}" {{ (collect(old('dateFilter'))->contains($rh_year->first()->ANNEESD)) ? 'selected':'' }}>
                                                {{$rh_year->first()->ANNEESD}}
                                            </option>   
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </form>
                        @endif
                    @endcan
                </div>
                @can('list-rhsds')
                    @if($rh_v->count() > 0)
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example"  class="table key-buttons text-md-nowrap" >
                                    <thead>
                                    <tr>
                                        <th width="25px" class="border-bottom-0">#</th>
                                        @can('view-region')
                                            <th class="border-bottom-0">@lang('dpcis.nom')</th>
                                        @endcan
                                        <th class="border-bottom-0">@lang('rhsd.nom_qualite')</th>
                                        <th class="border-bottom-0">@lang('parametre.annee')</th>
                                        <th class="border-bottom-0">@lang('parametre.nom_objectif')</th>
                                        <th class="border-bottom-0">@lang('parametre.nom_realisation')</th>
                                        <th class="border-bottom-0">@lang('parametre.etat')</th>
                                        <th class="border-bottom-0">@lang('parametre.last_update')</th>
                                        <th class="border-bottom-0">@lang('parametre.actions')</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($rh_v as $rhsd)
                                    @if($rhsd->ETATSD == 6)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            @can('view-region')
                                                <td>{{$rhsd->domaine->ty}} - {{$rhsd->domaine->domaine}}</td>
                                            @endcan
                                            {{-- <td>{{\Carbon\Carbon::parse($rhsd->date)->format('d/m/y h:m')}}</td> --}}
                                            {{-- <td>{{\Carbon\Carbon::now()->diffForHumans($rhsd->updated_at)}}</td> --}}
                                            <td>{{$rhsd->qualite->qualite}}</td>
                                            <td>{{$rhsd->ANNEESD}}</td>
                                            <td>{{$rhsd->OBJECTIFSD}}</td>
                                            <td>{{$rhsd->REALISATIONSD}}</td>
                                            <td><span class="badge badge-success" >@lang('parametre.validated')</span></td>
                                            <td>{{\Carbon\Carbon::parse($rhsd->date)->format('d/m/y')}} @lang('parametre.at') 
                                                {{\Carbon\Carbon::parse($rhsd->date)->format('H:i')}} </td>
                                            @hasanyrole('d-p')
                                            @else
                                                <td class="mx-auto">
                                                    @can('insert-real')
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
                                                    @hasanyrole('s-a')
                                                        @can('delete-rhsds')
                                                            <a class=""  href="javascript:void(0)" data-id="{{ $rhsd->id }}" title="@lang('rhsd.supprimer')"
                                                            data-toggle="modal" data-target="#modalRhsdSUP">
                                                                <i class="text-danger fas fa-trash-alt"></i>
                                                            </a>
                                                        @endcan
                                                    @endhasanyrole
                                                </td>
                                            @endhasanyrole
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-text p-2">
                                <h4>{{$rows_count->goals}}/{{$rows_count->state_six}} @lang('parametre.objectifs atteints') </h4>
                            </div>
                        </div>  
                    @else
                        @include('partials.emptylist')
                    @endif
                @else
                    @include('partials.emptylist')
                @endcan
            </div>
            <div id="data_view" class="card mg-b-20 text-center">
                <div class="card-header">
                    <h3>@lang('parametre.vue graphique')</h3>
                </div>
                <div class="card-body">
                    @if($rh_v->count() > 0)
                    <div class="card-title">Réalisations de votre {{Auth::user()->domaine->type}}</div>
                    <div class="container mb-5">
                        <div class="row justify-content-center">
                            @foreach($rh_v as $rh)
                                <div class="col-4-md mb-2">
                                    <canvas width="400px" height="250px" id="donut_{{$loop->iteration}}" class="donut-pie"></canvas>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                        <div class="text-muted">@lang('rhsd.no valid data')</div>
                    @endif
                </div>
                @if($rh_sum->count() > 0)
                    <div class="card-footer ">
                        <div class="card-text">@lang('parametre.moyenne')</div>
                        <div class="row justify-content-center">
                            @foreach($rh_sum as $rh_year)
                                <div id="canvasDiv" class="col-4-md mb-2">
                            <!-- THIS EFD UP sizes !! -->
                                    <canvas width="400px" height="250px" id="donut_sum_{{$loop->iteration}}" class="donut-pie mb-5"></canvas>
                                    <h4>{{$rh_year->first()->ANNEESD}}</h4>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    {{--  --}}
                @endif
            </div>
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
    <!-- charts -->
    @can('view-province')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded',function(event) {
            var rh_v = {!! json_encode($rh_v) !!};
            var sum = {!! json_encode($sum)!!};
            if(rh_v.length > 0){
                for (i = 0; i < rh_v.length ; i++) {
                    var real=0, obj=0;
                    var title = rh_v[i].qualite.qualite;
                    real = rh_v[i].REALISATIONSD;
                    obj = rh_v[i].OBJECTIFSD
                    var ecart = real - obj;
                    if(ecart < 0) {
                        var xvals = ["Ecart", "Realisation"];
                        var yvals = [ecart, rh_v[i].REALISATIONSD];
                        var cols = ["#EA3232", "#2b5797"];
                    } else{
                        var xvals = ["Objectif", "Ecart"];
                        var yvals = [rh_v[i].OBJECTIFSD, ecart*-1];
                        var cols = ["#2b5797", "#32EA8E"];
                    }
                    
                    new Chart(document.getElementById("donut_"+[(i+1)]), {
                        type: "doughnut",
                        data:{
                            labels: xvals,
                            datasets: [{
                                backgroundColor: cols,
                                data: yvals
                            }]
                        },
                        options:{
                            title:{
                                display: true,
                                text: title
                            }
                        }
                    });
                }
                if(sum[0].length == sum[1].length && sum[1].length > 0){ //sum[0]:REAL,sum[1]:OBJ
                    var length = sum[0].length;
                    for(j=0; j<length; j++){
                        var percent = ((sum[0][j]/sum[1][j])*100).toFixed(2)
                        title = ''+percent+'%';
                        if(sum[0][j] < sum[1][j]) {
                            var xvals = ["Ecart", "Realisation"];
                            var ecart = sum[0][j]- sum[1][j];
                            var yvals = [ecart, sum[0][j]];
                            var cols = ["#EA3232", "#2b5797"];
                        } else{
                            var xvals = ["Objectif", "Ecart"];
                            var ecart = sum[1][j] - sum[0][j];
                            var yvals = [sum[1][j], ecart*-1];
                            var cols = ["#2b5797", "#32EA8E"];
                        }
                        new Chart(document.getElementById("donut_sum_"+[(j+1)]), {
                            type: "pie",
                            data:{
                                labels: xvals,
                                datasets: [{
                                    backgroundColor: cols,
                                    data: yvals
                                }]
                            },
                            options:{
                                title: {
                                    display: true,
                                    text: title
                                }
                            }
                        }); 
                    }
                }
            } else{
                var container = document.getElementById("data_view");
                container.hide();
            }
        });
        
        </script>
    @endcan
    @can('view-region')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded',function(event) {
            var rh_v = {!! json_encode($rh_v) !!};
            var sum = {!! json_encode($sum)!!};
            var t, d, domaine, id;
            if(rh_v.length > 0){
                for (i = 0; i < rh_v.length ; i++) {
                    t = (rh_v[i].domaine.t).toString();
                    d = (rh_v[i].domaine.domaine).toString()
                    id = (rh_v[i].domaine.id).toString()

                    $('#canvasDiv').append("<div><p>"+t+"-"+d+"</p></div");
                }
            }
            if(rh_v.length > 0){
                for (i = 0; i < rh_v.length ; i++) {
                    var real=0, obj=0;
                    var title = rh_v[i].qualite.qualite;
                    real = rh_v[i].REALISATIONSD;
                    obj = rh_v[i].OBJECTIFSD
                    var ecart = real - obj;
                    if(ecart < 0) {
                        var xvals = ["Ecart", "Réalisation"];
                        var yvals = [ecart, rh_v[i].REALISATIONSD];
                        var cols = ["#EA3232", "#2b5797"];
                    } else{
                        var xvals = ["Objectif", "Ecart"];
                        var yvals = [rh_v[i].OBJECTIFSD, ecart*-1];
                        var cols = ["#2b5797", "#32EA8E"];
                    }
                    
                    new Chart(document.getElementById("donut_"+[(i+1)]), {
                        type: "doughnut",
                        data:{
                            labels: xvals,
                            datasets: [{
                                backgroundColor: cols,
                                data: yvals
                            }]
                        },
                        options:{
                            title:{
                                display: true,
                                text: title
                            }
                        }
                    });
                }
                if(sum[0].length == sum[1].length && sum[1].length > 0){ //sum[0]:REAL,sum[1]:OBJ
                    var length = sum[0].length;
                    for(j=0; j<length; j++){
                        var percent = ((sum[0][j]/sum[1][j])*100).toFixed(2)
                        title = ''+percent+'%';
                        if(sum[0][j] < sum[1][j]) {
                            var xvals = ["Ecart", "Réalisation"];
                            var ecart = sum[0][j]- sum[1][j];
                            var yvals = [ecart, sum[0][j]];
                            var cols = ["#EA3232", "#2b5797"];
                        } else{
                            var xvals = ["Objectif", "Ecart"];
                            var ecart = sum[1][j] - sum[0][j];
                            var yvals = [sum[1][j], ecart*-1];
                            var cols = ["#2b5797", "#32EA8E"];
                        }
                        new Chart(document.getElementById("donut_sum_"+[(j+1)]), {
                            type: "pie",
                            data:{
                                labels: xvals,
                                datasets: [{
                                    backgroundColor: cols,
                                    data: yvals
                                }]
                            },
                            options:{
                                title: {
                                    display: true,
                                    text: title
                                }
                            }
                        }); 
                    }
                }
            } else{
                var container = document.getElementById("data_view");
                container.hide();
            }
        });
        
        </script>
    @endcan
    <!-- end charts -->
    <!-- Year Filter -->
    @can('dcsasd')

    @else
        <script>
            jQuery(document).ready(function(){
                $('#dateFilter').on("change", function(e){
                    e.preventDefault();
                    var _token = $('input[name="_token"]').val();
                    var annee = $(this).val();
                    window.location.href = "/indexyear/"+annee;
                });
            });
        </script>   
    @endcan
    <!-- end Year Filter -->
@endsection
