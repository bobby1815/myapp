<?php
/**
 * Created by PhpStorm.
 * User: dongeon
 * Date: 18. 6. 26
 * Time: 오후 12:56
 */

namespace App;


trait EtagTrait{

	public function etag(\Illuminate\Database\Eloquent\Model $model, $cacheKey = null){
		$etag = '';

		if($model->usesTimestamps()){
			$etag .= $model->updated_at->timestamp;
		}

		return md5($etag.$cacheKey);
	}

	protected function etags($collection, $cacheKey = null){

		$etag   =   '';

		foreach ($collection as $instance){

			$etag .= $this->etag($instance);
		}

		return md5($etag.$cacheKey);
	}
}