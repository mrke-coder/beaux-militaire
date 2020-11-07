<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UploadRepository;
use App\Models\Logement;
use App\Models\Proprietaire;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use function App\Http\Repositories\UploadRepository;

class PropietaireController extends Controller
{
   public function __construct()
   {
       $this->middleware('auth:web');
   }

    public function index(Request $request)
    {
        if ($request->ajax()){
           try{
               $propriotaires = Proprietaire::latest()->get();
               return datatables()->of($propriotaires)
                   ->editColumn('created_at', function ($proprio){
                       return $proprio->created_at ? with(new Carbon($proprio->created_at))->format('d/m/Y'): '';
                   })
                   ->addColumn('action','pages.dashboard.proprietaire.action')
                   ->addColumn('photo', 'pages.dashboard.proprietaire.photo')
                   ->rawColumns(['action','photo'])
                   ->addIndexColumn()
                   ->make(true);
           }catch (\Exception $exception){
               echo "Erreur ".$exception;
           }
        }

        return view('pages.dashboard.proprietaire.index');
   }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'civilite' => ['required'],
           'nom' => ['required', 'string'],
           'prenom' => ['required','string'],
           'contact'=> ['required']
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $proprio = Proprietaire::updateOrCreate(['id'=>$request->proprietaire_id],
                [
                    'photo' => null,
                    'civilite' => $request->civilite,
                    'nom' => $request->nom,
                    'prenoms' => $request->prenom,
                    'email' => $request->email,
                    'contact' => $request->contact,
                    'user_id' => Auth::id()
                ]
            );

        if ($proprio){
            $photo = null;
            if ($request->photo){
                $photo = 'http://127.0.0.1:8000/uploads/'.UploadRepository::upload($request->file('photo'));
                $exPhoto = $proprio->photo;
                if ($exPhoto){
                    $exPhotoOk = explode('/',$exPhoto)[4];
                    if (file_exists(public_path('uploads/'.$exPhotoOk)) && $exPhotoOk != 'default.png') {
                        unlink(public_path('uploads/'.$exPhotoOk));
                    }
                }
            }else{
                $photo = 'http://127.0.0.1:8000/uploads/default.png';
            }
            DB::table('proprietaires')->where(['id' =>$proprio->id])->update(['photo' => $photo]);

            if (is_null($request->proprietaire_id)){
                return response()->json("Propriétaire ajouté avec succès");
            } else{
                return response()->json("Les informations du propriétaires ont été mise à jour avec succès.");
            }
        }

     }

    public function show(int $id)
    {
       return response()->json(Proprietaire::find($id));
    }

    public function destroy(int $id)
    {
        return response()->json(Proprietaire::find($id));
    }

    public function infos(int $id)
    {
        $proprietaire = Proprietaire::find($id);
        $logements = Logement::query()
            ->join('emplacements','emplacements.id','=','logements.emplacement_id')
            ->join('type_logements','type_logements.id','=','logements.type_logement_id')
            ->join('militaires','militaires.id','=','logements.militaire_id')
            ->select('logements.*',
                'emplacements.ville as ville','emplacements.commune as commune', 'emplacements.quartier as quartier',
                'type_logements.description as description',
                'militaires.nom as nom_mili','militaires.prenom as prenom_mili','militaires.mecano as mecano', 'militaires.contact as phone')
            ->where('logements.proprietaire_id','=',$id)
            ->orderBy('created_at','DESC')
            ->get();


        if (!$proprietaire){
            return back()->with('error','Désolé, il se peut que le propriétaire que vous demandez ses information n\'existe pas dans nos enregistrements');
        }
        return view('pages.dashboard.proprietaire.fiche_proprietaire', compact('proprietaire','logements'));
    }
}
