<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasswordsController extends Controller
{

    /****************************************************************
     * PasswordsController constructor.
     ****************************************************************/
    public function __construct(){
        $this->middleware('guest');
    }

    /****************************************************************
     * @object view Controller
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     ****************************************************************/
    public function getRemind(){

        return view('passwords.remind');
    }

    /****************************************************************
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     ****************************************************************/
    public function postRemind(Request $request){

        $this->validate($request, ['email' => 'required|email|exists:users']);

        $email = $request->get('email');
        $token = str_random(64);

        \DB::table('password_reset')->insert([
            'email'         => $email,
            'token'         => $token,
            'created_ad'    => \Carbon\Carbon::now()->toDateString()
        ]);

        /*\Mail::send('email.password.reset',compact('tonken'),function ($message) use ($email){
           $message->to($email);
           $message->subject(
               sprintf('[%s] Reset your password', config('app.name'))
           );
        });*/
        event(new \App\Events\PasswordRemindCreated($email , $token));

        flash('We send email how to reset password! Check out your mail box');

        return redirect('/');
    }

    public function getReset($token = null){

        return view('passwords.rest',compact('token'));
    }
}
