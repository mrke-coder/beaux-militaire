@foreach(\App\Models\Proprietaire::all() as $proprio)
    @if($proprio->id === $proprietaire_id)
        {{$proprio->civilite.' '.$proprio->nom.' '.$proprio->prenoms}}
    @endif
@endforeach
