@extends('layouts.master')

@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    @if(LaravelLocalization::getCurrentLocale() === "ar")
        <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    @else
        <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect.css') }}">
    @endif
@endsection

@section('title')
    @lang('dpcis.add')
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">@lang('sidebar.dpcis')</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                     @lang('dpcis.add') </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <div class=" pb-0">
        <a href="{{route('dpcis.index')}}" class="btn btn-primary" style="color: whitesmoke"><i class="fas fa-undo"></i> @lang('sidebar.return') </a>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-1 col-md-1"></div>

        <div class="col-lg-9 col-md-9">
            <div class="card">
                @include('layouts.errors_success')
                <div class="card-body">
                    <form action="{{route('dpcis.store')}}" method="POST" autocomplete="off">
                        @csrf

                            <div class="form-group">
                                <label for="inputName" class="control-label m-2">@lang('dpcis.nom_province_fr')</label>
                                <input type="text" class="form-control" id="inputName" name="champ_fr" dir="ltr"
                                       title="@lang('dpcis.form.title')" value="{{old('domaine_fr')}}">
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="control-label m-2">@lang('dpcis.nom_province_ar')</label>
                                <input type="text" class="form-control" id="inputName" name="champ_ar" dir="rtl"
                                       title="@lang('dpcis.form.title')" value="{{old('domaine_ar')}}">
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6"> 
                                    <div id="regdd" class="form-group">
                                        <label for="inputName" class="control-label m-2">@lang('drs.nom')</label>
                                        <select name="region" class="form-control SlectBox">
                                            <option value="null"  selected disabled>@lang('dpcis.form select')</option>
                                            @foreach($regions as $region)
                                                <option value="{{$region->id}}" {{ (collect(old('region'))->contains($region->id)) ? 'selected':'' }}>{{$region->region}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3"> 
                                    <div class="form-group">
                                        <label for="inputName" class="control-label m-2">@lang('dpcis.type')</label>
                                        <select id="regpro" name="type" class="form-control SlectBox" title="@lang('dpcis.form select type')" >
                                            <option value="P" selected>Province</option>
                                            <option value="R">Region</option>
                                            <option value="C">Centrale</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3"> 
                                    <div class="form-group">
                                        <label for="inputName" class="control-label m-2">@lang('dpcis.niveau')</label>
                                        <select id="regpro" name="type" class="form-control SlectBox" title="@lang('dpcis.form select type')" >
                                            <option value="null"  selected disabled>@lang('dpcis.form select')</option>
                                            @foreach($levels as $lvl)
                                                <option value="{{$lvl->id}}" {{ (collect(old('region'))->contains($lvl->id)) ? 'selected':'' }}> {{$lvl->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <br>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">@lang('formone.btn_add_edit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-1 col-md-1"></div>
    </div>

    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->

    {{-- <!-- Hide and Show Dropdown -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#regdd").hide();
            console.log('aa');
            $('#regpro').change (function (e) {
                $(this).find("option:selected").each(function(){
                    var optionValue = $(this).attr("value");
                    if(optionValue == 'R'){
                        $("#regdd").show();
                    }else{
                        $("#regdd").hide();
                    }
                })
            }).change();
        });
    </script> --}}
@endsection

@section('js')  
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>

    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
@endsection

