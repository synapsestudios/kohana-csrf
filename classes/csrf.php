<?php defined('SYSPATH') or die('No direct script access.');

class CSRF {

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

	public static function valid($token)
	{
		return $token === self::token();
	}

}
