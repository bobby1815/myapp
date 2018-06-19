<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'activated','confirm_cdoe','name', 'email', 'password',
    ];

    /**
     * The attributes that should be date for arrays.
     *
     * @var array
     */
    protected $dates = ['last_login'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','confirm_code'
    ];

    /**
     * The attributes that should be casts for arrays.
     *
     * @var array
     */
    protected $casts = ['activated'=>'boolean',];

    public function articles(){

        return $this->hasMany(Article::class);
    }

	public function scopeSocialUser($query, $email){

    	return $query->where($email)->whereNull('password');
	}


}
