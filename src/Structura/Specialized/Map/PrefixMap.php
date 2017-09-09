<?php
namespace Structura\Specialized\Map;


use Structura\Exceptions\StructuraException;


class PrefixMap
{
	public function __construct(int $prefixLength = 3)
	{
		if ($prefixLength < 1)
			throw new StructuraException("Prefix must be greater then 1. Got $prefixLength instead");
	}


	public function has(string $prefix): bool
	{
		
	}
	
	/**
	 * @param string $prefix
	 * @return mixed|null
	 */
	public function get(string $prefix)
	{
		
	}
	
	public function tryGet(string $prefix, &$value): bool
	{
		
	}

	/**
	 * @param string $prefix
	 * @param mixed $value
	 */
	public function add(string $prefix, $value)
	{
		
	}
	
	public function remove(string $prefix): bool
	{
		
	}

	/**
	 * @param string $longKey
	 * @return mixed|null
	 */
	public function hasFor(string $longKey)
	{
		
	}
	
	/**
	 * @param string $longKey
	 * @return mixed|null
	 */
	public function find(string $longKey)
	{
		
	}
	
	public function tryFind(string $longKey, &$value): bool
	{
		
	}
}