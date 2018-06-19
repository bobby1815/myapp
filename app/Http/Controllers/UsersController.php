<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct(){
        $this->middleware('guest');
    }

    /******************************************************************************
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @Description User create
     ******************************************************************************/
    public function create(){
        return view('users.create');
    }

    /******************************************************************************
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @Description User Resigter Action
     ******************************************************************************/
    public function store(Request $request){

    	if ($socialUser = User::socialUser($request->get('email'))->first()) {
		    return $this->updateSocialAccount($request, $socialUser);
	    }

	    return $this->createNativeAccount($request);
    }

	/******************************************************************************
	 * @param Request $request
	 * @param \App\User $user
	 * @return mixed
	 ******************************************************************************/
    protected function updateSocialAccount(Request $request, \App\User $user){

    	$this->validate($request, [
		    'name' => 'required|max:255',
		    'email' => 'required|email|max:255',
		    'password' => 'required|confirmed|min:6',
	    ]);

	    $user->update([
		    'name' => $request->input('name'),
		    'password' => bcrypt($request->input('password')),
	    ]);

	    auth()->login($user);

	    return $this->respondCreated('Welcome! ' . $user->name);
    }

    /******************************************************************************
     * @ function
     * @param $code
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector*
     * @Descriptjon User Confirm Register
     ******************************************************************************/
    public function confirm($code){

        $user = \App\User::whereConfirmCode($code)->first();
        if (! $user) {
            return $this->respondError('URL is not Exist!');
        }



        $user->activated    =1;
        $user->confirm_cdoe =null;
        $user->save();

        auth()->login($user);
        flash('Welcome to Laravel World! Enjoy it!'. auth()->user()->name);

        return redirect('home');

    }

    /******************************************************************************
     * @param $message
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @Description Action After Create User
     ******************************************************************************/
    public function  respondError($message){
        flash()->error($message);
        return redirect('/');
    }

    /**
     * @param $message
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function respondCreated($message)
    {
        flash($message);
        return redirect('/');
    }

}
