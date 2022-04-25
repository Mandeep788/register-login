<?php

namespace App\Http\Controllers;
                                                                       
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function register(Request $request){ 
       $request->validate([
           'name'=>'required',
           'email'=>'required|email',
           'password'=>'required|confirmed',
           'tc'=>'required',
       ]);
       if(User::where('email',$request->email)->first()){
           return response([
               'message'=>'email already exists',
               'status'=>'failed',
           ],200);
       }
       $users = User::create([
           'name'=>$request->name,
           'email'=>$request->email,
           'password'=>hash::make($request->password),
           'tc'=>json_decode($request->tc),
       ]);
       $token = $users->createToken($request->email)->plainTextToken;

       return response([
           'token'=>$token,
        'message'=>'Registration succesfully',
        'status'=>'success',
    ],201);

    }
    
    public function login(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);
        $users = User::where('email',$request->email)->first();
        if($users && Hash::check($request->password,$users->password)){
            $token = $users->createToken($request->email)->plainTextToken;
            return response([
                'token'=>$token,
                'message'=>'Login succesfully',
                'status'=>'success',
         ],200);
        }
        return response([
         'message'=>'the provided credential are incorrect',
         'status'=>'failed',
     ],401);
    }

    public function logout(){
        auth()->users()->tokens()->delete();
        return response([
            'message'=>'logout successfully',
            'status'=>'success',
        ],200);
    }

    public function logged_user(){
        $loggeduser = auth()->users();
        return response([
            'message' => 'logged user data',
            'status' => 'success'
        ]);
    }

    public function change_password(Request $request){
        $request->validate([
            'password' => 'required|confirmed',
        ]);
        $loggeduser = auth()->users();
        $loggeduser->password = Hash::make($request->password);
        $loggeduser->save();
        return response([
            'message' => 'password change successfully',
            'status' => 'success'
        ],200);
    }
}
