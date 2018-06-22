<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model{

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id',
		'comment_id',
		'up',
		'down',
		'voted_at',
	];
	/**
	 * The attributes that should be visible in arrays.
	 *
	 * @var array
	 */
	protected $visible = [
		'user_id',
		'up',
		'down',
	];

	/*******************************************
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 *******************************************/
	public function comment(){

		return $this->belongsTo(Comment::class);
	}

	/*******************************************
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 *******************************************/
	public function user(){

		return $this->belongsTo(User::class);
	}

	/*******************************************
	 * @param $value
	 * @description Like Attribute
	 *******************************************/
	public function setUpAttribute($value){

		$this->attributes['up'] = $value ? 1 : null;
	}

	/*******************************************
	 * @param $value
	 * @description Unlike Attribute
	 *******************************************/
	public function setDownAttribute($value){

		$this->attributes['down'] = $value ? 1 : null;
	}
}
