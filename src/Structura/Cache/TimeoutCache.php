<?php
namespace Structura\Cache;


class TimeoutCache implements IMonoCache
{
    /** @var callable|null */
    private $getter;
    
    /** @var float */
    private $ttl;
    
    /** @var float|null */
    private $timeOfCache = null;
    
    /** @var mixed|null */
    private $cachedObject = null;
    
    
    private function now(): float 
    {
        return microtime(true);
    }
    
    private function timeout(): bool 
    {
        return ($this->now() > $this->timeOfCache + $this->ttl);
    }
    
    
	public function __construct(float $ttlSec = 1.0, ?callable $getter = null)
	{
	    $this->ttl = $ttlSec;
	    $this->getter = $getter;
	}
	
	
	public function setGetter(callable $getter): void
	{
		$this->getter = $getter;
	}
	
	public function setTtl(float $sec): void
	{
		$this->ttl = $sec;
	}
	
	public function getTtl(): float
	{
		return $this->ttl;
	}
	
	public function get()
	{
        if ($this->has()) 
        {
            return $this->getter ? $this->getter($this->cachedObject) : $this->cachedObject;
        }
        else
        {
            return null;
        }
	}
	
	public function put($value, ?float $ttl = null): void
	{
		$this->timeOfCache = $this->now();
		$this->cachedObject = $value;
		
		if (!is_null($ttl))
        {
            $this->ttl = $ttl;
        }
	}
	
	public function has(): bool
	{
		return ($this->cachedObject && !$this->timeout());
	}
	
	public function clear(): void
	{
		$this->cachedObject = null;
		$this->timeOfCache = null;
	}
}