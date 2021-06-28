@extends('layouts.master')

@section('title')
    @lang('rhsd.add obj')
@endsection
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    @if(LaravelLocalization::getCurrentLocale() === "ar")
        <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    @else
        <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect.css') }}">
    @endif
@endsection

@include('parametres.partials_1.breadcrumb', ['sidebar'=> 'sidebar.rhsds', 'page' => 'rhsd.add obj'])

@section('content')
    <!-- row -->
    <div class=" pb-0">
        <a href="{{route('validation.rhsds')}}" class="btn btn-primary" style="color: whitesmoke">
            <i class="fas fa-undo"></i> 
            @lang('sidebar.return') 
        </a>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                @include('layouts.errors_success')
                <div class="card-body">
                    <form action="{{ route('rhs.store') }}" method="post" enctype="multipart/form-data"
                          autocomplete="off">
                        @csrf
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="inputName" class="control-label">@lang('parametre.nom_axe')</label>
                                    <select name="axe" class="form-control SlectBox">
                                        @if(isset($axes) && $axes->count() > 0)
                                        @foreach($axes as $axe)
                                            @if($axe->id === 3)
                                                <option value="3" selected readonly> {{$axe->axes}}</option>
                                            @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="inputName" class="control-label">@lang('parametre.nom_domaine')</label>
                                    <select id="selectDomaine" name="domaine" class="form-control SlectBox" readonly>
                                        <option value=""   selected disabled>@lang('rhsd.choi_domaine')</option>
                                        @if(isset($domaines) && $domaines->count() > 0)
                                            @foreach($domaines as $domaine)
                                            @if($domaine->id === Auth::user()->domaine_id)
                                                <option selected="selected"  value="{{$domaine->id}}" {{ (collect(old('domaine'))->contains($domaine->id)) ? 'selected':'' }}>{{$domaine->domaine}} - {{$domaine->type}}.</option>
                                            @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="inputName" class="control-label">@lang('rhsd.nom_qualite')</label>
                                    <select id="selectQualite" name="qualite" class="form-control SlectBox" >
                                        <option value="" selected disabled> @lang('rhsd.choi_qualite')</option>
                                        @if(isset($qualites) && $qualites->count() > 0)
                                            @foreach($qualites as $qualite)
                                                <option value="{{$qualite->id}}" {{ (collect(old('qualite'))->contains($qualite->id)) ? 'selected':'' }}>{{$qualite->qualite}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label>@lang('parametre.annee')</label>
                                            <input class="form-control fc-datepicker" name="date_creation" id="date_creation" placeholder="YYYY-MM-DD" value="{{date('Y')}}" type="text" required>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="inputName" class="control-label">@lang('parametre.nom_objectif')</label>
                                            <input type="text" class="form-control" id="amount1" name="objectif" value="{{old('objectif')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="inputName" class="control-label">@lang('parametre.realisation_initiale')</label>
                                            <input type="text" class="form-control"  name="realisation" id="amount2" value="0">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="inputName" class="control-label">@lang('parametre.nom_ecart')</label>
                                            <input type="text" class="form-control"  name="ecart" readonly id="ecart" value="{{old('ecart')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">@lang('parametre.submit_to_validation')</button>
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

    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>

    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>

    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy'
        }).val();
    </script>

    <script>  // calculate Ecart input
        $(document).ready(function(){
            $("input").keyup(function(){
                var obj = $("#amount1").val();
                var rea = $("#amount2").val();
                var sum = 0;
                var ecart = 0;
                
                if(obj != '' && rea != ''){
                    if( (obj > rea) || (obj == rea) ){
                        sum += obj - rea;
                        ecart += sum * (-1);

                        $("#ecart").val(ecart);
                }
                else if(rea > obj){
                    sum += obj - rea;
                    ecart += sum * (-1);
                    $("#ecart").val(ecart);
                }}
                else{
                    $("#ecart").val('');
                }
                if(isNaN(ecart)){$("#ecart").val('...');}
            });
        });
    </script> 
@endsection
