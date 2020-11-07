<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function index()
    {
        return view('pages.auth.login');
    }


    public function show(int $id)
    {

    }

    public function update()
    {

    }

    public function login(Request $request)
    {
        $request->validate([
           'username' => ['required','string'],
            'password' => ['required']
        ]);

        if (Auth::attempt(['username' => $request->username,'password'=>$request->password])) {
            return redirect()->intended('dashboard');
        }
        return back()->with('error','Vos idenifiants sont incorrects');
    }

    public function logout()
    {
      Auth::logout();
      return redirect('/');
    }

    public function destroy()
    {

    }

}
