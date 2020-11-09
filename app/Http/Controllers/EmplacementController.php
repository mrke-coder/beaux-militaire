<?php

namespace App\Http\Controllers;

use App\Models\AncienLogement;
use App\Models\Emplacement;
use App\Models\Logement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EmplacementController extends Controller
{
   public function __construct()
   {
       $this->middleware('auth:web');
   }

    public function index(Request $request)
    {
        if ($request->ajax()){
            $emplacements = Emplacement::latest()->get();
            try{
               return datatables()->of($emplacements)
                    ->editColumn('created_at',function ($mpl){
                        return $mpl->created_at ? with(new Carbon($mpl->created_at))->format('d/m/Y'): '';
                    })
                   ->addColumn('action','pages.dashboard.emplacement.action')
                   ->rawColumns(['action'])
                   ->addIndexColumn()
                   ->make(true);
            }catch (\Exception $exception){
                echo "Erreur ".$exception;
            }
        }
        return view('pages.dashboard.emplacement.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'ville' => ['required','string'],
            'commune' => ['required', 'string'],
            'quartier' => ['required', 'string', Rule::unique('emplacements')->ignore($request->emplacement_id)]
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        Emplacement::updateOrCreate(['id'=>$request->emplacement_id],[
            'ville' => $request->ville,
            'commune' => $request->commune,
            'quartier' => $request->quartier,
            'user_id' => Auth::id()
        ]);

        if (is_null($request->emplacement_id)){
            return response()->json('Emplacement enregistré avec succès.');
        } else{
            return response()->json("Emplacement $request->emplacement modifié avec avec succès.");
        }
    }

    public function show(int $id)
    {
        return response()->json(Emplacement::find($id));
    }

    public function destroy(int $id)
    {
       $emplacement = Emplacement::find($id);
       $logements = Logement::query()->where('emplacement_id','=',$id)->get();
       $aLogements = AncienLogement::query()->where('emplacement_id','=',$id)->get();
       if (count($logements) >0){
           return response()->json('Désoleé, il y a des logements situés à cet emplacement donc impossible de le supprimer');
       } elseif (count($aLogements) >0){
           return response()->json('Désoleé, il y a des aniciens logements situés à cet emplacement donc impossible de le supprimer');
       }
       $emplacement->delete();
       return response()->json("Suppression effectuée avec succès");
    }
}
