@foreach(
\App\Models\Militaire::query()
->join('logements','logements.militaire_id','=','militaires.id')
->select('militaires.*')
->where('logements.id','=',$id)->get() as $val)
    {{$val->nom.' '.$val->prenom}}
@endforeach
