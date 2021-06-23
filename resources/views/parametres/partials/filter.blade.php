<div class="mx-4">
    @can('view-select')
    <p class="mx-2">Filtrer</p>
        <form class="form-inline" method="GET" action="{{route('indexByQuery')}}">
            @csrf
            <div id="typeDiv" >
                <label for="type" class="sr-only">@lang('dpcis.type')</label>
                <select id="type" name="type" class="form-control SlectBox mx-2" >
                    <option value="" selected disabled> @lang('dpcis.type')</option> {{-- this year by default --}}
                    <option value="1"> @lang('parametre.sd')</option>
                    <option value="2"> @lang('parametre.ac')</option>
                    <option value="0">@lang('parametre.all')</option> 
                </select>
            </div>
            <div id="regDiv">
                <label for="region" class="sr-only">@lang('drs.nom')</label>
                <select id="region" name="region" class="form-control SlectBox mr-sm-2">
                    <option value="" selected disabled> @lang('drs.nom')</option> {{-- this year by default --}}
                        @foreach($filters->regions as $r)
                            @if(isset($filters->dp->dr_id))
                                @if($r->id == $dp->dr_id)
                                    <option value="{{$r->id}}" selected>
                                        {{$r->region}}
                                    </option>
                                @else
                                @endif
                            @else
                                @if($r->id==13)
                                    <option class="d-none" value="{{$r->id}}" {{ (collect(old('region'))->contains($r->region)) ? 'selected':'' }}>
                                        {{$r->region}}
                                    </option>
                                @else
                                    <option value="{{$r->id}}" {{ (collect(old('region'))->contains($r->region)) ? 'selected':'' }}>
                                        {{$r->region}}
                                    </option>
                                @endif
                            @endif
                        @endforeach
                </select>
            </div>
            <div id="provDiv">
                <label for="province" class="sr-only">@lang('dpcis.nom')</label>
                <select id="selectProvince" name="province" class="form-control SlectBox mx-2" >
                    <option id="optionProvince" value="" > @lang('dpcis.nom')</option>
                </select>
            </div>
            <div id ="dateDiv">
                <label for="dateFilter" class="sr-only">@lang('parametre.filtrer par')</label>
                <select id="dateFilter" name="year" class="form-control SlectBox2 mx-2" >
                    <option value="" selected> @lang('parametre.annee')</option> {{-- nice to have: this year by default --}}
                        @foreach($years as $year)
                            <option value="{{$year}}" {{ (collect(old('year'))->contains($year)) ? 'selected':'' }}>
                                {{$year}}
                            </option>
                        @endforeach
                    </select>
            </div>
            <input type="submit" class="btn" value="Appliquer" id="submit" style="background-color:lightgreen; color:whitesmoke;">
        </form>
    @else
        <form class="form-inline" method="GET" action="{{route('indexByQuery')}}">
            @csrf
            <div class="form-inline row m-4 float-right">
                <label for="dateFilter" class="control-label form-label mx-2">@lang('parametre.filtrer par')</label>
                <select id="dateFilter" name="year" class="form-control SlectBox  mx-2" >
                    <option value="" selected > @lang('parametre.annee')</option> {{-- this year by default --}}
                        @foreach($years as $year)
                            <option value="{{$year}}" {{ (collect(old('year'))->contains($year)) ? 'selected':'' }}>
                                {{$year}}
                            </option>   
                        @endforeach
                </select>
            </div>
            <input type="submit" class="btn" value="Appliquer" id="submit" style="background-color:lightgreen; color:whitesmoke;">
        </form>
    @endcan
</div>