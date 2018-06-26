<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionsController extends Controller
{

    /****************************************************************
     * SessionsController constructor.
     ****************************************************************/
    public function __construct(){
        $this->middleware('guest',['except'=>'destroy']);
    }

    /****************************************************************
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     ****************************************************************/
    public function create(){
        return view('sessions.create');
    }

    /****************************************************************
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     ****************************************************************/
    public function store(Request $request){
        $this->validate($request,[
           'email'      =>'required|email',
           'password'   =>'required|min:6',
        ]);

        if(!auth()->attempt($request->only('email','password',$request->has('remember')))){
            //flash('Email or Password is not Correct!');
            //return back()->with();

            return $this->respondError('Email or Password is not Correct!');
        }

        if(!auth()->user()->activated){
            auth()->logout();
            flash('Check Sign Up!!');

            return back()->withInput();
        }


        $token  = is_api_domain()
	            ? jwt() ->attempt($request->only('email','password'))
	            : auth()->attempt($request->only('email','password'),$request->has('remember'));

	    if (! $token) {
		    if (\App\User::socialUser($request->input('email'))->first()) {
			    return $this->respondSocialUser();
		    }
	    }

        //flash('Welcome Laravel World ' . auth()->user()->name);
        //return redirect()->intended('home');

	    return $this->respondCreated($token);
    }


	protected function respondCreated($message)
	{
		flash(
			trans('auth.sessions.info_welcome', ['name' => auth()->user()->name])
		);
		return ($return = request('return'))
			? redirect(urldecode($return))
			: redirect()->intended(route('home'));
	}
    /****************************************************************
     * @param $message
     * @return \Illuminate\Http\RedirectResponse
     ****************************************************************/
    protected function respondError($message){
        flash()->error($message);

        return back()->withInput();
    }

    /****************************************************************
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     ****************************************************************/
    public function destroy(){
        auth()->logout();
        flash('See you next Time');

        return redirect('/');
    }
}
