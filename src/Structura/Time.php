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
	
	private static function startOfFirstWeek(string $date): string
	{
		$firstDay = self::dayOfWeek($date);
		$result = $date;
		
		if ($firstDay >= 4)
		{
			$result = self::get("$date next sunday", 'Y-m-d');
		}
		else if ($firstDay > 0)
		{
			$result = self::get("$date last sunday", 'Y-m-d');
		}
		
		return $result;
	}
	
	
	protected static function dayOfWeek(string $date): int
	{
		return self::get($date, 'w');
	}
	
	protected static function weekOfYearMondayBased(string $date): int
	{
		return self::get($date, 'W');
	}
	
	protected static function weekOfYearSundayBased(string $date): int
	{
		$firstDate = self::get($date, 'Y-01-01');
		$firstDateLastYear = self::get("$firstDate -1 year", 'Y-m-d');
		$firstDateNextYear = self::get("$firstDate +1 year", 'Y-m-d');
		
		$formatted = self::get($date, 'Y-m-d');
		
		$firstDate = self::startOfFirstWeek($firstDate);
		$firstDateNextYear = self::startOfFirstWeek($firstDateNextYear);
		
		// for example 2000-12-31 should be part of next year
		if ($formatted >= $firstDateNextYear)
		{
			$firstDate = $firstDateNextYear;
		}
		// for example 2000-01-01 should be part of last year
		else if ($firstDate > $formatted)
		{
			$firstDate = self::startOfFirstWeek($firstDateLastYear);
		}
		
		$timestamp = strtotime($formatted);
		$firstTimestamp = strtotime($firstDate);
		
		$seconds = $timestamp - $firstTimestamp;
		$days = $seconds / (60 * 60 * 24);
		
		return floor($days / 7) + 1;
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
	
	public static function weekOfYear(string $date = 'now', bool $isSundayBased = false): int
	{
		if ($isSundayBased)
			return self::weekOfYearSundayBased($date);
		else
			return self::weekOfYearMondayBased($date);
	}
}