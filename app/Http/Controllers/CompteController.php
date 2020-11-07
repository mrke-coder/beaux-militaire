<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CompteController extends Controller
{
   public function __construct()
   {
       $this->middleware('auth:web');
   }

    public function index(Request $request)
    {
        if ($request->ajax()){
            try{
                $comptes = Compte::latest()->get();
                return datatables()->of($comptes)
                    ->editColumn('created_at', function ($cmpt){
                        return $cmpt->created_at ? with(new Carbon($cmpt->created_at))->format('d/m/Y') : '';
                    })
                    ->addColumn('action','pages.dashboard.comptes.action')
                    ->addColumn('proprietaire','pages.dashboard.comptes.proprietaire')
                    ->rawColumns(['proprietaire','action'])
                    ->addIndexColumn()
                    ->make(true);
            }catch (\Exception $e){
                echo "Erreur ".$e;
            }
        }
        return view('pages.dashboard.comptes.index');
   }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom_compte' => ['required','string'],
            'type_compte' => ['required','string'],
            'numero_compte' => ['required','string'],
            'nom_banque' => ['required','string'],
            'proprietaire_id' => ['required']
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        Compte::updateOrCreate(['id'=>$request->compte_id],
            [
                'nom_compte' => $request->nom_compte,
                'type_compte' => $request->type_compte,
                'numero_compte' => $request->numero_compte,
                'nom_banque' => $request->nom_banque,
                'proprietaire_id' => $request->proprietaire_id
            ]
            );

        if (is_null($request->proprietaire_id)){
            return response()->json('Compte créé avec avec succès');
        } else{

            return response()->json('Compte mis à jour avec avec succès');
        }
     }

    public function show(int $id)
    {
        return response()->json(Compte::find($id));
   }

    public function delete(int $id)
    {
       return response()->json(Compte::find($id));
   }

    public function infos(int $id)
    {
        $compte = Compte::find($id);
        if (!$compte){
           return back('error', 'Il se peut que le compte dont vous demandez les informations n\'existe pas');
        }
        dd($compte);
   }
}
