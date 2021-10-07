@extends('layouts.master')

@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">

@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">
                    @lang('uploads.title')
                </h4>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                @include('layouts.errors_success')
                <div class="card-header pb-0 ">
                    <div class="d-flex">
                        <div class="col-2 p-2 align-self-start">
                            <a href="{{url()->previous()}}" class="btn btn-primary" style="color: whitesmoke">
                                <i class="fas fa-arrow-left"></i> 
                                @lang('formone.retour') 
                            </a>
                        </div>
                        <div class="col-8 text-center align-self-center">
                            <h3> @lang('uploads.title') </h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div style="width:80%" class="table-responsive mx-auto">
                        <table id="example2" class="table key-buttons text-center" style="border: none">
                            <thead>
                                <tr>
                                    <th width="15%">@lang('uploads.date')</th>
                                    <th width="25%">@lang('uploads.desc')</th>
                                    <th width="25%">@lang('uploads.nom_doc')</th>
                                    <th width="7.5%">@lang('uploads.type')</th>
                                    <th width="19%">@lang('uploads.par')</th>
                                    <th width="7.5%">@lang('uploads.download')</th>
                                </tr>
                            </thead>
                            <tbody> 
                                @foreach ($files as $file)
                                    <tr>
                                        <td>
                                            {{date('d/m/Y', strtotime($file->created_at))}}
                                        </td>
                                        <td>
                                            @if (LaravelLocalization::getCurrentLocale() == 'fr')
                                                {{$file->titre_fr}}
                                            @else
                                                {{$file->titre_ar}}
                                            @endif
                                        </td>
                                        <td class="text-right">
                                           @foreach( explode('_', pathinfo($file->filename, PATHINFO_FILENAME)) as $words)
                                            @unless($loop->last)
                                                    {{$words}}
                                                @endunless
                                           @endforeach
                                        </td>
                                        <td class="text-left">
                                            <img width="25px" height="25px" src="{{URL::to('assets/img/extensions/'.pathinfo($file->filename, PATHINFO_EXTENSION ).'.png')}}"/>
                                        </td>
                                        <td>
                                            {{$file->user->name}}
                                        </td>
                                        <td>
                                            <a href="{{asset('storage/files/'.$file->filename)}}">
                                                <i class="fas fa-download"></i>
                                            </a> 
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(! count($files) > 0)
                    @include('partials.emptylist')
                @endif
            </div>
        </div>
    </div>

    <!-- Suppression -->
    <div class="modal" id="modalRhsdSUP">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">@lang('rhsd.modal supprimer')</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                                                                      type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="rhs/destroy" method="post">
                    @method('DELETE')
                    @csrf
                    <div class="modal-body">
                        <p>@lang('rhsd.modal validation supprision')</p><br>
                        <input type="hidden" name="rhsd_id" id="rhsd_id" value="">

                        <div style="text-align: center;">
                            <img width="50%" height="200px" src="{{asset('/img/ressource_humaine.svg')}}">

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('rhsd.modal validation close')</button>
                        <button type="submit" class="btn btn-danger">@lang('rhsd.modal validation confirm')</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Internal Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>

    <!--suppression -->
    <script>
        $('#modalRhsdSUP').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #rhsd_id').val(id);
        })
    </script>
    @can('view-select')
        @include('parametres.partials.filter_script')
    @endcan
@endsection