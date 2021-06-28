@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">
                    @lang('sidebar.'.$class)
                </h4>
                <span class="text-muted mt-1 tx-14 mr-2 mb-0">
                    /  @lang($class.'.add')
                </span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
