<?php
namespace Structura;


class Arrays
{
	public static function toArray($data): array
	{
		$result = [];
		
		if (is_array($data))
		{
			$result = $data;
		}
		else if ($data instanceof ICollection)
		{
			$result = $data->toArray();
		}
		else if (is_iterable($data))
		{
			foreach ($data as $key => $item) 
			{
				$result[$key] = $item;
			}
		}
		else
		{
			$result = [$data];
		}
		
		return $result;
	}
	
	public static function asArray(&$data): array
	{
		$data = self::toArray($data);
		return $data;
	}
	
	public static function first(array $data)
	{
		if (!$data)
			return null;
		
		return reset($data);
	}
	
	public static function last(array $data)
	{
		if (!$data)
			return null;
		
		return end($data);
	}
	
	public static function isNumeric(array $data): bool
	{
		if (!$data)
			return true;
		
		return array_keys($data) === range(0, count($data) - 1);
	}
	
	public static function isAssoc(array $data): bool
	{
		if (!$data)
			return true;
		
		return array_keys($data) !== range(0, count($data) - 1);
	}
	
	public static function firstKey(array $data)
	{
		if (!$data)
			return null;
		
		reset($data);
		return key($data);
	}
	
	public static function lastKey(array $data)
	{
		if (!$data)
			return null;
		
		end($data);
		return key($data);
	}
	
	public static function mergeRecursiveAssoc(array $main, array ...$arrays): array 
	{
		foreach ($arrays as $array)
		{
			foreach ($array as $key => $value)
			{
				if (key_exists($key, $main))
				{
					if (is_array($value) && !key_exists(0, $value))
					{
						$main[$key] = self::mergeRecursiveAssoc($main[$key], $array[$key]);
					}
				}
				else
				{
					$main[$key] = $value;
				}
			}
		}
		
		return $main;
	}
}