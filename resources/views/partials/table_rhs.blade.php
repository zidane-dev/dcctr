<div class="table-responsive" style="background:#f9d098">
    <table id="example1"  class="table key-buttons text-md-nowrap width-100">
        @if($datas->count() > 0)
            <thead>
            <tr>
                <th width="25px" class="border-bottom-0">#</th>
                <th class="border-bottom-0">@lang('dpcis.nom')</th>
                <th class="border-bottom-0">@lang('rhsd.nom_qualite')</th>
                <th class="border-bottom-0">@lang('parametre.annee')</th>
                <th class="border-bottom-0">@lang('parametre.nom_objectif')</th>
                <th class="border-bottom-0">@lang('parametre.nom_realisation')</th>

                <th class="border-bottom-0">@lang('parametre.deleted_at')</th>
                <th class="border-bottom-0">@lang('parametre.par')</th>
                @canany(['destroy-basethree', 'restore'])
                    <th class="border-bottom-0">@lang('parametre.actions')</th>
                @endcanany
            </tr>
            </thead>

            <tbody>
            @foreach($datas as $data)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    @if(LaravelLocalization::getCurrentLocale() === "fr")
                    <td>{{$data->domaine->type}} - {{$data->domaine->domaine_fr}}</td>
                    <td>{{$data->qualite->qualite_fr}}</td>
                    @else
                    <td>{{$data->domaine->type}} - {{$data->domaine->domaine_ar}}</td>
                    <td>{{$data->qualite->qualite_ar}}</td>
                    @endif
                    <td>{{$data->ANNEE}}</td>
                    <td>{{$data->OBJECTIF}}</td>
                    <td>{{$data->REALISATION}}</td>
                    <td>{{\Carbon\Carbon::parse($data->deleted_at)->format('d/m/y')}} @lang('parametre.at') 
                        {{\Carbon\Carbon::parse($data->deleted_at)->format('H:i')}} </td>
                    <td>{{$data->user->name}}</td>
                    @canany(['destroy-basethree', 'restore'])
                        <td class="mx-auto">
                            @can('destroy-basethree')
                            {{-- @can('restore') Need to create it--}}
                                <a class="ml-1"  href="javascript:void(0)" 
                                data-id="{{ $data->id }}" title="@lang('archives.restorer')"
                                data-tbl="rhsds" 
                                data-toggle="modal" 
                                data-target="#modalRhRestore">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="20" viewBox="0 0 24 24" fill="none" stroke="#478ced" stroke-width="2.5" stroke-linecap="square" stroke-linejoin="arcs"><path d="M15 10L9 4l-6 6"/><path d="M20 20h-7a4 4 0 0 1-4-4V5"/></svg>
                                </a>
                            @endcan
                            @can('destroy-basethree')
                                <a class="ml-1"  href="javascript:void(0)" 
                                data-id="{{ $data->id }}" title="@lang('archives.supprimer')"
                                data-toggle="modal" 
                                data-target="#modalRhsdSUP">
                                    <i class="text-danger fas fa-trash-alt"></i>
                                </a>
                            @endcan
                        </td>
                    @endcanany
                </tr>
            @endforeach
            </tbody>
        @else
            @include('partials.emptylist')
        @endif
    </table>
</div>

@include('modals.restore_rh')