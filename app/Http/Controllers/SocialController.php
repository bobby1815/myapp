<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SocialController extends Controller{


	/******************************************************************
	 * SocialController constructor.
	 ******************************************************************/
	public  function __construct () {

		$this->middleware('guest');
	}

	/******************************************************************
	 * @param Request $request
	 * @param $provider
	 * @return mixed
	 ******************************************************************/
	public function execute(Request $request , $provider){

		if(! $request->has('code')){
			return $this->redirectToProvider($provider);
		}

		return $this->handleProviderCallback($provider);
	}


	/******************************************************************
	 * @param $provider
	 * @return mixed
	 ******************************************************************/
	protected function redirectToProvider($provider){

		return \Socialite::driver($provider)->redirect();
	}


	/******************************************************************
	 * @param $provider
	 * @return mixed
	 ******************************************************************/
	protected function handleProviderCallback($provider){

		$user = \Socialite::driver($provider)->user();
		$user = (\App\User::whereEmail($user->getEmail())->first())
			?: \App\User::create([
				'name'  => $user->getName() ?: 'unknown',
				'email' => $user->getEmail(),
				'activated' => 1,
			]);
		auth()->login($user);
		/*flash(
			trans('auth.sessions.info_welcome', ['name' => auth()->user()->name])
		);*/
		flash('Welcome! ' . auth()->user()->name);
		return redirect(route('home'));

	}

}
