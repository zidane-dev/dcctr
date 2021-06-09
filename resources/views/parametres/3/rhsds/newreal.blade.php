@extends('layouts.master')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    @if(LaravelLocalization::getCurrentLocale() === "ar")
        <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    @else
        <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect.css') }}">

    @endif

@section('title')
    @lang('rhsd.edit rhsd')
@stop
@endsection

@include('parametres.partials_1.breadcrumb', ['sidebar'=> 'sidebar.rhsds', 'page' => 'rhsd.edit rhsd'])

@section('content')
    <!-- row -->
    <div class=" pb-0">
        <a href="{{route('rhs.index')}}" class="btn btn-primary" style="color: whitesmoke"><i class="fas fa-undo"></i> @lang('sidebar.return') </a>

    </div>
    <br>
    <div class="row">

        <div class="col-lg-12 col-md-12 ">

            <div class="card">
                @include('layouts.errors_success')
                <div class= "card-header">
                    <h3 class="text-center">Modification de l'objectif annuel  de cette qualite </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('rhs.store') }}" method="post" autocomplete="off">
                        @csrf
                        @method('POST')
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="inputName" class="control-label">@lang('rhsd.nom_axe')</label>
                                    <select name="axe" class="form-control SlectBox" readonly>
                                        @if(isset($axes) && $axes->count() > 0)
                                            @foreach($axes as $axe)
                                            @if($axe->id === $rhsd->id_axe)
                                                <option  selected="selected" value="{{$axe->id}}">{{$axe->axe}}</option>
                                            @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="inputName" class="control-label">@lang('rhsd.nom_domaine')</label>
                                    <select name="domaine" class="form-control SlectBox" readonly>
                                        @if(isset($domaines) && $domaines->count() > 0)
                                            @foreach($domaines as $domaine)
                                                @if($domaine->id === $rhsd->id_domaine)
                                                    <option  selected="selected"  value="{{$domaine->id}}">{{$domaine->domaine}} - {{$domaine->type}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="inputName" class="control-label">@lang('rhsd.nom_qualite')</label>
                                    <select name="qualite" class="form-control SlectBox" readonly>
                                        @if(isset($qualites) && $qualites->count() > 0)
                                            @foreach($qualites as $qualite)
                                                @if($rhsd->id_qualite === $qualite->id)
                                                    <option @if($qualite->id === $rhsd->id_qualite) selected="selected" @endif value="{{$qualite->id}}">{{$qualite->qualite}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="inputName" class="control-label">@lang('rhsd.annee')</label>
                                    <input type="text" class="form-control" id="amount1" name="annee" value="{{$rhsd->ANNEESD}}" readonly>
                                </div>
                            </div>
                            
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="inputName" class="control-label">@lang('rhsd.nom_objectif')</label>
                                    <input type="text" class="form-control" id="amount1" name="objectif" value="{{$rhsd->OBJECTIFSD}}" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="inputName" class="control-label">@lang('rhsd.nom_realisation')</label>
                                    <input type="text" class="form-control" id="amount1" name="realisation" value="">
                                </div>
                            </div>
                            
                        </div>
                        <br>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">@lang('formone.btn_add_edit')</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer"></div>
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
            dateFormat: 'yy-mm-dd'
        }).val();
    </script>

    <script>
        // calculate objectif et realisation and display in Ecart input
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
                        sum += rea - obj;
                        ecart += sum * (-1);
                        $("#ecart").val(ecart);
                    }
                }
                else{
                    $("#ecart").val('');
                }
            });
        });
    </script>
@endsection