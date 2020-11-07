<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UploadRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private  $_baseURL = "http://127.0.0.1:8000/";
   public function __construct()
   {
       $this->middleware('auth:web');
   }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::latest()->get();
            try {
                return datatables()->of($users)
                    ->editColumn('created_at', function ($user) {
                        return $user->created_at ? with(new Carbon($user->created_at))->format('d/m/Y') : '';
                    })
                    ->addIndexColumn()
                    ->addColumn('action', 'pages.dashboard.users.action')
                    ->addColumn('user', 'pages.dashboard.users.user')
                    ->addColumn('role', 'pages.dashboard.users.role')
                    ->rawColumns(['user', 'role', 'action'])
                    ->make(true);
            } catch (\Exception $exception) {
                echo 'Erreur : ' . $exception;
            }
        }
        return view('pages.dashboard.users.index');
   }
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(),  [
        'firstName' =>['required','string'],
        'lastName' => ['required','string'],
        'username' => ['required','string',Rule::unique('users')->ignore($request->user_id)],
        'password' => ['required','string','min:8','confirmed']
        ]);

       if ($validator->fails()){
           return response()->json($validator->errors(), 422);
       }

       $avatar = null;
       if (is_null($request->user_id)){
           if ($request->avatar){
               $avatar = $this->_baseURL.'uploads/'.UploadRepository::upload($request->file('avatar'));
           } else{
               $avatar = $this->_baseURL.'uploads/default_avatar.png';
           }
       } else{
           $user = User::find($request->user_id);
          if ($user->avatar){
              $exAvatar = explode('/',$user->avatar)[4];
              if (file_exists(public_path('uploads/'.$exAvatar))){
                  unlink(public_path('uploads/'.$exAvatar));
              }
          }
           if ($request->avatar){
               $avatar = $this->_baseURL.'uploads/'.UploadRepository::upload($request->file('avatar'));
           } else{
               $avatar = $this->_baseURL.'uploads/default_avatar.png';
           }

       }

      User::updateOrCreate(['id'=>$request->user_id],[
            'firstName'=> $request->firstName,
            'lastName' => $request->lastName,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'avatar' => $avatar,
        ]);
        if (is_null($request->user_id)){
            return response()->json("Utilisateur Créé avec succès.",201);
        } else{
            return response()->json("Mofification de l'utilisateur a été prise en charge.",201);
        }

    }

    public function show(int $id)
    {
        return response()->json(User::find($id));
    }

    public function destroy(int $id)
    {
        $user = User::find($id);

        if ($user->delete()){
            return response()->json('DELETED OK');
        }
    }
}
