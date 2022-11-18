<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\User;
use Auth;
use App\Rules\MatchOldPassword;
use Hash;

class ProfileController extends Controller
{
    public function edit(){
        return view('profile.edit');
    }
    
    public function update(Request $request){
        $request->validate([
            "profile_photo"=>"required|mimes:png,jpg,jpeg",
        ]);
        $file=$request->file('profile_photo');
        $newFileName=uniqid().'_Profile_'.$file->getClientOriginalName();
        $dir="/public/profile";
        // Storage::putFileAs($dir,$file,$newFileName);
        $file->storeAs($dir,$newFileName);
        $user=User::find(Auth::id());
        $user->photo=$newFileName;
        $user->update();
        return redirect()->route('profile.edit');
    }

    public function changePassword(Request $request){
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
        // User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        $user =new User();
        $current_user=$user->find(Auth::id());
        $current_user->password=Hash::make($request->new_password);
        $current_user->update();

        Auth::logout();
        return redirect()->route('login');
    }
}