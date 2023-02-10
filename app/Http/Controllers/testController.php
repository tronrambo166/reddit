<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Models\Likecomm;
use Mail;

class testController extends Controller
{
   


	
 public function login() {
    return view('auth.login');
    //return view('home');
}



//** Forgot

public function forgot($remail)
    { 

         return view('auth.forgot_password',compact('remail'));
     
    }


public function send_reset_email(Request $request)
    {

        $remail=$request->email;   
        

        // Send Email

        $info=['Name'=>'Dele', 'email' => $remail];
        $user['to']= $remail;
        Mail::send('auth.mail', $info, function($msg) use ($user){

            $msg->to($user['to']);
            $msg->subject('Test Mail');

        });

        echo "Check your email"; exit;

        // Send Email

    }


public function reset(Request $request, $remail)
    { 
       echo "hello";
       $email=$remail;
       $password_1=$request->password; 
       $password=$request->c_password; 

       if($password_1==$password) {
     $password_1= Hash::make($password_1);
     $update= DB::table('admins')->where('email', $email)
     -> limit(1)->update(['password'=> $password_1]);

     if($update) {Session::put('reset', 'password reset success!');return redirect('/login'); }
       }    
          else {
            Session::put('wrong_pwd', 'password do not match! try again');
          return redirect()->back();
      }

    }





}
