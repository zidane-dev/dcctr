<td>
    <a class="btn btn-sm btn-info"  href="{{route(''.$class.'.edit',$data->id)}}" title="@lang('formone.title edit')">
        <i class="las la-pen"></i>
    </a>
    <a  class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-id="{{ $data->id }}"
        data-data_name="{{ $data->name }}" data-toggle="modal" 
        href="#supprimer_data" title="@lang('formone.title supprimer')">
        <i class="las la-trash"></i>
    </a>
</td>