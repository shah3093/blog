<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Visitor;
use App\Notifications\SendVerifyMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class VisitorController extends Controller {
    public function showLoginForm() {
        
        return view('frontend.visitors.loginform');
    }
    
    public function showRegistrationForm() {
        
        return view('frontend.visitors.regform');
    }
    
    public function registerVisitor(Request $request) {
        
        $validatedData = $request->validate([
            'name'     => 'required',
            'email'    => 'required|unique:visitors,email|email',
            'password' => 'required',
        ]);
        
        try {
            $visitor = new Visitor();
            $visitor->name = $request->name;
            $visitor->email = $request->email;
            $visitor->password = bcrypt($request->password);
            $visitor->save();
            
            $visitor->notify(new SendVerifyMail($visitor));
            
            return redirect()->back()->withErrors(["Please check your email's inbox and confirmed registration"]);
            
        } catch(\Exception $exception) {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }
    
    public function verifyVisitor($visitorid, $code) {
        
        try {
            $visitor = Visitor::findOrFail($visitorid);
            $code2 = md5($visitor->email).md5($visitor->created_at);
            if($code == $code2) {
                $visitor->email_verified_at = Carbon::now()->toDateTimeString();
                $visitor->status = 1;
                $visitor->save();
                
                return redirect()->route('visitors.loginform');
            }
            
            return redirect()->route('visitors.registrationform')->withErrors(["Wrong code. Please try again"]);
        } catch(\Exception $exception) {
            return redirect()->route('visitors.registrationform')->withErrors(["Wrong code. Please try again"]);
        }
    }
    
    public function login(Request $request) {
        
        $validatedData = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        try {
            $credentials = [
                'email'    => $request->email,
                'password' => $request->password,
                'status'   => 1
            ];
            if(\Auth::guard('visitor')->attempt($credentials)) {
                return redirect()->route('visitors.profile');
            }
            
            return redirect()->back()->withErrors(["Credentials not matched"]);
        } catch(\Exception $exception) {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }
    
    public function loginajax(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        
        if($validator->fails()) {
            return response()->json(["Fill form correctly"]);
        }
        
        try {
            $credentials = [
                'email'    => $request->email,
                'password' => $request->password,
                'status'   => 1
            ];
            if(\Auth::guard('visitor')->attempt($credentials)) {
                return response()->json(["DONE"]);
            }
            
            return response()->json(["Credentials not matched"]);
        } catch(\Exception $exception) {
            return response()->json([$exception->getMessage()]);
        }
    }
    
    public function getVisitorProfile() {
        
        return view('frontend.visitors.profile');
    }
    
    public function showEditNameForm() {
        
        return view('frontend.visitors.nameform');
    }
    
    public function updatename(Request $request) {
        
        $validatedData = $request->validate([
            'name' => 'required'
        ]);
        
        try {
            $visitor = Visitor::find(Auth::guard('visitor')->id());
            $visitor->name = $request->name;
            $visitor->save();
            $request->session()->flash('message', 'Name has updated');
            
            return redirect()->route('visitors.profile');
        } catch(\Exception $exception) {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }
    
    public function showEditPasswordForm() {
        
        return view('frontend.visitors.passwordform');
    }
    
    public function updatepassword(Request $request) {
        
        $validatedData = $request->validate([
            'password'     => 'required',
            'oldpassword'  => 'required',
            'confPassword' => 'required|same:password'
        ]);
        
        $messages = [
            'confPassword.same' => 'Password Confirmation should match the Password',
            'oldpassword'       => 'Old Password is required',
        ];
        
        if(!Hash::check($request->oldpassword, Auth::guard('visitor')->user()->password)) {
            redirect()->back()->withErrors(["Old Password Not matched"]);
        }
        
        try {
            $credentials = [
                'id' => Auth::guard('visitor')->id()
            ];
            $visitor = Visitor::where($credentials)->first();
            $visitor->password = bcrypt($request->password);
            $visitor->save();
            $request->session()->flash('message', 'Password has updated');
            
            return redirect()->route('visitors.profile');
        } catch(\Exception $exception) {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }
    
    public function logout() {
        Auth::guard('visitor')->logout();
        
        return redirect('/home');
    }
    
    public function getcommentslist() {
        
        $data['comments'] = Comment::with('posts')->where(['visitor_id' => Auth::guard('visitor')->id()])->orderBy('id', 'desc')->paginate(15);
        
        return view('frontend.visitors.commentslist', $data);
    }
    
}
