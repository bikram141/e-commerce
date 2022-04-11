<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\Admin;
use Hash;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.admin_dashboard');
    }
    public function settings(){
        return view('admin.admin_settings');
    }
    public function login(Request $request){
        if($request->isMethod('post')){
            $data=$request->all();

            $rules=[
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];
            $customMessages=[
                'email.required'=>"Email is required",
                'email.email'=>'Valid email is required',
                'password.required'=>'password is required',
            ];
            $this->validate($request, $rules, $customMessages);
            // $validated = $request->validate([
            //     'email' => 'required|email|max:255',
            //     'password' => 'required',
            // ]);

            if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password']])){
                return redirect('admin/dashboard');
            }
                else{
                    Session::flash('error_message','Invalid Email or Password');
                    return redirect()->back();
                }
        }
        // echo $password = Hash::make('Admin@1234'); die;
        return view('admin.admin_login');
    }
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }
    public function chkCurrentPassword(Request $request){
        $data=$request->all();
        // echo "<pre>"; print_r($data);die;
        if(Hash::check($data['current_pwd'],Auth::guard('admin')->user()->password)){
            echo "true";
        }else{
            echo "false";
        } 
    }
    public function updateCurrentPassword(Request $request){
        if($request->isMethod('post')){
            $data=$request->all();
            if(Hash::check($data['current_pwd'],Auth::guard('admin')->user()->password)){ 
                if($data['new_pwd']==$data['confirm_pwd']){
                    Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_pwd'])]);
                    Session::flash('success_message','Password has been update successfully!');
                }else{
                    Session::flash('error_message','New password and confirm password not match');
                }
            }else{
                Session::flash('error_message','Your Current password is incorrect');    
            }
            return redirect()->back();
        }
    }
}
