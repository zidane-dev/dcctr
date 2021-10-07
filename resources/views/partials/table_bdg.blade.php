@if($datas->count() > 0)
    <thead>
        <tr>
            <th width="25px" class="border-bottom-0">#</th>
            <th class="border-bottom-0">@lang('dpcis.nom')</th>
            <th class="border-bottom-0">@lang('depenses.nom')</th>
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
                <td>{{$data->domaine->ty}} - {{$data->domaine->domaine}}</td>
                <td>{{$data->depense->depense}}</td>
                <td>{{$data->ANNEE}}</td>
                <td>{{$data->OBJECTIF}}</td>
                <td>{{$data->REALISATION}}</td>
                <td>{{\Carbon\Carbon::parse($data->deleted_at)->format('d/m/y')}} @lang('parametre.at') 
                    {{\Carbon\Carbon::parse($data->deleted_at)->format('H:i')}} </td>
                <td>{{$data->user->name}}</td>
                @canany(['destroy-basethree', 'restore'])
                    <td class="mx-auto">
                        @can('destroy-basethree')
                            <a class=""  href="javascript:void(0)" data-id="{{ $data->id }}" title="@lang('archive.supprimer')"
                            data-toggle="modal" data-target="#modalRhsdSUP">
                                <i class="text-danger fas fa-refresh"></i>
                            </a>
                        @endcan
                    </td>
                    <td class="mx-auto">
                        @can('destroy-basethree')
                            <a class=""  href="javascript:void(0)" data-id="{{ $data->id }}" title="@lang('archive.supprimer')"
                            data-toggle="modal" data-target="#modalRhsdSUP">
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