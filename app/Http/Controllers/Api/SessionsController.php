<?php
/**
 * Created by PhpStorm.
 * User: dongeon
 * Date: 18. 6. 25
 * Time: 오후 5:42
 */

namespace App\Http\Controllers\Api\v1;

use \App\Http\Controllers\SessionsController as ParentsContorller;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class SessionsController extends Controllers{

	/**
	 * Make a success response.
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	protected function respondCreated($token)
	{
		return response()->json([
			'token' => $token,
		], 201, [], JSON_PRETTY_PRINT);
	}
}