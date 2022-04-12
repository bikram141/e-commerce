<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\Admin;
use Hash;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    public function dashboard(){
        Session::put('page','dashboard');
        return view('admin.admin_dashboard');
    }
    public function settings(){
        Session::put('page','settings');
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
    public function updateAdminDetails(Request $request){
        Session::put('page','update-admin-details');
      //  dd($request);
        if($request->isMethod('post')){
            $data=$request->all();
            // echo "<pre>";print_r($data); die;
            $rules=[
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'admin_mobile' => 'required|numeric',
                'admin_image' => 'image'
            ];
            $customMessages=[
                'admin_name.required'=>"Name is required",
                'admin_name.alpha'=>'Valid name is required',
                'admin_mobile.required'=>"mobile number is required",
                'admin_mobile.numeric'=>'Valid mobile is required',
                'admin_image.image' =>'valid image is required',
            ];
            $this->validate($request, $rules, $customMessages);
           
            //upload images
    
            if($request->hasFile('admin_image')){
                $image_tmp = $request->file('admin_image');
                if($image_temp->isValid()){
                    $extension = $image_temp->getClientOriginalExtension();
                    $imageName=rand(111,99999).'.'.$extension;
                    $imagePath='images/admin_images/admin_photos/'.$imageName;
                    Image::make($image_temp)->save($imagePath);
                }else if(!empty($data['current_admin_image'])){
                    $imageName=$data['current_admin_image'];
                }else{
                    $imageName="";
                }
            }
            //update admin details
            Admin::where('email',Auth::guard('admin')->user()->email)
            ->update(['name'=>$data['admin_name'],'mobile'=>$data['admin_mobile'],'image'=>$imageName]);
            Session::flash('success_message','Admin Details update successfully!');
            return redirect()->back();
        }
        return view('admin.update_admin_details');
    }
}
