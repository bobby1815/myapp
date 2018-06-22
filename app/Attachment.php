<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model{

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'filename',
		'bytes',
		'mime',
	];
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'article_id',
		'created_at',
		'updated_at',
	];
	/**
	 * The accessors to append to the model's array form.
	 *
	 * @var array
	 */
	protected $appends = [
		'url',
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function article(){
		return $this->belongsTo(Article::class);
	}

	/**
	 * @param $value
	 * @return string
	 */
	public function getBytesAttribute($value){

		return format_filesize($value);
	}

	/**
	 * @return \Illuminate\Contracts\Routing\UrlGenerator|string
	 */
	public function getUrlAttribute(){

		return url('files/'.$this->filename);
	}
}
