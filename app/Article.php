<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model{

    protected $fillable = ['title','content'];

    protected  $with =['user',];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tags(){

        return $this->belongsToMany(Tag::class);
    }

    public function attachments(){

    	return $this->hasMany(Attachment::class);
    }

/*    public function comments(){
	    return $this->morphToMany(Comment::class, "commentable", "comments", $relationName = "commentable_id", $relatedPivotKey = "id");
//    return $this->morphToMany(Comment::class, "commentable", "comments", "commentable_id", "commentable_type");
    }*/

	public function comments() {
		return $this->morphMany(Comment::class, 'commentable');
	}


}
