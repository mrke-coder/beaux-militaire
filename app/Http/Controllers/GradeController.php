<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\MilitaireGrade;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GradeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $grades = Grade::latest()->get();
            try {
                return datatables()->of($grades)
                    ->editColumn('created_at', function ($g){
                        return $g->created_at ? with(new Carbon($g->created_at))->format('d/m/Y'): '';
                    })
                    ->addColumn('action','pages.dashboard.grade.action')
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
            }catch (\Exception $e){
                echo 'Erreur: '.$e;
            }
        }

        return view('pages.dashboard.grade.index');
    }

    public function store(Request $request)
    {
        $validators = Validator::make($request->all(), [
           'code_grade' => ['required','string'],
           'grade' => ['required','string']
        ]);

        if ($validators->fails()) {
          return  response()->json($validators->errors(),422);
        }

        $grade = Grade::UpdateOrCreate(['id'=>$request->grade_id],
            [
                'code' => $request->code_grade,
                'grade' => $request->grade,
                'user_id' => Auth::id()
            ]
        );
        if ($grade) {
            if (is_null($request->grade_id)) {
                return response()->json('Nouveau Grade Enregistréé Avec Succès');
            } else{
                return response()->json('Grade A Eté Mise A Jour Avec Succès');
            }
        }
    }

    public function show(int $id)
    {
        return response()->json(Grade::find($id));
    }

    public function destroy(int $id)
    {
        $grade = Grade::find($id);
        if ($grade->delete()){
           // $grade->militaires()->detach($id);
            $mili_grade = MilitaireGrade::query()->where('grade_id','=',$id)->first();
            if ($mili_grade){
                $mili_grade->delete();
            }
            return response()->json('Suppression de grade effectuée avec succès');
        }
    }
}
