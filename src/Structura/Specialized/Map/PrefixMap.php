<?php
namespace Structura\Specialized\Map;


use Structura\Exceptions\StructuraException;


class PrefixMap
{
    /** @var array */
    private $map = [];
    
    /** @var int */
    private $prefixLength;
    
    
    private function getCoolingPrefix(string $string): string 
    {
        return substr($string, 0, $this->prefixLength);
    }
    
    private function getFirstMatchedKey(string $fullString, string $coolingPrefix): ?string 
    {
        foreach ($this->map[$coolingPrefix] as $key => $item) 
        {
            if (substr($fullString, 0, strlen($key)) == $key)
                return $key;
        }
        
        return null;
    }
    
    
	public function __construct(int $prefixLength = 3)
	{
		if ($prefixLength < 1)
			throw new StructuraException("Prefix must be greater then 1. Got $prefixLength instead");
		
		$this->prefixLength = $prefixLength;
	}


	public function has(string $prefix): bool
	{
	    $coolingPrefix = $this->getCoolingPrefix($prefix);
	    
		return key_exists($coolingPrefix, $this->map) && key_exists($prefix, $this->map[$coolingPrefix]);
	}
	
	/**
	 * @param string $prefix
	 * @return mixed|null
	 */
	public function get(string $prefix)
	{
		return $this->has($prefix) ? $this->map[$this->getCoolingPrefix($prefix)][$prefix] : null;
	}
	
	public function tryGet(string $prefix, &$value): bool
	{
        $value = $this->get($prefix);
        return $this->has($prefix);
	}

	/**
	 * @param string $prefix
	 * @param mixed $value
	 */
	public function add(string $prefix, $value)
	{
		$this->map[$this->getCoolingPrefix($prefix)][$prefix] = $value;
	}
	
	public function remove(string $prefix): bool
	{
		if ($this->has($prefix))
        {
            unset($this->map[$this->getCoolingPrefix($prefix)][$prefix]);
            return true;
        }
        else
        {
            return false;
        }
	}

	public function hasFor(string $longKey): bool
	{
	    $coolingPrefix = $this->getCoolingPrefix($longKey);
	    
		if (!key_exists($coolingPrefix, $this->map))
            return false;
        else if (key_exists($longKey, $this->map[$coolingPrefix]))
            return true;
        else if ($this->getFirstMatchedKey($longKey, $coolingPrefix))
            return true;
        else
            return false;
	}
	
	/**
	 * @param string $longKey
	 * @return mixed|null
	 */
	public function find(string $longKey)
	{
	    $coolingPrefix = $this->getCoolingPrefix($longKey);
	    
		if ($this->has($longKey))
		    return $this->map[$coolingPrefix][$longKey];
		else if ($this->hasFor($longKey))
		    return $this->map[$coolingPrefix][$this->getFirstMatchedKey($longKey, $coolingPrefix)];
		else
		    return null;
	}
	
	public function tryFind(string $longKey, &$value): bool
	{
		$value = $this->find($longKey);
		return $this->hasFor($longKey);
	}
}