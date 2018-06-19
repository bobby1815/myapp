<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UsersEventListener
{
    /******************************************************************************
     * Create the event listener.
     *
     * @return void
     ******************************************************************************/
    public function __construct()
    {
        //
    }

    /******************************************************************************
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     ******************************************************************************/
    public function handle(Login $event)
    {
        //
        $event->user->last_login = \Carbon\Carbon::now();

        return $event->user->save();
    }
    /******************************************************************************
     *
     * @param $event
     * @retun void
     ******************************************************************************/
    public function subscribe(\Illuminate\Events\Dispatcher $event){
        $event->listen(
            \App\Events\UserCreated::class,
            __CLASS__ . '@onUserCreated'
        );

        $event->listen(
        \App\Events\PasswordRemindCreated::class,
        __CLASS__ . '@onPasswordRemindCreated'
        );
    }


    /******************************************************************************
     *
     * @param $event
     * @retun void
     * @Description User Create Message
     ******************************************************************************/
    public function onUserCreated(\App\Events\UserCreated $event)
    {
        $user = $event->user;
        \Mail::send(
            'emails.auth.confirm',
            compact('user'),
            function ($message) use ($user) {
                $message->to($user->email);
                $message->subject(
                    sprintf('[%s] Check Sign up!', config('app.name'))
                );
            }
        );
    }

	/******************************************************************************
	 * @param \App\Events\PasswordRemindCreated $event
	 * @Description Password Reset Message
	 ******************************************************************************/
    public function onPasswordRemindCreated(\App\Events\PasswordRemindCreated $event){
	    Mail::send('email.password.reset',compact('tonken'),function ($message) use ($email){
		    $message->to($email);
		    $message->subject(
			    sprintf('[%s] Reset your password', config('app.name'))
		    );
	    });
    }

}
