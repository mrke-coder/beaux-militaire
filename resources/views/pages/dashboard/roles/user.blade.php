{{
    $user = \App\User::query()->join('user_role','user_role.user_id','=','users.id')->select('user_role.*')->where('user_role.role_id','=',$id)
    ->count()
}}
