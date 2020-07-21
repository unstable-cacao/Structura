<?php
if (!defined('START_OF_TIME')) define('START_OF_TIME', '1970-01-01 00:00:00');
if (!defined('END_OF_TIME')) define('END_OF_TIME', '3999-12-31 23:59:59');


if (!function_exists('get_time'))
{
	/**
	 * @param string|int|null $value
	 * @param string $format
	 * @return string
	 */
	function get_time($value = null, string $format = \Structura\Time::DEFAULT_FORMAT): string
	{
		return \Structura\Time::get($value, $format);
	}
}

if (!function_exists('now'))
{
	function now(): string
	{
		return \Structura\Time::now();
	}
}