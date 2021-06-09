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
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">
                    @can('dcsasd')
                        {{$query[4]}} - {{$query[3]}}
                    @else
                        @lang('sidebar.rhsds') de la {{Auth::user()->domaine->type}} {{Auth::user()->domaine->domaine}}
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
                        @if($attproc_v->count() > 0)
                            @lang('axes.nom'): {{$attproc_v->first()->axe->axe}} <br/>
                            @lang('attproc.niveau') : {{$attproc_v->first()->niveau->niveau}}
                        @endif
                    </h3>
                    <div>
                        {{-- @can('supervise') --}}
                        <a href="{{url()->previous()}}" class="btn btn-primary" style="color: whitesmoke">
                            <i class="fas fa-arrow-left"></i> @lang('formone.retour') 
                        </a>
                        {{-- @endcan --}}
                        @can('create-rhsds')
                        <a href="{{route('rhs.create')}}" class="btn btn-primary" style="color: whitesmoke">
                            <i class="fas fa-plus"></i> @lang('rhsd.add') 
                        </a>
                        @endcan
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
                                    <label for="dateFilter" class="sr-only">@lang('rhsd.annee')</label>
                                    <select id="dateFilter" name="year" class="form-control SlectBox2 mx-2" >
                                        <option value="null" selected disabled> @lang('rhsd.annee')</option> {{-- this year by default --}}
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
                                <label for="dateFilter" class="control-label form-label mx-2">@lang('rhsd.annee')</label>
                                <select id="dateFilter" name="dateFilter" class="form-control SlectBox  mx-2" >
                                    <option value="" selected disabled> @lang('rhsd.annee')</option> {{-- this year by default --}}
                                    @if(isset($attproc_sum) && $attproc_sum->count() > 0)
                                        @foreach($attproc_sum as $attproc_year)
                                            <option value="{{$attproc_year->first()->ANNEEOBJ}}" {{ (collect(old('dateFilter'))->contains($attproc_year->first()->ANNEEOBJ)) ? 'selected':'' }}>
                                                {{$attproc_year->first()->ANNEEOBJ}}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </form>
                        @endif
                        <div class="card-text mt-2 px-5 py-2">
                            
                        </div>
                    @endcan
                </div>
                @can('list-rhsds')
                    @if($attproc_v->count() > 0)
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example2"  class="table key-buttons text-md-nowrap">
                                    <thead>
                                    <tr>
                                        <th width="25px" class="border-bottom-0">#</th>
                                        @can('view-region')
                                            <th class="border-bottom-0">@lang('dpcis.nom')</th>
                                        @endcan
                                        
                                        <th class="border-bottom-0">@lang('secteurs.nom')</th>
                                        <th class="border-bottom-0">@lang('attproc.attribution')</th>
                                        <th class="border-bottom-0">@lang('parametre.action')</th>
                                        <th class="border-bottom-0">@lang('attproc.anneeobj')</th>
                                        <th class="border-bottom-0">@lang('parametre.etat')</th>
                                        <th class="border-bottom-0">@lang('parametre.actions')</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($attproc_v as $attproc)
                                    @if($attproc->ETAT == 6)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            @can('view-region')
                                                <td>{{$attproc->domaine->t}} - {{$attproc->domaine->domaine}}</td>
                                            @endcan
                                            {{-- <td>{{\Carbon\Carbon::parse($attproc->date)->format('d/m/y h:m')}}</td> --}}
                                            {{-- <td>{{\Carbon\Carbon::now()->diffForHumans($attproc->updated_at)}}</td> --}}
                                            <td>{{$attproc->attribution->secteur->secteur}}</td>
                                            <td>{{$attproc->attribution->attribution}}</td>
                                            <td>{{$attproc->action->action}}</td>
                                            <td>{{$attproc->ANNEEOBJ}}</td>
                                            <td><span class="badge badge-success" >@lang('rhsd.validated')</span></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button aria-expanded="false" aria-haspopup="true"
                                                            class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                            type="button">
                                                                @lang('rhsd.actions')
                                                            <i class="fas fa-caret-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        @can('edit-rhsds')
                                                            <a class="dropdown-item" href="{{route('rhs.edit',$attproc->id)}}">
                                                                <i class=" fas fa-edit" style="color: #239a8a"></i>
                                                                &nbsp;&nbsp;@lang('rhsd.edit')
                                                            </a>
                                                        @endcan

                                                            <a class="dropdown-item" href="{{route('rhs.storereal',$attproc->id)}}">
                                                                <i class="fas fa-plus-circle"></i>
                                                                &nbsp;&nbsp;@lang('rhsd.ajoutSur')
                                                            </a>

                                                            <a class="dropdown-item" href="{{route('edit.rhsgoal',$attproc->id)}}">
                                                                <i class="fas fa-vote-yea"></i>
                                                                &nbsp;&nbsp;@lang('rhsd.changeObjectif')
                                                            </a>

                                                            <a class="dropdown-item" href="{{route('rhs.show',$attproc->id)}}">
                                                                <i class="fas fa-trending-up"></i>
                                                                &nbsp;&nbsp;@lang('rhsd.viewRh')
                                                            </a>
                                                        
                                                        @can('delete-rhsds')
                                                            <a class="dropdown-item"  href="javascript:void(0)" data-id="{{ $attproc->id }}"
                                                            data-toggle="modal" data-target="#modalRhsdSUP">
                                                                <i class="text-danger fas fa-trash-alt"></i>
                                                                &nbsp;&nbsp;@lang('rhsd.supprimer')
                                                            </a>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-text p-2">
                                <h4>
                                    {{-- {{$rows_count->goals}}/{{$rows_count->state_six}}  --}}
                                    {{$rows_count}} attributions validees ?
                                </h4>
                            </div>
                        </div>  
                    @else
                        @include('partials.emptylist')
                    @endif
                @else
                    @include('partials.emptylist')
                @endcan
            </div>

            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <h3 class="text-center">
                        @if($delegproc_v->count() > 0)
                            @lang('axes.nom'): {{$delegproc_v->first()->axe->axe}} <br/>
                            @lang('attproc.niveau') : {{$delegproc_v->first()->niveau->niveau}}
                        @endif
                    </h3>
                    <div>
                        {{-- @can('supervise') --}}
                        <a href="{{url()->previous()}}" class="btn btn-primary" style="color: whitesmoke">
                            <i class="fas fa-arrow-left"></i> @lang('formone.retour') 
                        </a>
                        {{-- @endcan --}}
                        @can('create-rhsds')
                        <a href="{{route('rhs.create')}}" class="btn btn-primary" style="color: whitesmoke">
                            <i class="fas fa-plus"></i> @lang('rhsd.add') 
                        </a>
                        @endcan
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
                                    <label for="dateFilter" class="sr-only">@lang('rhsd.annee')</label>
                                    <select id="dateFilter" name="year" class="form-control SlectBox2 mx-2" >
                                        <option value="null" selected disabled> @lang('rhsd.annee')</option> {{-- this year by default --}}
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
                                <label for="dateFilter" class="control-label form-label mx-2">@lang('rhsd.annee')</label>
                                <select id="dateFilter" name="dateFilter" class="form-control SlectBox  mx-2" >
                                    <option value="" selected disabled> @lang('rhsd.annee')</option> {{-- this year by default --}}
                                    @if(isset($delegproc_sum) && $delegproc_sum->count() > 0)
                                        @foreach($delegproc_sum as $delegproc_year)
                                            <option value="{{$delegproc_year->first()->ANNEEOBJ}}" {{ (collect(old('dateFilter'))->contains($delegproc_year->first()->ANNEEOBJ)) ? 'selected':'' }}>
                                                {{$delegproc_year->first()->ANNEEOBJ}}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </form>
                        @endif
                        <div class="card-text mt-2 px-5 py-2">
                            
                        </div>
                    @endcan
                </div>
                @can('list-rhsds')
                    @if($delegproc_v->count() > 0)
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example2"  class="table key-buttons text-md-nowrap">
                                    <thead>
                                    <tr>
                                        <th width="25px" class="border-bottom-0">#</th>
                                        @can('view-region')
                                            <th class="border-bottom-0">@lang('dpcis.nom')</th>
                                        @endcan
                                        
                                        <th class="border-bottom-0">@lang('secteurs.nom')</th>
                                        <th class="border-bottom-0">@lang('attproc.attribution')</th>
                                        <th class="border-bottom-0">@lang('parametre.action')</th>
                                        <th class="border-bottom-0">@lang('attproc.anneeobj')</th>
                                        <th class="border-bottom-0">@lang('parametre.etat')</th>
                                        <th class="border-bottom-0">@lang('parametre.actions')</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($delegproc_v as $delegproc)
                                    @if($delegproc->ETAT == 6)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            @can('view-region')
                                                <td>{{$delegproc->domaine->t}} - {{$delegproc->domaine->domaine}}</td>
                                            @endcan
                                            {{-- <td>{{\Carbon\Carbon::parse($delegproc->date)->format('d/m/y h:m')}}</td> --}}
                                            {{-- <td>{{\Carbon\Carbon::now()->diffForHumans($delegproc->updated_at)}}</td> --}}
                                            <td>{{$delegproc->attribution->secteur->secteur}}</td>
                                            <td>{{$delegproc->attribution->attribution}}</td>
                                            <td>{{$delegproc->action->action}}</td>
                                            <td>{{$delegproc->ANNEEOBJ}}</td>
                                            <td><span class="badge badge-success" >@lang('rhsd.validated')</span></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button aria-expanded="false" aria-haspopup="true"
                                                            class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                            type="button">
                                                                @lang('rhsd.actions')
                                                            <i class="fas fa-caret-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        @can('edit-rhsds')
                                                            <a class="dropdown-item" href="{{route('rhs.edit',$delegproc->id)}}">
                                                                <i class=" fas fa-edit" style="color: #239a8a"></i>
                                                                &nbsp;&nbsp;@lang('rhsd.edit')
                                                            </a>
                                                        @endcan

                                                            <a class="dropdown-item" href="{{route('rhs.storereal',$delegproc->id)}}">
                                                                <i class="fas fa-plus-circle"></i>
                                                                &nbsp;&nbsp;@lang('rhsd.ajoutSur')
                                                            </a>

                                                            <a class="dropdown-item" href="{{route('edit.rhsgoal',$delegproc->id)}}">
                                                                <i class="fas fa-vote-yea"></i>
                                                                &nbsp;&nbsp;@lang('rhsd.changeObjectif')
                                                            </a>

                                                            <a class="dropdown-item" href="{{route('rhs.show',$delegproc->id)}}">
                                                                <i class="fas fa-trending-up"></i>
                                                                &nbsp;&nbsp;@lang('rhsd.viewRh')
                                                            </a>
                                                        
                                                        @can('delete-rhsds')
                                                            <a class="dropdown-item"  href="javascript:void(0)" data-id="{{ $delegproc->id }}"
                                                            data-toggle="modal" data-target="#modalRhsdSUP">
                                                                <i class="text-danger fas fa-trash-alt"></i>
                                                                &nbsp;&nbsp;@lang('rhsd.supprimer')
                                                            </a>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-text p-2">
                                <h4>
                                    {{-- {{$rows_count->goals}}/{{$rows_count->state_six}}  --}}
                                    {{$rows_count}} attributions validees ?
                                </h4>
                            </div>
                        </div>  
                    @else
                        @include('partials.emptylist')
                    @endif
                @else
                    @include('partials.emptylist')
                @endcan
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
                            <img width="45%" height="200px" src="{{asset('/img/ressource_humaine.svg')}}">

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
    
    <!-- Year Filter -->
    
    @can('dcsasd')
        <script type="text/javascript">
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).ready(function(){
                var provinceSel = $('#provDiv');
                var regionSel = $('#regDiv');
                const elementRegion = document.querySelector('#region');
                const elementType = document.querySelector('#type');
                const elementProvince = document.querySelector('#selectProvince');
                const e = new Event("change");
                
                var query = {!! json_encode($query) !!}
                if(query){
                    console.log(query[0],query[1],query[2]);
                    console.log('province','region','type');
                    elementRegion.value = query[1];
                    elementRegion.dispatchEvent(e);
                    ajaxCall();
                }

                $('#type').on('change', function(e){
                $('#dateDiv').hide();
                $('#submit').hide();
                provinceSel.hide();
                regionSel.hide();
                    var type = e.target.value;
                    $('select[name="province"]').empty();
                    if(type==1){
                        regionSel.show();
                        provinceSel.hide();
                    }else if(type==2){
                        regionSel.hide();
                        elementRegion.value = 13;
                        elementRegion.dispatchEvent(e);
                    }
                })
                $('#region').on('change', function(e){
                    var cat_id = e.target.value;
                    ajaxCall();
                });
                $('#selectProvince').on('change', function(e){
                    $('#dateDiv').show();
                    $('#submit').show();
                })
            });
            function ajaxCall(){
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
            }
        </script>
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
@endsection
