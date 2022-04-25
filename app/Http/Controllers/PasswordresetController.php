<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\passwordreset;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Mail\Message;
use Carbon\Carbon;
class PasswordresetController extends Controller
{
    public function send_reset_parrword_email(Request $request){
        $request->validate([
            'email' => 'required|email',
        ]);

        $users = User::where('email',$request->email)->first();
        if(!$users){
            return response([
                'message'=>'Mail does not exists',
                'status'=>'failed',
            ],404);
        }
        $token = Str::random(60);

        passeordreset::create([
            'email' =>$request->email,
            'token' =>$token,
            'created_at'=>Carbon::now()        
        ]);

        dump("http://127.0.0.1:8000/api/user/reset".$token);

        Mail::send('reset',['token'=>$token],function(Message $message)){
            $message->subject('reset your password');
            $email->$_POST
        }
        return response([
            'message'=>'password reset email sent...chk email',
            'status'=>'success',
        ],404); 
    }
}
