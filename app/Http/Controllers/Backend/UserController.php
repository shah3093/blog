<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct() {
    
    }
    
    public function index(){
        if(\Auth::check()){
            return redirect()->route('backend.home');
        }
        return view('backend.login');
    }
    
    public function login(Request $request){
        if(\Auth::check()){
            return redirect()->route('backend.home');
        }
    
        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
    
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])) {
            return redirect()->route('backend.home');
        }
        
        return redirect()->back()->withErrors(['Credentials not matched']);
    }
    
    public function logout(){
        Auth::logout();
        return view('backend.login');
    }
}
