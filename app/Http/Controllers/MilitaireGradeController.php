<?php

namespace App\Http\Controllers;

use App\Models\MilitaireGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MilitaireGradeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'grade' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }
        $res = DB::table('militaire_grade')
            ->where('militaire_id','=',$request->militaire_id)
            ->get();
        $erro_unique = [];
        for ($i=0; $i<count($request->grade); $i++){
            foreach ($res as $r){
                if ($r->grade_id != $request->grade[$i] ) {
                    MilitaireGrade::create([
                        'militaire_id' => $request->militaire_id,
                        'grade_id' => $request->grade[$i]
                    ]);
                }
            }
        }

        return response()->json([
            'message' =>'Grades ajoutés au militaire avce succès',
            'exist_errors' => $erro_unique
        ]);
    }
}
