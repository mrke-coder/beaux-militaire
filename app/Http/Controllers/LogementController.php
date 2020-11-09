<?php

namespace App\Http\Controllers;

use App\Models\Logement;
use App\Models\Militaire;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LogementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(Request $request)
    {
        if ($request->ajax()){
            $logements = Logement::query()
                ->join('emplacements','emplacements.id','=','logements.emplacement_id')
                ->join('type_logements','type_logements.id','=','logements.type_logement_id')
                ->join('proprietaires','proprietaires.id','=','logements.proprietaire_id')
                ->select('logements.*','emplacements.ville as ville','emplacements.commune as commune', 'emplacements.quartier as quartier',
                    'type_logements.description as type_logement',
                    'proprietaires.nom as proprietaire_nom','proprietaires.prenoms as proprietaire_prenom')
                ->latest()
                ->get();
            try{
                return datatables()->of($logements)
                    ->editColumn('created_at', function ($log){
                      return $log->created_at ? with(new Carbon($log->created_at))->format('d/m/Y'): '';
                    })
                    ->addColumn('action', 'pages.dashboard.logements.logement.action')
                    ->addColumn('emplacement','pages.dashboard.logements.logement.emplacement')
                    ->addColumn('proprietaire','pages.dashboard.logements.logement.proprietaire')
                    ->addColumn('militaire','pages.dashboard.logements.logement.militaire')
                    ->rawColumns(['emplacement','militaire','action'])
                    ->addIndexColumn()
                    ->make(true);
            }catch (\Exception $exception){
                echo "Erreur ".$exception;
            }
        }
        return view('pages.dashboard.logements.logement.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_piece' => ['required','numeric'],
            'emplacement_id' => ['required','numeric'],
            'type_logement_id' => ['required','numeric'],
            'proprietaire_id' => ['required','numeric'],
            'numero_lot' => ['required'],
            'numero_ilot' => ['required'],
            'militaire_id' => ['required']
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        Logement::updateOrCreate(['id'=>$request->logement_id],
            [
                'numero_lot' => $request->numero_lot,
                'numero_ilot' => $request->numero_ilot,
                'nombre_piece' => $request->nombre_piece,
                'emplacement_id' => $request->emplacement_id,
                'militaire_id' => $request->militaire_id,
                'type_logement_id' => $request->type_logement_id,
                'proprietaire_id' => $request->proprietaire_id,
                'user_id' => Auth::id()
            ]
            );

        if (is_null($request->logement_id)){
            return response()->json('Logement ajouté avec succès');
        } else if (!is_null($request->logement_id)) {
            return response()->json('Logement modifié  avec succès');
        }
    }

    public function show(int $id)
    {
        return response()->json(Logement::find($id));
    }

    public function informations(int $id)
    {
        $logement = Logement::query()
            ->join('emplacements','emplacements.id','=','logements.emplacement_id')
            ->join('type_logements','type_logements.id','=','logements.type_logement_id')
            ->join('proprietaires','proprietaires.id','=','logements.proprietaire_id')
            ->select('logements.*','emplacements.ville as ville','emplacements.commune as commune', 'emplacements.quartier as quartier',
                'type_logements.description as type_logement',
                'proprietaires.nom as proprietaire_nom',
                'proprietaires.prenoms as proprietaire_prenom',
                'proprietaires.civilite as civilite', 'proprietaires.photo as photo',
                'proprietaires.email as email','proprietaires.contact as contact')
            ->where('logements.id','=',$id)
            ->first();
        $militaire = Logement::find($id)->militaire;

        return view('pages.dashboard.logements.logement.informatins', [
            'logement' => $logement,
            'militaire' => $militaire
        ]);
    }

    public function destroy(int $id)
    {
       $log = Logement::find($id);

        if ($log->delete()) {
            return response()->json("Suppression effectuée avec succès");
        } else{
            return response()->json("Erreur serveur, veillez rééssayer", 500);
        }
    }
}
