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
    @lang('depenses.add')
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">@lang('sidebar.depenses')</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                     @lang('depenses.add') </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <div class=" pb-0">
        <a href="{{route('depenses.index')}}" class="btn btn-primary" style="color: whitesmoke"><i class="fas fa-undo"></i> @lang('sidebar.return') </a>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-1 col-md-1"></div>

        <div class="col-lg-9 col-md-9">
            <div class="card">
                @include('layouts.errors_success')
                <div class="card-body">
                    <form action="{{route('depenses.store')}}" method="POST" autocomplete="off">
                        @csrf
                            <div class="form-group">
                                <label for="inputName" class="control-label m-2">@lang('depenses.nom_depense_fr')</label>
                                <input type="text" class="form-control" id="inputName" name="champ_fr" dir="ltr"
                                       title="@lang('depenses.form.title')" value="{{old('champ_fr')}}">
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="control-label m-2">@lang('depenses.nom_depense_ar')</label>
                                <input type="text" class="form-control" id="inputName" name="champ_ar" dir="rtl"
                                       title="@lang('depenses.form.title')" value="{{old('champ_ar')}}">
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6"> 
                                    <div id="regdd" class="form-group">
                                        <label for="inputName" class="control-label m-2">@lang('drs.nom')</label>
                                        <select name="ressource" class="form-control SlectBox">
                                            <option value="null"  selected disabled>@lang('depenses.form select')</option>
                                            @foreach($ressources as $ressource)
                                                <option value="{{$ressource->id}}" {{ (collect(old('ressource'))->contains($ressource->id)) ? 'selected':'' }}>{{$ressource->ressource}}</option>
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

