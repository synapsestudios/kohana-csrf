<?php defined('SYSPATH') or die('No direct script access.');

class CSRF {

	/**
	 * Returns the token in the session or generates a new one
	 *
	 * @param   string  $namespace - semi-unique name for the token (support for multiple forms)
	 * @return  string
	 */
	public static function token()
	{
		$token = Session::instance()->get('csrf-token');

		// Generate a new token if no token is found
		if ( ! $token)
		{
			$token = Text::random('alnum', rand(20, 30));
			Session::instance()->set('csrf-token', $token);
		}

		return $token['token'];
	}

	/**
	 * Validation rule for checking a valid token
	 *
	 * @param   string  $token - the token string to check for
	 * @return  bool
	 */
	public static function valid($token)
	{
		return $token === self::token();
	}
}
