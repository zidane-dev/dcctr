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
    @lang('depenses.edit')
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">
                    @lang('sidebar.depenses')
                </h4>
                <span class="text-muted mt-1 tx-14 mr-2 mb-0">
                    / @lang('depenses.edit') 
                </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- row -->
    <div class=" pb-0">
        <a href="{{route('depenses.index')}}" class="btn btn-primary" style="color: whitesmoke"><i class="fas fa-undo"></i> @lang('sidebar.return') </a>

    </div>
    <div class="row">
        <div class="col-lg-2 col-md-2"></div>

        <div class="col-lg-8 col-md-8">
            <div class="card">
                @include('layouts.errors_success')
                <div class="card-body ">
                    <form action="{{route('depenses.update',$depense->id)}}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="inputName" class="control-label">@lang('depenses.nom_depense_fr')</label>
                            <input type="text" class="form-control" id="inputName" name="champ_fr" dir="ltr"
                                   title="@lang('depenses.form.title')" value="{{$depense->depense_fr}}">
                        </div>

                        <div class="form-group">
                            <label for="inputName" class="control-label">@lang('depenses.nom_depense_ar')</label>
                            <input type="text" class="form-control" id="inputName" name="champ_ar" dir="rtl"
                                   title="@lang('depenses.form.title')" value="{{$depense->depense_ar}}">
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="col-lg-9 col-md-9"> 
                                <div id="regdd" class="form-group">
                                    <label for="inputName" class="control-label m-2">@lang('depenses.ressource')</label>
                                    <select name="ressource" class="form-control SlectBox">
                                        <option value="null"  selected disabled> @lang('depenses.form select') </option>
                                        @foreach($ressources as $ressource)
                                            <option @if($ressource->id === $depense->id_ressource) selected="selected" @endif value="{{$ressource->id}}">
                                            {{$ressource->ressource}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">@lang('formone.btn_add_edit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
@endsection