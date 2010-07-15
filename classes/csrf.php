<?php defined('SYSPATH') or die('No direct script access.');

class CSRF {

	public static $expiration = '+5 minutes';

	/**
	 * Returns the token in the session or generates a new one
	 *
	 * @param   string  $namespace - semi-unique name for the token (support for multiple forms)
	 * @param   mixed   $expiration - a timestamp or a strtotime-able string (ex: '5 minutes', defaults to self::$expiration
	 * @param   bool    $new - Wether or not to forcefully create a new token
	 * @return  string
	 */
	public static function token($namespace = 'default', $expiration = NULL, $new = FALSE)
	{
		($expiration === NULL) AND $expiration = self::$expiration;
		( ! is_int($expiration)) AND $expiration = strtotime($expiration);

		$token = Session::instance()->get('csrf-token-'.$namespace);

		// Generate a new token if no token is found, $new is true, or the current one expired
		if ( ! $token OR $new OR $token['expires'] < time())
		{
			$token = array
			(
				'token'   => Text::random('alnum', 10),
				'expires' => strtotime(self::$expiration),
			);
			Session::instance()->set('csrf-token-'.$namespace, $token);
		}

		return $token['token'];
	}

	/**
	 * Validation rule for checking a valid token
	 *
	 * @param   string  $namespace - the semi-unique identifier specified when getting the token
	 * @param   string  $token - the token string to check for
	 * @return  bool
	 */
	public static function valid($namespace = 'default', $token)
	{
		return $token === self::token($namespace);
	}
}
