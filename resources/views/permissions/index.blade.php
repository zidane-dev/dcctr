@extends('layouts.master')
@section('title') @lang('sidebar.liste secteur')  @endsection
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
                    @lang('sidebar.users')
                </h4>
                <span class="text-muted mt-1 tx-14 mr-2 mb-0">
                    /  @lang('sidebar.user_roles')
                </span>
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
                
                <div class="card-header pb-0">
                    <div class="text-center"><h2>Permissions by role</h2></div>
                    <a href="" class="btn btn-primary" style="color: whitesmoke">
                        <i class="fas fa-plus"></i> 
                        Nouvelle permission ?
                    </a>
                    
                </div>
                @if($roles->count() > 0 && $permissions->count() > 0)
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example2" class="table key-buttons text-md-nowrap">
                                <thead>
                                <tr>
                                    <th width="15px" class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">Role</th>
                                    <th class="border-bottom-0">Permissions</th>
                                    <th width="20px" class="border-bottom-0">Count</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1 ?>
                                @forelse($roles as $role)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td class="text-center">
                                            <span class="badge badge-success">{{$role->name}}</span>
                                        </td>
                                        <td>
                                            @forelse ( $role->permissions as $permission )
                                                
                                                @if (! $loop->last)
                                                    <span class="badge badge-light">
                                                        {{$permission->name}}
                                                    </span> ,
                                                @else
                                                    <span class="badge badge-light">
                                                        {{$permission->name}}
                                                    </span>
                                                @endif
                                                
                                            @empty
                                            <span class="badge badge-danger">none</span>
                                            @endforelse
                                        </td>
                                        <td>{{$role->permissions->count()}}</td>
                                    </tr>
                                @empty
                                    
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
            <div class="card mg-b-20">
                @include('layouts.errors_success')
                <div class="card-header pb-0">
                    <div class="text-center"><h2>Roles & Permissions</h2></div>
                    <a href="{{route('secteurs.create')}}" class="btn btn-primary" style="color: whitesmoke">
                        <i class="fas fa-plus"></i>
                        Nouveau role ?
                    </a>
                </div>
                
                    <div class="card-body">
                        <!-- Table -->
                        <div class="table-responsive">
                            <table id="example1" class="table key-buttons text-md-nowrap">
                                <thead>
                                <tr>
                                    <th width="15px" class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">Role</th>
                                    <th width="100px" class="border-bottom-0">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1 ?>
                                @forelse($roles as $role)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$role->name}}</td>
                                        <td>
                                            {{-- href="{{route('roles.edit',$role->id)}}"  --}}
                                            <a class="btn btn-sm btn-info"  title="@lang('secteurs.title edit')" >
                                                <i class="las la-pen"></i>
                                            </a>
                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-id="{{ $role->id }}"
                                                data-role_name="{{ $role->name }}" data-toggle="modal" href="#supprimer_secteur"
                                                title="@lang('formone.title supprimer')">
                                                <i class="las la-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="table-responsive">
                            <table id="example" class="table key-buttons text-md-nowrap">
                                <thead>
                                <tr>
                                    <th width="15px" class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">Role</th>
                                    <th width="100px" class="border-bottom-0">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1 ?>
                                @forelse($permissions as $permission)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$permission->name}}</td>
                                        <td>
                                            {{-- href="{{route('permissions.edit',$permission->id)}}" --}}
                                            <a class="btn btn-sm btn-info" title="@lang('formone.title edit')">
                                                <i class="las la-pen"></i>
                                            </a>
                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-id="{{ $permission->id }}"
                                                data-permission_name="{{ $permission->name }}" data-toggle="modal" href="#supprimer_secteur"
                                                title="@lang('formone.title supprimer')">
                                                <i class="las la-trash"></i>
                                            </a>
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

    {{-- <div class="modal" id="supprimer_modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">@lang('secteurs.modal supprimer')</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                                                  type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="secteurs/destroy" method="post">
                    @method('DELETE')
                    @csrf
                    <div class="modal-body">
                        <p>@lang('secteurs.modal validation supprision')</p><br>
                        <input type="hidden" name="id" id="id" value="">
                        <input class="form-control" name="secteur_name" id="secteur_name" type="text" readonly  >
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('secteurs.modal validation close')</button>
                        <button type="submit" class="btn btn-danger">@lang('secteurs.modal validation confirm')</button>
                    </div>

                </form>
            </div>
        </div>
    </div> --}}

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
        $('#supprimer_modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var secteur_name = button.data('secteur_name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #secteur_name').val(secteur_name);
        })
    </script>
@endsection