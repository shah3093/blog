<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    
    public function getProfiledata(){
        $data['user'] = User::find(Auth::id());
        return view('backend.profile.index',$data);
    }
    
    public function updatepasswordform(){
        return view('backend.profile.password');
    }
    
    public function updateProfile(Request $request){
        $validatedData = $request->validate([
            'name'  => 'required'
        ]);
        
        try{
            $user = User::find(Auth::id());
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->save();
            return redirect()->back();
            
        }catch(\Exception $exception){
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }
    
    public function updatepassword(Request $request){
        $validatedData = $request->validate([
            'password'     => 'required',
            'oldpassword'  => 'required',
            'confirmpassword' => 'required|same:password'
        ]);
    
        $messages = [
            'confirmpassword.same' => 'Password Confirmation should match the Password',
            'oldpassword'       => 'Old Password is required',
            'confirmpassword.required' => 'Confirm Password required'
        ];
        if(!Hash::check($request->oldpassword, Auth::user()->getAuthPassword())) {
            return redirect()->back()->withErrors(["Old Password Not matched"]);
        }
    
        try {
            $credentials = [
                'id' => Auth::guard('web')->id()
            ];
            $user = User::where($credentials)->first();
            $user->password = bcrypt($request->password);
            $user->save();
            $request->session()->flash('successMsg', 'Password has been updated');
        
            return redirect()->back();
        } catch(\Exception $exception) {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }
}
