<?php
namespace Structura\Cache;


class TimeoutCache implements IMonoCache
{
	public function __construct(float $ttlSec = 1.0, ?callable $getter = null)
	{
	}
	
	
	public function setGetter(callable $getter): void
	{
		
	}
	
	public function setTtl(float $sec): void
	{
		
	}
	
	public function getTtl(): float
	{
		
	}
	
	public function get()
	{
		
	}
	
	public function put($value, ?float $ttl = null): void
	{
		
	}
	
	public function has(): bool
	{
		
	}
	
	public function clear(): void
	{
		
	}
}