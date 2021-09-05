@extends('layouts.master')

@section('title')
    @lang('attprocs.add')
@endsection
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    @if(LaravelLocalization::getCurrentLocale() === "ar")
        <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    @else
        <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect.css') }}">
    @endif
    <style type='text/css'>
        /* Style to hide Dates / Months */
        .ui-datepicker-calendar,.ui-datepicker-month { display: none; } 
        section{
            padding-top: 100px;
        }
        .form-section{
            padding-left: 15px;
            display: none;
        }
        #advanced_domaines{
            padding-top: 15px;
            display: none;
        }
        .form-section.current{
            display:inherit;
        }
        .btn-info, .btn-primary{
            margin-top: 10px;
        }
        .btn{
            margin:5px;
        }
        .parsley-error-list{
            margin: 2px 0 3px;
            padding: 0;
            list-style-type: none;
            color: red;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap4.css" integrity="sha512-WJ1jnnij6g+LY1YfSmPDGxY0j2Cq/I6PPA7/s4QJ/5sRca5ypbHhFF+Nam0TGfvpacrw9F0OGeZa0ROdNAsaEQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap4.min.css" integrity="sha512-MMojOrCQrqLg4Iarid2YMYyZ7pzjPeXKRvhW9nZqLo6kPBBTuvNET9DBVWptAo/Q20Fy11EIHM5ig4WlIrJfQw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
@endsection

@include('parametres.partials_1.breadcrumb', ['sidebar'=> 'sidebar.att_procs', 'page' => 'att_procs.add'])

@section('content')
    
    <!-- row -->
    <div class=" pb-0">
        <a href="{{redirect()->back()}}" class="btn btn-primary" style="color: whitesmoke">
            <i class="fas fa-undo"></i> 
            @lang('sidebar.return') 
        </a>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                @include('layouts.errors_success')
                <div class="card-header text-center">
                    <h2>@lang('parametre.new_attribution')</h2>
                </div>
                <div class="card-body mx-auto">
                    <form class="attproc-form" action="{{ route('attprocs.store') }}" method="POST" enctype="multipart/form-data"
                          autocomplete="off">
                        @csrf
                        <div class="form-section">
                            <div class="col-md-12 ">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-7 mx-2">
                                        <div class="form-group">
                                            <label for="attribution" class="control-label">@lang('att_procs.type-attr')</label> <!-- lang -->
                                            <select id="type_attr" name="type" class="form-control SelectBox" required>
                                                <option value=""   selected disabled>@lang('att_procs.type-attr')</option> 
                                                <option value="T">@lang('att_procs.transfert')</option> <!-- lang -->
                                                <option value="D">@lang('att_procs.delegation')</option>  <!-- lang -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-7 mx-2">
                                        <div class="form-group">
                                            <label for="domaine" class="control-label">@lang('att_procs.type-dom')</label> <!-- lang -->
                                            <select id="selectDomaine" name="type_domaine" class="form-control SelectBox" required>
                                                <option value=""   selected disabled>@lang('rhsd.choi_domaine')</option> 
                                                <option value="R" {{ (collect(old('domaine'))->contains('R')) ? 'selected':'' }}>
                                                    @lang('regions.nom')
                                                </option>
                                                <option value="P" {{ (collect(old('domaine'))->contains('P')) ? 'selected':'' }}>
                                                    @lang('dpcis.province')
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-7 mx-2">
                                        <div class="form-group">
                                            <label for="maturite" class="control-label">@lang('att_procs.maturite')</label> <!-- lang -->
                                            <select id="selectMaturite" name="maturite" class="form-control SelectBox" required>
                                                <option value="" selected> @lang('att_procs.choix-maturite')</option>
                                                <option value="M" {{ (collect(old('maturite'))->contains('R')) ? 'selected':'' }}>
                                                    @lang('att_procs.mature')
                                                </option>
                                                <option value="D" {{ (collect(old('maturite'))->contains('R')) ? 'selected':'' }}>
                                                    @lang('att_procs.en-dev')
                                                </option>
                                                <option value="E" {{ (collect(old('maturite'))->contains('R')) ? 'selected':'' }}>
                                                    @lang('att_procs.en-emer')
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-section">
                            <div class="col-md-12">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-7 mx-2">
                                        <div class="form-group">
                                            <label>@lang('parametre.annee')</label>
                                            <input class="form-control yearpicker" name="date_creation" id="date_creation" placeholder="YYYY" type="text" required>
                                        </div>
                                    </div>
                                    <div class="col-md-7 mx-2">
                                        <div id="secDiv" class="form-group">
                                            <label for="secteur" class="control-label">@lang('secteurs.nom')</label>
                                            <select id="selectSecteur" name="secteur" class="form-control SelectBox" required>
                                                <option value="" selected disabled> @lang('att_procs.choix-secteur')</option>
                                                @foreach($secteurs as $secteur)
                                                <option value="{{$secteur->id}}">{{$secteur->secteur_fr}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div id="attDiv" class="col-md-7 mx-2">
                                        <div class="form-group">
                                            <label for="attribution" class="control-label">@lang('attributions.nom')</label>
                                            <select id="selectAttribution" name="attribution" class="form-control SelectBox" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="actDiv" class="col-md-7 mx-2">
                                        <div class="form-group">
                                            <label for="action" class="control-label">@lang('actions.nom')</label>
                                            <select id="selectAction" name="action" class="form-control SelectBox" required>
                                                <option value="" selected disabled aria-multiline="true"> @lang('att_procs.choix-action')</option>
                                                @foreach($actions as $action)
                                                <option value="{{$action->id}}">{{$action->action_fr}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row d-flex justify-content-center mt-1 col-12">
                                <div class="col-md-12">
                                    <span id="number_dpcis"> - </span>  @lang('att_procs.dpci_affected')
                                    <button id="adv_select" type="button" class="btn btn-secondary float-right">@lang('parametre.selec-advanced')>></button>
                                </div>
                                <div id="advanced_domaines" class="row d-row-flex justify-content-center col-md-10" style="background: #dde2ef;">
                                    <div class="row mb-1 col-12" id="domaines_list">
                                    </div>
                                    <div class="row d-flex justify-content-center mt-1 col-12">
                                        <button type="button" id="cancel_advanced" class="btn btn-info">@lang('parametre.cancel')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-navigation">
                            <div class="row d-flex justify-content-center mt-5">
                                <button type="button" class="previous btn btn-info float-left">@lang('parametre.previous')</button>
                                <button type="button" class="next btn btn-info float-right">@lang('parametre.next')</button>
                                <button type="submit" class="btn btn-success">@lang('parametre.submit_to_validation')</button>
                            </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js" integrity="sha512-pF+DNRwavWMukUv/LyzDyDMn8U2uvqYQdJN0Zvilr6DDo/56xPDZdDoyPDYZRSL4aOKO/FGKXTpzDyQJ8je8Qw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js" integrity="sha512-eyHL1atYNycXNXZMDndxrDhNAegH2BDWt1TmkXJPoGf1WLlNYt08CSjkqF5lnCRmdm3IrkHid8s2jOUY4NIZVQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $('#selectAction').selectize();
        var date = $('.yearpicker').datepicker({
            changeMonth: false,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'yy',
            viewMode: 'yy',
            onClose: function(dateText, inst) { 
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, 0, 1));
        }});
    </script>

    <script>
        var $sections = $('.form-section');
        function navigateTo(index){
            $sections.removeClass('current').eq(index).addClass('current');
            $('.form-navigation .previous').toggle(index>0);
            var atTheEnd = index >= $sections.length - 1;
            $('.form-navigation .next').toggle(!atTheEnd);
            $('.form-navigation [type=submit]').toggle(atTheEnd);
            if(atTheEnd){
                var domaine = $('#selectDomaine').val();
                var maturite = $('#selectMaturite').val();
                $.ajax({
                    url:  "{{route('attprocs.store_recap')}}",
                    type: "GET",
                    data: {
                        domaine: domaine,
                        maturite: maturite,
                    },
                    success : function(response){
                        console.log(response);
                        $('#number_dpcis').html(response['domaine_list'].length);
                        for (let i in response['domaine_list']){
                            if(response['locale'] == 'fr'){
                                $('#domaines_list').append('<div class="col-md-4 col-sm-6 my-2">'    +
                                                            '<input type="checkbox" name="domaine[]" value="'+response['domaine_list'][i].id+'" checked>'+
                                                            '<label for="domaine[]">'+response['domaine_list'][i].domaine_fr  +'</label>'+
                                                            '</div>')
                            }else if(response['locale'] == 'ar'){
                                $('#domaines_list').append('<div class="col-md-4 col-sm-6 my-2">'    +
                                                            '<input type="checkbox" name="domaine[]" value="'+response['domaine_list'][i].id+'" checked>'+
                                                            '<label for="domaine[]">'+response['domaine_list'][i].domaine_ar  +'</label>'+
                                                            '</div>')
                            }
                        }
                    }
                });
                $('#domaines_list').on('change', ':checkbox', function(){
                    var number_checked = $('#domaines_list').find('input[type=checkbox]:checked').length;
                    $('#number_dpcis').html(number_checked);
                });
            }
        }
        function curIndex(){
            return $sections.index($sections.filter('.current'));
        }
        $('.form-navigation .previous').click(function(){
            navigateTo(curIndex()-1);
        });
        $('.form-navigation .next').click(function(){
            $('.attproc-form').parsley().whenValidate({
                group: 'block-' + curIndex()
            }).done(function(){
                navigateTo(curIndex()+1)
            });
        });
        $sections.each(function(index, section){
            $(section).find(':input').attr('data-parsley-group', 'block-' + index)
        });
        navigateTo(0);
    </script>
    <script>
        $(document).ready(function(){
            $('#adv_select').click(function(){
                $('#advanced_domaines').toggle();
            });
            $('#cancel_advanced').click(function(){
                $('#domaines_list').find('input[type=checkbox]').prop('checked', true);
                $('#number_dpcis').html($('#domaines_list').find('input[type=checkbox]:checked').length);
                $('#advanced_domaines').hide();
            });
            $('.form-navigation').find('button[type=submit]').click(function(){
                $('#selectSecteur').prop('disabled', true);
            })
        });
    </script>

    @include('parametres.partials.new_attproc_script')

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
