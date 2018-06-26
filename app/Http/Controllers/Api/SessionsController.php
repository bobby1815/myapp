<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\SessionsController as ParentController;
use Illuminate\Http\Request;


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

		protected function sendLockoutResponse (Request $request) {

			$seconds = app(\Illuminate\Cache\RateLimiter::class)->availableIn(
				$this->throttleKey($request)
			);

			return json()->tooManyRequestsError("account_locked:for_{$seconds}_sec");
		}

	}
