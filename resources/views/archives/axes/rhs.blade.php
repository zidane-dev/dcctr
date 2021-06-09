<div class="table-responsive">
    <table id="example1"  class="table key-buttons text-md-nowrap">
        <thead>
        <tr>
            <th width="10px"><input type="checkbox" name="select_all" id="example-select-all" onclick="CheckAll('box1',this)"> </th>
            <th width="25px" class="border-bottom-0">#</th>
            @hasanyrole('s-a|d-r')
                <th class="border-bottom-0">@lang('dpcis.type')</th>
                <th class="border-bottom-0">@lang('dpcis.nom')</th>
            @endhasanyrole
            <th class="border-bottom-0">@lang('rhsd.nom_qualite')</th>
            <th class="border-bottom-0">@lang('rhsd.nom_realisation')</th>
            <th class="border-bottom-0">@lang('rhsd.user')</th>
            @hasanyrole('s-a')
                <th class="border-bottom-0">@lang('rhsd.etat')</th>
                @else
            @endhasanyrole
            <th class="border-bottom-0">@lang('rhsd.rejet')</th>
            <th class="border-bottom-0">@lang('rhsd.motif')</th>
            <th class="border-bottom-0">@lang('rhsd.deleted_at')</th>
            <th class="col-auto mr-auto border-bottom-0">@lang('rhsd.action')</th>
        </tr>
        </thead>

        <tbody>
        @foreach($rhsds as $rhsd)
            <tr style="background-color: hsla(0, 100%, 65%, 0.4) !important;}">
                <td>
                    <input type="checkbox" value="{{$rhsd->id}}" class="box1">
                </td>
                <td>
                    {{$loop->iteration}}
                </td>
                
                @hasanyrole('s-a|d-r')
                    <td>{{$rhsd->domaine->t}}</td>
                    <td>{{$rhsd->domaine->domaine}}</td>
                @endhasanyrole
                {{-- <td>{{\Carbon\Carbon::parse($rhsd->date)->format('d/m/y h:m')}}</td> --}}
                {{-- <td>{{\Carbon\Carbon::now()->diffForHumans($rhsd->updated_at)}}</td> --}}
                <td>{{$rhsd->qualite->qualite}}</td>
                <td>{{$rhsd->REALISATIONSD}}</td>
                <td>{{$rhsd->user->name}}</td>
                @hasanyrole('s-a')
                <td>
                    @if($rhsd->ETATSD == 0)
                        <label class="badge badge-success">{{ $rhsd->ETATSD }}</label>
                    @else
                        <label class="badge badge-info"> {{$rhsd->ETATSD}}</label>
                    @endif
                </td>
                @endhasanyrole
                <td>
                    @if($rhsd->REJETSD == 1)
                        <label class="badge badge-danger">@lang('rhsd.rejete')</label>
                    @else
                        @if($rhsd->ETATSD == 6 OR $rhsd->ETATSD < 2)
                        @else
                        <label class="badge badge-info">@lang('rhsd.non')</label>
                        @endif
                    @endif
                </td>
                {{-- <td>
                    @if($rhsd->Description != "")
                        {{\Illuminate\Support\Str::limit($rhsd->Description,30,'...')}}
                    @else
                        <span><a href="" style="color: #47484a;margin-left: 32%;"><i class="fas fa-plus-circle" ></i></a></span>

                    @endif
                </td> --}}

                <td style="text-align: center">
                    @if($rhsd->Motif != "")
                        {{\Illuminate\Support\Str::limit($rhsd->Motif,30,'...')}}
                    @else

                    @endif

                </td>
                <td>{{\Carbon\Carbon::parse($rhsd->deleted_at)->format('d/m/y')}} @lang('rhsd.at') 
                    {{\Carbon\Carbon::parse($rhsd->deleted_at)->format('H:i')}} 
                </td>
                <td class="d-inline-flex text-center align-middle">
                    @if($rhsd->ETATSD != 6)
                        <div class="dropdown">
                            <button aria-expanded="false" aria-haspopup="true"
                                    class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                    type="button">
                                        @lang('rhsd.actions')
                                    <i class="fas fa-caret-down"></i>
                            </button>
                            <div class="dropdown-menu">
                                @can('edit-rhsds')
                                    <a class="dropdown-item" href="{{route('rhs.edit',$rhsd->id)}}">
                                        <i class=" fas fa-edit" style="color: #239a8a"></i>
                                        &nbsp;&nbsp;@lang('rhsd.edit')
                                    </a>
                                @endcan

                                    <a class="dropdown-item" href="{{route('rhs.storereal',$rhsd->id)}}">
                                        <i class="fas fa-plus-circle"></i>
                                        &nbsp;&nbsp;@lang('rhsd.ajoutSur')
                                    </a>

                                    <a class="dropdown-item" href="{{route('edit.rhsgoal',$rhsd->id)}}">
                                        <i class="fas fa-vote-yea"></i>
                                        &nbsp;&nbsp;@lang('rhsd.changeObjectif')
                                    </a>
                                
                                @can('delete-rhsds')
                                    <a class="dropdown-item"  href="javascript:void(0)" data-id="{{ $rhsd->id }}"
                                    data-toggle="modal" data-target="#modalRhsdSUP">
                                        <i class="text-danger fas fa-trash-alt"></i>
                                        &nbsp;&nbsp;@lang('rhsd.supprimer')
                                    </a>
                                @endcan
                            </div>
                        </div>
                    @else
                        <span class="badge badge-info" style="background-color: #ffffff; color: black;">@lang('rhsd.validated')</span>
                        <a class=" px-3" href="{{route('rhs.storereal',$rhsd->id)}}" title="@lang('rhsd.ajoutSurTitle')">
                            <i class="fas fa-plus-circle"></i>
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>