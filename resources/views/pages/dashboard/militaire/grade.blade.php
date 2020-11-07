@foreach(
    \Illuminate\Support\Facades\DB::table('grades')
    ->join('militaire_grade','grades.id','=','militaire_grade.grade_id')
    ->select('grades.*','militaire_grade.*')
    ->get() as $grade)
    @if ($grade->militaire_id === $id)
        <div class="ui label">
            {{$grade->grade}}
            <a
                style="text-decoration: none;color: red;"
               id="delete_grade"
                data-id="{{$id.','.$grade->id}}"
                href="javascript:void(0)">
                <i class="fa fa-window-close"></i></a>
        </div>
    @endif
@endforeach
