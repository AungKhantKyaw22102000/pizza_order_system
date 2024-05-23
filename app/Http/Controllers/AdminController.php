<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // change password page
    public function changePasswordPage(){
        return view('admin.account.changePassword');
    }

    // change password
    public function changePassword(Request $request){

        // 1. all field must be fill
        // 2. new password & confrim password length must be greateer than 6
        // 3. new password & confrim password must be same
        // 4. old password must be same with db password
        // 5. password change

        $this->passwordValidationCheck($request);
        $currentUserId = Auth::user()->id;
        $user = User::select('password')->where('id',$currentUserId)->first();
        $dbPassword = $user->password;

        if(Hash::check($request->oldPassword, $dbPassword)){
            User::where('id', $currentUserId)->update([
                'password' => Hash::make($request->newPassword)
            ]);
            // Auth::logout();
            // return redirect()->route('auth#loginPage');

            return back()->with(['changeSuccess'=>'Password Changed Success...']);
        }
        return back()->with(['notMatch' => 'The Old Password Not Match. Try Again!']);
    }

    // account details direct page
    public function details(){
        return view('admin.account.details');
    }

    // direct admin profile page
    public function edit(){
        return view('admin.account.edit');
    }

    // update account
    public function update($id, Request $request){
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);

        // for image
        if($request->hasFile('image')){
            // 1. old image name | 2. check => delete | 3. store
            $dbImage = User::where('id',$id)->first();
            $dbImage = $dbImage->image;

            if($dbImage != null){
                Storage::delete('public/'.$dbImage);
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public',$fileName);
            $data['image'] = $fileName;
        }
        User::where('id',$id)->update($data);
        return redirect()->route('admin#details')->with(['updateSuccess'=>'Admin Account Updated']);
    }

    // admin list
    public function list(){
        $admin = User::when(request('key'),function($query){
                    $query->orWhere('name','like','%'.request('key').'%')
                          ->orWhere('email','like','%'.request('key').'%')
                          ->orWhere('gender','like','%'.request('key').'%')
                          ->orWhere('address','like','%'.request('key').'%')
                          ->orWhere('phone','like','%'.request('key').'%');
                })
                ->where('role','admin')->paginate(3);
        $admin->appends(request()->all());
        return view('admin.account.list', compact('admin'));
    }

    // delete account
    public function delete($id){
        User::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>'Admin Account Deleted...']);
    }

    // change role
    public function changeRole($id){
        $account = User::where('id',$id)->first();
        return view('admin.account.changeRole', compact('account'));
    }

    // change
    public function change($id, Request $request){
        $data = $this->requestUserData($request);
        User::where('id',$id)->update($data);
        return redirect()->route('admin#list');
    }

    // ajax admin role
    public function adminRole(Request $request){
        $changeRole = User::where('id', $request->userId)->update([
            'role' => $request->status,
        ]);
        return response()->json($changeRole, 200);
    }

    // request user data
    private function requestUserData($request){
        return [
            'role' => $request->role
        ];
    }

    // request user data
    private function getUserData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'address' => $request->address
        ];
    }

    // account validation check
    private function accountValidationCheck($request){
        Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'image' => 'mimes:png,jpg,jpeg,webp|file',
            'address' => 'required',
        ],[])->validate();
    }

    // password validation check
    private function passwordValidationCheck($request){
        Validator::make($request->all(),[
            'oldPassword' => 'required|min:6',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|min:6|same:newPassword',
        ],[])->validate();
    }
}
