<?php

namespace App\Http\Controllers;

use App\Models\TypeLogement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TypeLogementController extends Controller
{
   public function __construct()
   {
       $this->middleware('auth:web');
   }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = TypeLogement::latest()->get();
            try {
                return datatables()->of($data)
                    ->editColumn('created_at',function ($t){
                       return $t->created_at ? with(new Carbon($t->created_at))->format('d/m/Y'):'';
                    })
                    ->addColumn('action','pages.dashboard.logements.type_logement.action')
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
            } catch (\Exception $exception){
                echo "Erreur ".$exception;
            }
        }
        return view('pages.dashboard.logements.type_logement.index');
   }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'description' => ['required','string',
               Rule::unique('type_logements')->ignore($request->type_id)]
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

       TypeLogement::updateOrCreate(['id'=>$request->type_id],
            [
                'description'=> $request->description,
                'user_id' => Auth::id()
            ]
        );

        if (is_null($request->type_id)) {
            return response()->json('Type De Logement Ajouté Avec Succès');
        } else{
            return response()->json('Type De Logement Mis à jour Avec Succès');
        }
     }
    public function show(int $id)
    {
       return response()->json(TypeLogement::find($id));
   }

    public function destroy(int $id)
    {
        $typL = TypeLogement::find($id);

        if ($typL->delete()) {
            return response()->json("Suppression effectuée avec succès");
        } else{
            return response()->json("Erreur serveur, veillez rééssayer", 500);
        }
   }
}
