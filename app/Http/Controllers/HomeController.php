<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function varify_resent(Request $request )
    {
       return route('verification.verify')->with('msg','send');
    }
    public function passwordChange()
    {
        return view('auth.passwords.changePassword');
    }
    public function passwordUpdate(Request $request)
    {
        # code...
        $request->validate([
            "current_password"=>'required',
            "password" => 'required|min:8|string|confirmed',
            "password_confirmation" => 'required'
        ]);
        
        if(Hash::check($request->current_password, Auth::user()->password)){
            Auth::user()->password = Hash::make($request->password) ;
            Auth::user()->save();
            return redirect()->back()->with('success','Password changed!');
        }else{
             return redirect()->back()->with('error','Current Password not matched.!');
        }
    }
}
