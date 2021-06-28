@section('title') @lang('sidebar.'.$table)   @endsection

<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">
                @can('view-select')
                    @lang('sidebar.'.$table) / @lang('parametre.vue_select')
                @else
                    @lang('sidebar.'.$table) / {{$dp->type.' / '.$dp->domaine}}
                @endcan
            </h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                &nbsp;&nbsp;&nbsp;&nbsp;/  @lang('sidebar.liste_'.$table)
            </span>
        </div>
    </div>
</div>