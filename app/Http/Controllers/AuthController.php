<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    
    public function register(Request $request)
    {
        $valid = Validator::make($request->all(),[
            'name'=>'required|max:191',
            'email'=>'required|email|max:191|unique:users,email',
           'password'=>'required|confirmed',
            'age'=>'required',
            'gender'=>'required',
            'image'=>'required|image'
        ]);
        if ($valid->fails()) return back()->with('errors',$valid->errors());

     
        $request['password'] = Hash::make($request['password']);

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('profile_pic'), $imageName);

        $user=$request->all();

        $user['image'] = $imageName;

     
        $user = User::create($user);
        auth()->loginUsingId($user->id);
        return redirect('/');
    }

    public function login(Request $request)
    {
        $valid = Validator::make($request->all(),[
            'email'=>'required|exists:users,email',
            'password'=>'required',
        ]);
        if ($valid->fails()) return back()->with('errors',$valid->errors());

        $cred = $request->only(['email','password']);
        if (auth()->attempt($cred)){
            return redirect('/');
        }
        return back()->with('error','Invalid Email Or Password');
    }


    public function editprofile(User $user)
    {
        return view('editprofile',compact('user'));
    }
    
    public function updateprofile($id, Request $request)
    {
        if (!empty($request->image)) 
        {
            $user = User::find($id);

            unlink(public_path('profile_pic/'.$user->image));
            $imageName = time().'.'.$request->image->extension();

            $request->image->move(public_path('profile_pic'), $imageName);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->age = $request->age;          
            $user->gender = $request->gender;
            $user['image'] = $imageName;
            $user->update();

            return redirect('profile')->with('success', 'Profile Upadte With Image successfully.');

        } else {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->age = $request->age;   
            $user->gender = $request->gender;
            $user->update();

            return redirect('profile')->with('success', 'Your Profile Upadte successfully.');

        }
        
        
    }

    public function logout()
    {
        Auth::logout();
       
        return redirect()->route('login');
    }
}
