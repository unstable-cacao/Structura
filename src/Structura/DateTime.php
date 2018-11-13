<?php
namespace Structura;


class DateTime
{
	/**
	 * @param string|int $value
	 */
	public function __construct($value)
	{
	}
	
	public function __debugInfo()
	{
		return [
			'time' => 'mysql time format',
			'timzone' => 'utc'
		];
	}
	
	public function __toString()
	{
		return '';
	}
	
	public function __clone()
	{
		
	}
	
	/**
	 * @param string|int $value
	 */
	public function add($value): void
	{
		
	}
	
	public function set($value): void
	{
		
	}
	
	
	public function getTimezone(): string
	{
		
	}
	
	public function setTimezone(): string
	{
		
	}
	
	public function addMilliseconds(float $value): void
	{
		
	}
	
	public function addSeconds(float $value): void
	{
		
	}
	
	public function addMinutes(float $value): void
	{
		
	}
	
	public function addHours(float $value): void
	{
		
	}
	
	public function addDays(float $value): void
	{
		
	}
	
	public function setMilliseconds(int $value): void
	{
		
	}
	
	// TODO: month, year, week (excluding set)
	
	public function setDayOfMonth(int $value)
	{
		
	}
	
	/**
	 * @param int $value 0 - Sunday -> 7 - Sunday 
	 */
	public function setDayOfWeek(int $value)
	{
		
	}
	
	public function setDayOfYear(int $value)
	{
		
	}
	
	public function getSeconds(): int
	{
		
	}
	
	public function getMinutes(): int
	{
		
	}
	
	public function getDayOfWeek(): int
	{
		
	}
	
	// TODO: add all misisng
	
	/**
	 * @param string $format Default should be MySQL (don't forget about ms) 
	 * @return string
	 */
	public function toString(string $format = ''): string
	{
		
	}
	
	/**
	 * @param string|int|DateTime $value
	 * @return bool
	 */
	public function isAfter($value): bool
	{
		
	}
	
	public function isBefore($value): bool 
	{
		
	}
	
	public function isEquals($value): bool
	{
		
	}
	
	
	/**
	 * @param string|int|DateTime $value
	 * @return int
	 */
	public function compare($value): int
	{
		// use <=>
	}
	
	
	/**
	 * @param string|int|DateTime $value
	 * @return bool
	 */
	public static function isDateAfter($a, $b): bool
	{
		
	}
	
	public static function isDateBefore($a, $b): bool 
	{
		
	}
	
	public static function isDateEquals($a, $b): bool
	{
		
	}
	
	/**
	 * @param string|int|DateTime $value
	 * @return int
	 */
	public static function compareDates($a, $b): int
	{
		// use <=>
	}
	
	/**
	 * @param DateTime|string|int $value
	 * @return DateTime
	 */
	public static function convert($value): DateTime
	{
		
	}
}