@can('create-'.$class)
    @section('content')
        <!-- row -->
        <div class=" pb-0">
            <a href="{{route(''.$class.'.index')}}" class="btn btn-primary" style="color: whitesmoke">
                <i class="fas fa-undo"></i> 
                @lang('sidebar.return') 
            </a>

        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2"></div>

            <div class="col-lg-8 col-md-8">
                <div class="card">
                    @include('layouts.errors_success')
                    <div class="card-body">
                        <form action="{{route(''.$class.'.store')}}" method="POST" autocomplete="off">
                            @csrf
                                <div class="form-group">
                                    <label for="inputName" class="control-label">@lang($class.'.champ_fr')</label>
                                    <input type="text" class="form-control" id="inputName" name="champ_fr" dir="ltr"
                                        title="@lang($class.'.form.title')" value="{{old('champ_fr')}}">
                                        {{-- WHAT IS {{OLD}} ? --}}
                                </div>

                                <div class="form-group">
                                    <label for="inputName" class="control-label">@lang($class.'.champ_ar')</label>
                                    <input type="text" class="form-control" id="inputName" name="champ_ar" dir="rtl"
                                        title="@lang($class.'.form.title')" value="{{old('champ_ar')}}">
                                        {{-- WHAT IS {{OLD}} ? --}}
                                </div>

                            <br>
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
@endcan