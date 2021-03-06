<?php
namespace Structura;


use Structura\Exceptions\StructuraException;


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
	
	/**
	 * @deprecated Use append instead
	 */
	public static function endWith(string $source, string $end): string 
	{
		return self::append($source, $end);
	}
	
	public static function append(string $source, string $end): string
	{
		if (self::isEndsWith($source, $end))
			return $source;
		else
			return $source . $end;
	}
	
	/**
	 * @deprecated Use prepend instead
	 */
	public static function startWith(string $source, string $start): string 
	{
		return self::prepend($source, $start);
	}
	
	public static function prepend(string $source, string $start): string
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
	
	/**
	 * @param string $source
	 * @param int|array $index In case of array, used as array of index and length
	 * @param int $length
	 * @return string
	 */
	public static function cut(string $source, $index, int $length = 1): string 
	{
		if (!$source)
			return $source;
		
		if (is_array($index))
		{
			if (count($index) != 2)
				throw new StructuraException("Array of parameters must contain 2 values");
			
			$length = $index[1] ?? 1;
			$index = $index[0] ?? 0;
		}
		
		if (!is_int($index))
			throw new StructuraException("Value of index must be integer");
		
		if (!$length)
		{
			$length = 1;
		}
		
		if (!is_int($length))
		{
			return $source;
		}
		
		$sourceLength = strlen($source);
		
		if ($index > $sourceLength)
			return $source;
		
		if ($index + $length > $sourceLength)
			return mb_substr($source, 0, $index);
		else
			return mb_substr($source, 0, $index) . mb_substr($source, $index + $length);
	}
}