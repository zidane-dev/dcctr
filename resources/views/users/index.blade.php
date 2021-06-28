@extends('layouts.master')


@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">@lang('sidebar.user')</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/  @lang('sidebar.liste user')</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
<div class="row row-sm">
  <div class="col-xl-12">
    <div class="card mg-b-20">
      @include('layouts.errors_success')
      <div class="card-header pb-0">
        <a href="{{route('secteurs.create')}}" class="btn btn-primary" style="color: whitesmoke">
          <i class="fas fa-plus"></i> 
          @lang('users.add user') 
        </a>
      </div>
      @if($data->count() > 0)
      <div class="card-body">
        <div class="table-responsive">
          <table id="example1" class="table key-buttons text-md-nowrap">
            <thead>
              <tr>
                <th class="border-bottom-0">#</th>
                <th class="border-bottom-0">Name</th>
                <th class="border-bottom-0">Email</th>
                <th class="border-bottom-0">Type</th>
                <th class="border-bottom-0">Domaine</th>
                <th class="border-bottom-0">@lang('drs.nom')</th>
                <th class="border-bottom-0">Roles</th>
                <th class="border-bottom-0" width="150px">@lang('formone.action')</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $key => $user)
                <tr>
                  <td>{{ ++$i }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  @if(LaravelLocalization::getCurrentLocale() === 'fr')
                    <td>{{ $user->domaine->type }}</td>
                    <td>{{ $user->domaine->domaine_fr }}</td>
                    <td>{{ $user->domaine->region->region_fr}}</td>
                  @else
                    <td>{{ $user->domaine->type }}</td>
                    <td>{{ $user->domaine->domaine_ar }}</td>
                    <td>{{ $user->domaine->region->region_fr }}</td>
                  @endif
                  <td>
                    @if(!empty($user->getRoleNames()))
                      @foreach($user->getRoleNames() as $v)
                        <label class="badge badge-success">{{ $v }}</label>
                      @endforeach
                    @endif
                  </td>
                  <td>
                    <a class="btn btn-sm btn-primary" href="{{ route('users.edit',$user->id) }}">
                      <i class="las la-pen"></i>
                    </a>
                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-id="{{ $user->id }}"
                      data-user_name="{{ $user->name}}" data-toggle="modal" href="#supprimer"
                      title="@lang('formone.title supprimer')">
                      <i class="las la-trash"></i>
                    </a>
                  </td>
                </tr>
              @endforeach
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

  <div class="modal" id="supprimer">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">@lang('users.modal supprimer')</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                                              type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="users/destroy" method="post">
                @method('DELETE')
                @csrf
                <div class="modal-body">
                    <p>@lang('users.modal validation supprision')</p><br>
                    <input type="hidden" name="id" id="id" value="">
                    <input class="form-control" name="section_name" id="user_name" type="text" readonly  >
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bt n-secondary" data-dismiss="modal">@lang('users.modal validation close')</button>
                    <button type="submit" class="btn btn-danger">@lang('users.modal validation confirm')</button>
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
    $('#supprimer').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var user_name = button.data('user_name')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #user_name').val(user_name);
    })
  </script>
@endsection