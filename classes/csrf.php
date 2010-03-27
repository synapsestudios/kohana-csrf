<?php defined('SYSPATH') or die('No direct script access.');

class CSRF {

	/**
	 * Returns the token in the session or generates a new one
	 *
	 * @return string
	 */
	public static function token()
	{
		$token = Session::instance()->get('csrf-token');
		if ( ! $token)
		{
			$token = Text::random('alnum', 10);
			Session::instance()->set('csrf-token', $token);
		}

		return $token;
	}

	/**
	 * Validation rule for checking a valid token
	 *
	 * @return bool
	 */
	public static function valid($token)
	{
		return $token === self::token();
	}

}
