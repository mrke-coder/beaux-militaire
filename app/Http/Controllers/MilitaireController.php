<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UploadRepository;
use App\Models\AncienLogement;
use App\Models\Logement;
use App\Models\Militaire;
use App\Models\MilitaireGrade;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use function App\Http\Repositories\UploadRepository;

class MilitaireController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $militaires = Militaire::latest()->get();
            try {
                return datatables()->of($militaires)
                    ->editColumn('created_at', function ($m){
                        return $m->created_at ? with(new Carbon($m->created_at))->format('d/m/Y'): '';
                    })
                    ->addColumn('action','pages.dashboard.militaire.action')
                    ->addColumn('grade','pages.dashboard.militaire.grade')
                    ->addColumn('photo','pages.dashboard.militaire.photo')
                    ->rawColumns(['photo','grade','action'])
                    ->addIndexColumn()
                    ->make(true);
            }catch (\Exception $e){
                echo 'Erreur '.$e;
            }
        }
        return view('pages.dashboard.militaire.index');
   }

    public function storeOrUpdate(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'grade' => ['required'],
                'mecano' => ['required','numeric',
                    Rule::unique('militaires')->ignore($request->militaire_id)
                    ],
                'situation_matrimoniale' => ['required','string'],
                'nom' => ['required','string'],
                'prenom' => ['required','string'],
                'date_naissance' => ['required','date'],
                'lieu_naissance' => ['string','required'],
                'adresse_email' => [Rule::unique('militaires')->ignore($request->militaire_id)],
                'contact' => ['required','string',Rule::unique('militaires')->ignore($request->militaire_id)],
                'unite_militaire' => ['required','string']
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }


       $milititaire = Militaire::updateOrCreate(['id'=>$request->militaire_id],[
            'photo' => null,
            'mecano' => $request->mecano,
            'situation_matrimoniale' => $request->situation_matrimoniale,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance,
            'adresse_email' => $request->adresse_email,
             'contact' => $request->contact,
             'unite_militaire' => $request->unite_militaire,
            'user_id' => Auth::id()
        ]);

        if ($milititaire->save()) {
            for ($i=0; $i<count($request->grade); $i++){
               MilitaireGrade::updateOrCreate(['militaire_id'=>$request->militaire_id],
                [
                    'militaire_id' => $milititaire->id,
                    'grade_id' => $request->grade[$i]
                ]);
            }
            if (is_null($request->militaire_id)) {
                return  response()->json([
                    'data' => $milititaire,
                    'message' => 'Informations du militaire ont été enregistrées avec succès'
                ],200);
            } else{
                return  response()->json([
                    'data' => $milititaire,
                    'message' => 'Informations du militaire ont été mise à jour avec succès'
                ],200);
            }
        } else{
            return response()->json('Quelque chose s\'est mal passée, veuillez rééssayer ulterieurement',500);
        }
    }

    public function show(int $id)
    {
       return response()->json(Militaire::find($id));
    }

    public function details(int $id)
    {
        $militaire = Militaire::find($id);
        $logement = Logement::query()
            ->join('emplacements','emplacements.id','=','logements.emplacement_id')
            ->join('type_logements','logements.type_logement_id','=','type_logements.id')
            ->where('logements.militaire_id','=',$id)
            ->select('logements.*',
                'emplacements.ville as ville'
                ,'emplacements.commune as commune',
                'emplacements.quartier as quartier'
                ,'type_logements.description as description')
            ->first();
        $aLogements = AncienLogement::query()
            ->join('emplacements','emplacements.id','=','ancien_logements.emplacement_id')
            ->where('militaire_id','=',$id)
            ->get();
       return view('pages.dashboard.militaire.fiche_militaire',compact('militaire','logement','aLogements'));
    }

    public function destroy_partial(int $id)
    {
        $militaire =  Militaire::find($id);
        if ($militaire->delete()){
           $grades = MilitaireGrade::query()->where('militaire_id','=',$id)->get();
           if (count($grades) > 0){
               foreach ($grades as $grade){
                   $grade->delete();
               }
           }

            return response()->json('Suppression effectuée avec succès');
        }
    }

    public function update_photo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo'=> ['required','mimes:jpg,png,jpeg,gif']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $militaire = Militaire::find($request->militaire_id);
        $photo = UploadRepository::upload($request->file('photo'));
        $exPhoto = $militaire->photo;
        $militaire->photo = 'http://127.0.0.1:8000/uploads/'.$photo;
        if ($militaire->save()) {
            if (!is_null($exPhoto)){
                $exPhotoOk = explode('/',$exPhoto)[4];
                if (file_exists(public_path('uploads/'.$exPhotoOk))) {
                    unlink(public_path('uploads/'.$exPhotoOk));
                }
            }
            return response()->json([
                'militaire' => $militaire,
                'message' => 'Photo'
            ]);
        }
    }
}
