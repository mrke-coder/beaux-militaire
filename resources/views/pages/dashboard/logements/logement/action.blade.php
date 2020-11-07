<a href="javascript:void(0)" data-id="{{$id}}" class="btn btn-sm btn-success" id="edit_logement">
    <i class="fa fa-edit"></i>
</a>

<a href="javascript:void(0)" data-id="{{$id}}" class="btn btn-sm btn-danger" id="delete_logement">
    <i class="fa fa-trash-alt"></i>
</a>

<a href="{{route('logement.infos',['id'=>$id])}}" class="btn btn-sm btn-info" id="info_logement">
    <i class="fa fa-info-circle"></i>
</a>
