<?php

namespace App\Http\Controllers;

use App\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            try{
                $roles = Role::latest()->get();
                return datatables()->of($roles)
                    ->editColumn('created_at', function ($r){
                        return $r->created_at ? with(new Carbon($r->created_at))->format('d/m/Y') : '' ;
                    })
                    ->addColumn('action','pages.dashboard.roles.action')
                    ->addColumn('user','pages.dashboard.roles.user')
                    ->rawColumns(['user','action'])
                    ->addIndexColumn()
                    ->make(true);
            }catch (\Exception $e){
                echo "Erreur ".$e;
            }
        }
      return view('pages.dashboard.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
           'role' => ['required','string'],
           'description' => [Rule::unique('roles')->where('role', $request->role)->ignore($request->role_id)]
       ]);

       if ($validator->fails()){
           return response()->json($validator->errors(),422);
       }

       Role::updateOrCreate(['id'=>$request->role_id],
           [
               'role' => $request->role,
               'description' => $request->description
           ]);

       if (is_null($request->role_id)){
           return response()->json('Role ajouté avec succès',201);
       } else{
           return response()->json('Role modifié avec succès',201);
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       return response()->json(Role::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
