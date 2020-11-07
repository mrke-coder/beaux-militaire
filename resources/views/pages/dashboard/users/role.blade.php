@foreach( \Illuminate\Support\Facades\DB::table('roles')->join('user_role', 'roles.id','=','user_role.role_id')
    ->select('user_role.user_id as user_id','user_role.role_id as role_id','roles.*')
    ->get() as $role)
    @if($role->user_id === $id)
        <div class="ui label">
            {{$role->role}}
            <a id="delete_role" data-id="{{$id.','.$role->role_id}}" href="javascript:void(0)">
                <i class="fa fa-window-close"></i></a>
        </div>
    @endif
@endforeach
