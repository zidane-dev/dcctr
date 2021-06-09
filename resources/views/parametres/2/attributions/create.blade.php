@extends('layouts.master')

@section('title')
    @lang('attributions.add attribution')
@stop
@section('css')
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
                <h4 class="content-title mb-0 my-auto">@lang('sidebar.attributions')</h4>
                <span class="text-muted mt-1 tx-14 mr-2 mb-0">
                    /  @lang('attributions.add attribution') 
                </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- row -->
    <div class=" pb-0">
        <a href="{{route('attributions.index')}}" class="btn btn-primary" style="color: whitesmoke"><i class="fas fa-undo"></i> @lang('sidebar.return') </a>

    </div>
    <div class="row">
        <div class="col-lg-2 col-md-2"></div>

        <div class="col-lg-8 col-md-8">
            <div class="card">
                @include('layouts.errors_success')
                <div class="card-body">
                    <form action="{{route('attributions.store')}}" method="POST" autocomplete="off">
                        @csrf
                            <div class="form-group">
                                <label for="inputName" class="control-label">@lang('attributions.nom_attribution_fr')</label>
                                <input type="text" class="form-control" id="inputName" name="attribution_fr" dir="ltr"
                                       title="@lang('attributions.form.title')" value="{{old('attribution_fr')}}">
                            </div>

                            <div class="form-group">
                                <label for="inputName" class="control-label" >@lang('attributions.nom_attribution_ar')</label>
                                <input type="text" class="form-control" id="inputName" name="attribution_ar" dir="rtl"
                                       title="@lang('attributions.form.title')" value="{{old('attribution_ar')}}">
                            </div>

                            <div class="form-group">
                                <label for="inputName" class="control-label">@lang('attributions.nom_secteur')</label>
                                <select name="secteur_id" class="form-control SlectBox">
                                    <option value="" selected disabled>
                                        @lang('attributions.form select')
                                    </option>

                                    @foreach($secteurs as $secteur)
                                        <option value="{{$secteur->id}}" {{ (collect(old('secteur'))->contains($secteur->id)) ? 'selected':'' }}>
                                            {{$secteur->name}}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                           <br>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">@lang('formone.btn_add_edit')</button>
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
    <!-- Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>

    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <!-- Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <!--Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!-- Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!-- spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
@endsection

