<?php
define('START_OF_TIME', '1970-01-01 00:00:00');
define('END_OF_TIME', '3999-12-31 23:59:59');


if (!function_exists('get_time'))
{
	/**
	 * @param string|int|null $value
	 * @return string
	 */
	function get_time($value = null): string
	{
		return \Structura\Time::get($value);
	}
}

if (!function_exists('now'))
{
	function now(): string
	{
		return \Structura\Time::now();
	}
}