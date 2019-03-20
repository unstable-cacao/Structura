<?php
namespace Structura;


class Strings
{
	public static function isStartsWith(string $source, string $start): bool 
	{
		if (!$start)
			return true;
		
		return substr($source, 0, strlen($start)) == $start;
	}
	
	public static function isEndsWith(string $source, string $end): bool
	{
		if (!$end)
			return true;
		
		return substr($source, -(strlen($end))) == $end;
	}
	
	public static function replace(string $subject, string $needle, string $with, int $limit = null): string 
	{
		if (is_null($limit))
			return str_replace($needle, $with, $subject);
		
		if (!$needle)
			return $subject;
		
		$subject = explode($needle, $subject, $limit + 1);
		
		return implode($with, $subject);
	}
	
	public static function endWith(string $source, string $end): string 
	{
		if (self::isEndsWith($source, $end))
			return $source;
		else
			return $source . $end;
	}
	
	public static function startWith(string $source, string $start): string 
	{
		if (self::isStartsWith($source, $start))
			return $source;
		else
			return $start . $source;
	}
	
	/**
	 * @deprecated Use trimStart instead
	 */
	public static function shouldNotStartWith(string $source, string $start): string
	{
		return self::trimStart($source, $start);
	}
	
	/**
	 * @deprecated Use trimEnd instead
	 */
	public static function shouldNotEndWith(string $source, string $end): string
	{
		return self::trimEnd($source, $end);
	}
	
	public static function trimStart(string $source, string $start): string
	{
		if (!self::isStartsWith($source, $start))
			return $source;
		else
			return substr($source, strlen($start));
	}
	
	public static function trimEnd(string $source, string $end): string
	{
		if (!self::isEndsWith($source, $end))
			return $source;
		else
			return substr($source, 0, strlen($source) - strlen($end));
	}
	
	public static function contains(string $haystack, string $needle): bool 
	{
		if (!$needle)
			return true;
		
		return strpos($haystack, $needle) !== false;
	}
}