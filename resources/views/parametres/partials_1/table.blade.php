<!-- I need: $data and $class from Controller -->

@section('content')
    <!-- row -->
    <div class="row row-sm">

        <div class="col-xl-12">
            <div class="card mg-b-20">
                @include('layouts.errors_success')
                <div class="card-header pb-0">
                    @can('administrate')
                        <a href="/{{$class}}/create" class="btn btn-primary" style="color: whitesmoke">
                        <i class="fas fa-plus"></i> @lang($class.'.add') </a> <!-- ROUTE -->
                    @endcan
                </div>
                    @if($data->count() > 0)
                        <div class="card-body">
                            <!-- Table -->
                            <div class="table-responsive">
                                <table id="example1" class="table key-buttons text-md-nowrap">
                                    <thead>
                                        <tr>
                                            <th width="30xp" class="border-bottom-0">#</th>
                                            <th class="border-bottom-0">@lang($class.'.nom')</th>
                                            @if(Auth::user()->can('edit-'.$class) || Auth::user()->can('delete-'.$class))
                                            <th width="150xp" class="border-bottom-0">@lang('formone.action')</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1 ?>
                                    @forelse($data as $dt) 
                                        <tr>
                                            <td class="text-center">{{$i++}}</td>
                                            <td>{{$dt->name}}</td>
                                            <td class="text-center">
                                                @can('administrate')
                                                <a class="btn btn-sm btn-info" href="{{$class}}/{{$dt->id}}/edit" title="@lang('formone.title edit')">
                                                    <i class="las la-pen"></i>    
                                                </a>
                                                @endcan
                                                @can('administrate')
                                                <a class="modal-effect btn btn-sm btn-danger"   
                                                    title="@lang('formone.title supprimer')"
                                                    data-effect="effect-scale" 
                                                    data-id="{{ $dt->id }}"
                                                    data-dt_name="{{ $dt->name }}" data-toggle="modal" 
                                                    href="#supprimer_data" >
                                                    <i class="las la-trash"></i>
                                                </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div> 
                    @else
                    <div>
                        <img width="100%" height="300px" src="{{asset('assets/img/svgicons/no-data.svg')}}">
                    </div>
                    @endif
            </div>
        </div>
    </div>

    <div class="modal" id="supprimer_data">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">@lang($class.'.modal supprimer')</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{$class}}/destroy" method="post"> <!-- ROUTE -->
                    @method('DELETE')
                    @csrf
                    <div class="modal-body">
                        <p>@lang('formone.modal validation supprision')</p><br>
                        <input type="hidden" name="id" id="id" value="">
                        <input class="form-control" name="data_name" id="data_name" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('formone.modal validation close')</button>
                        <button type="submit" class="btn btn-danger">@lang('formone.modal validation confirm')</button>
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

    <script>
        $('#supprimer_data').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var dt = button.data('dt_name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #data_name').val(dt);
        })
    </script>
    
@endsection
