<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model{

	/********************************************************************************************
	 * @var array
	 * @Description
	 ********************************************************************************************/
	protected $fillable = ['commentable_type','commentable_id','user_id','parent_id','content',];


	/********************************************************************************************
	 * @var array
	 * @Description
	 ********************************************************************************************/
	protected $with = ['user','votes',];

	/********************************************************************************************
	 * @var array
	 ********************************************************************************************/
	protected $appends = ['up_count','down_count',];

	/********************************************************************************************
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 * @Description
	 ********************************************************************************************/
	public function user() {

		return $this->belongsTo(User::class);
	}

	/********************************************************************************************
	 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
	 * @Description
	 ********************************************************************************************/
	public function commentable(){

		return $this->morphTo();
	}

	/********************************************************************************************
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder
	 * @Description
	 ********************************************************************************************/
	public function replies(){

		return $this->hasMany(Comment::class, 'parent_id')->latest();
	}

	/********************************************************************************************
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 * @Description Comment parent_id
	 ********************************************************************************************/
	public function parent(){

		return $this->belongsTo(Comment::class,'parent_id', 'id');
	}

	/********************************************************************************************
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 ********************************************************************************************/
	public function  votes(){

		return $this->hasMany(Vote::class);
	}


	/********************************************************************************************
	 * @return int
	 * @Description Vote  up
	 ********************************************************************************************/
	public function getUpCountAttribute(){

		return (int)$this->votes()->sum('up');
	}

	/********************************************************************************************
	 * @return int
	 * @Description Vote Down
	 ********************************************************************************************/
	public function getDownCountAttribute(){

		return (int)$this->votes()->sum('down');
	}

}
