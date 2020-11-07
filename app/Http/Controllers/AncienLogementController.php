<?php

namespace App\Http\Controllers;

use App\Models\AncienLogement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AncienLogementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(Request $request)
    {
        setlocale(LC_TIME, 'French');
        if ($request->ajax()){
            $ancien_logements = AncienLogement::query()
                ->join('militaires','militaires.id', '=','ancien_logements.militaire_id')
                ->join('emplacements','emplacements.id','=','ancien_logements.emplacement_id')
                ->select('ancien_logements.*',
                'militaires.nom as nom','militaires.prenom as prenom',
                'emplacements.commune as commune','emplacements.quartier as quartier')
                ->latest()
                ->get();
            try{

                return datatables()->of($ancien_logements)
                    ->editColumn('created_at',function ($ancL){
                        return $ancL->created_at ? with(new Carbon($ancL->created_at))->format('d/m/Y'):'';
                    })
                    ->editColumn('date_debut', function ($aL){
                        return $aL->date_debut ? with(new Carbon($aL->date_debut))->formatLocalized('%A %d %B %Y'): '';
                    })
                    ->editColumn('date_fin', function ($aL){
                        return $aL->date_fin ? with(new Carbon($aL->date_fin))->formatLocalized('%A %d %B %Y'): '';
                    })
                    ->addColumn('action', 'pages.dashboard.logements.ancienLogement.action')
                    ->addColumn('emplacement', 'pages.dashboard.logements.ancienLogement.emplacement')
                    ->addColumn('militaire', 'pages.dashboard.logements.ancienlogement.militaire')
                    ->rawColumns(['militaire','emplacement','action'])
                    ->addIndexColumn()
                    ->make(true);
            }catch (\Exception $e){
                echo "Erreur ".$e;
            }
        }
        return view('pages.dashboard.logements.ancienLogement.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'militaire' => ['required'],
            'emplacement' => ['required'],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date'],
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        AncienLogement::updateOrCreate(['id'=>$request->ancien_logement_id],
            [
                'militaire_id' => $request->militaire,
                'emplacement_id' => $request->emplacement,
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
                'user_id' => Auth::id()
            ]);

        if (is_null($request->ancien_logement_id)){
            return response()->json('Ancien Logement Enregistré avec succès');
        } else{
            return response()->json('Modification effectuée avec succès');
        }
    }

    public function show(int $id)
    {
        return response()->json(AncienLogement::find($id));
    }

    public function destroy(int $id)
    {
       $ancienL = AncienLogement::find($id);
       if ($ancienL->delete()){
           return response()->json('Deleted Ok');
       }
    }
}
