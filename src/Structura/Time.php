<?php
namespace Structura;


class Time
{
	public const DEFAULT_FORMAT = 'Y-m-d H:i:s';
	
	
	private static function formatTime($time): int
	{
		if (is_numeric($time))
		{
			return (int)$time;
		}
		else if (is_string($time))
		{
			return strtotime($time);
		}
		else if ($time instanceof \DateTime)
		{
			return strtotime($time->format(self::DEFAULT_FORMAT));
		}
		else
		{
			return time();
		}
	}
	
	
	public static function now(): string
	{
		return date(self::DEFAULT_FORMAT);
	}
	
	/**
	 * @param string|int|null $time
	 * @param string $format
	 * @return string
	 */
	public static function get($time = null, string $format = self::DEFAULT_FORMAT): string
	{
		$time = self::formatTime($time);
		return date($format, $time);
	}
}