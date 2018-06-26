<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\SessionsController as ParentController;


	class SessionsController extends ParentController {

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
