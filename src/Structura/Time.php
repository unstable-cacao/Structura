<?php
namespace Structura;


class Time
{
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
			return strtotime($time->format('Y-m-d H:i:s'));
		}
		else
		{
			return time();
		}
	}
	
	
	public static function now(): string
	{
		return date('Y-m-d H:i:s');
	}
	
	public static function get($time): string
	{
		$time = self::formatTime($time);
		return date('Y-m-d H:i:s', $time);
	}
}