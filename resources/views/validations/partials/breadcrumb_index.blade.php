@section('title') @lang('sidebar.'.$table)   @endsection

<div class="breadcarumb-header justify-content-between">
    <div class="my-auto py-2">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">
                @can('dc')
                    @lang('sidebar.'.$table) 
                @else
                    @if(LaravelLocalization::getCurrentLocale() === 'fr')
                        @lang('sidebar.'.$table) / {{Auth::user()->domaine->type}} - {{Auth::user()->domaine->domaine_fr}}
                    @else
                        @lang('sidebar.'.$table) / {{Auth::user()->domaine->type}} - {{Auth::user()->domaine->domaine_ar}}
                    @endif
                @endcan
            </h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                &nbsp;&nbsp;&nbsp;&nbsp;/  @lang('sidebar.validation')
            </span>
        </div>
    </div>

</div>