<?php
namespace Structura\Cache;


class TimeoutCache implements IMonoCache
{
    /** @var callable|null */
    private $getter;
    
    /** @var float */
    private $ttl;
    
    /** @var float|null */
    private $timeoutAt = null;
    
    /** @var mixed|null */
    private $cachedObject = null;
    
    
    private function now(): float 
    {
        return microtime(true);
    }
    
    private function isTimedOut(): bool 
    {
        return ($this->now() > $this->timeoutAt);
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
            return $this->cachedObject;
        }
        else if (!$this->getter)
        {
            throw new \Exception("Getter must be provided.");
        }
        else
        {
            $getter = $this->getter;
            $this->put($getter());
            
            return $this->cachedObject;
        }
	}
	
	public function put($value, ?float $ttl = null): void
	{
		$this->cachedObject = $value;
		
		if (!is_null($ttl))
        {
            $this->ttl = $ttl;
        }
        
        $this->timeoutAt = $this->now() + $this->ttl;
	}
	
	public function has(): bool
	{
		return ($this->cachedObject && !$this->isTimedOut());
	}
	
	public function clear(): void
	{
		$this->cachedObject = null;
		$this->timeoutAt = null;
	}
}