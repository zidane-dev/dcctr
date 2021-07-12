@extends('layouts.master')

@section('css')
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('title')
    @lang('uploads.add')
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">
                    @lang('uploads.add')
                </h4>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                @include('layouts.errors_success')
                <div class="card-header pb-0 ">
                    <div class="d-flex ">
                        <div class="col-2 p-2 align-self-start">
                            <a href="{{url()->previous()}}" class="btn btn-primary" style="color: whitesmoke">
                                <i class="fas fa-arrow-left"></i> 
                                @lang('formone.retour') 
                            </a>
                        </div>
                        <div class="col-8 text-center align-self-center">
                            <h3>
                                @lang('uploads.new')
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="form" class="container text-center ">
                        <form action="{{route('documents.store')}}" enctype='multipart/form-data' method="POST">
                            @csrf
                            <div class="form-group col-xl-6 col-md-12 col-sm-12 mx-auto" >
                                <label class="control-label col-sm-3 col-xs-12" for="champ_fr">
                                    @lang('uploads.titre_fr') <span class="required">*</span>
                                </label>
                                <div class="col-12" >
                                    <input type="input" name="champ_fr" class="w-100 form-input" required>
                                </div>
                            </div>
                            <div class="form-group col-xl-6 col-md-12 col-sm-12 mx-auto" >
                                <label class="control-label col-sm-3 col-xs-12" for="champ_ar">
                                    @lang('uploads.titre_ar') <span class="required">*</span>
                                </label>
                                <div class="col-12" >
                                    <input type="input" dir="rtl" name="champ_ar" class="w-100 form-input" required>
                                </div>
                            </div>
                            <div class="form-group col-xl-6 col-md-12 col-sm-12 mx-auto">
                                <label class="control-label col-sm-3 col-xs-12" for="name">
                                    @lang('uploads.document') <span class="required">*</span>
                                </label>
                                <div class="col-12 form-control h-100" style="border: 0" >
                                    <h5 class="mb-1" style="color: rgb(161, 161, 161)"> @lang('uploads.drag_drop') </h5>
                                    <div style=" height: 300px; border : 2px dashed rgb(184, 184, 184); border-radius: 25px">
                                        <input type="file" name="file" class="mx-auto" style="background: rgb(192, 241, 187); border-radius: 25px; width: 100%; height: 100%; padding: 25% 30%;">
                                        <h6 class="mt-1 font-weight-bold font-italic"> @lang('uploads.allowed') @lang('uploads.mimes') </h6>

                                    </div>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="text-center">
                                    <input class="btn btn-success m-2" type="submit" name="submit" value="@lang('uploads.submit')" >
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
@endsection