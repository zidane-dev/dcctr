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
    @lang('objectifs.edit objectif')
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">@lang('sidebar.objectifs')</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                     @lang('objectifs.edit objectif') </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class=" pb-0">
        <a href="{{route('objectifs.index')}}" class="btn btn-primary" style="color: whitesmoke"><i class="fas fa-undo"></i> @lang('sidebar.return') </a>

    </div>
    <div class="row">
        <div class="col-lg-2 col-md-2"></div>

        <div class="col-lg-8 col-md-8">
            <div class="card">
                @include('layouts.errors_success')
                <div class="card-body">
                    <form action="{{route('objectifs.update',$objectif->id)}}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')


                            <div class="form-group">
                                <label for="inputName" class="control-label">@lang('objectifs.nom_objectif_fr')</label>
                                <input type="text" class="form-control" id="inputName" name="objectif_fr" dir="ltr"
                                        value="{{$objectif->objectif_fr}}">
                            </div>

                        <div class="form-group">
                            <label for="inputName" class="control-label">@lang('objectifs.nom_objectif_ar')</label>
                            <input type="text" class="form-control" id="inputName" name="objectif_ar" dir="rtl"
                                   value="{{$objectif->objectif_ar}}">
                        </div>

                        <div class="form-group">
                                <label for="inputName" class="control-label">@lang('objectifs.nom_secteur')</label>
                                <select name="secteur_id" class="form-control SlectBox">
                                    <option value=""   selected disabled>@lang('objectifs.form select')</option>
                                    @foreach($secteurs as $secteur)
                                        <option @if($secteur->id === $objectif->secteur_id) selected="selected" @endif value="{{$secteur->id}}">
                                            {{$secteur->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                           <br>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">@lang('objectifs.btn_add_edit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2"></div>
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

