<div class="card mg-b-20">
    <div class="card-header pb-0">
        <h3 class="text-center">@lang('parametre.etats actuels')</h3>
    </div>
    <div class="card-body">
        <div class="text-center">
            <div class="d-flex flex-wrap even-cols">
                @foreach ($rows_count->states as $count)
                    @can('view-province')
                        <div class="col w-100 inline-block" >
                            <div class="card" style="height: 180px">
                                <div class="card-title mt-2" >
                                    @lang('roles.etat_'.($loop->iteration-1))
                                </div>
                                <div class="card-body">
                                    <h2>{{$count}}</h2>
                                </div>
                            </div>
                        </div>
                    @elsecan('view-region')
                        <div class="col w-100 inline-block" >
                            <div class="card" style="height: 180px">
                                <div class="card-title mt-2" >
                                    <h2>{{$count}}</h2>
                                </div>
                                <div class="card-body">
                                    @lang('roles.etat_'.($loop->iteration-1))
                                </div>
                            </div>
                        </div>
                    @elsecan('view-select')
                        <div class="col w-100 inline-block" >
                            <div class="card" style="height: 180px">
                                <div class="card-title mt-2" >
                                    <h2>{{$count}}</h2>
                                </div>
                                <div class="card-body">
                                    @lang('roles.etat_'.($loop->iteration-1))
                                </div>
                            </div>
                        </div>
                    @endcan
                @endforeach
            </div>
        </div>
        <div>
            <span class="font-italic">
            @lang('parametre.total_lignes')
            @canany(['sd', 'ac'])
                @lang('parametre.au_niveau') {{Auth::user()->domaine->type}} 
            @endcanany
            </span>
            <span class="font-weight-bold">: {{$rows_count->rows}} </span>
        </div>
    </div>
</div>