<?php
namespace Structura;


use Structura\Exceptions\StructuraException;


class Map implements \IteratorAggregate, \ArrayAccess, \Countable, ICollection
{
	private $map = [];
	
	/** @var callable */
	private $transform;
	
	
	private function isValid($key): bool 
	{
		if (!is_string($key) && !is_int($key))
			return false;
		
		return true;
	}
	
	private function transformKey($key)
	{
		$transform = $this->transform;
		return $transform($key);
	}
	
	/**
	 * @param string|int $key
	 * @return bool
	 */
	private function hasKey($key): bool 
	{
		if (!$this->isValid($key))
			throw new StructuraException("Key of map must be string or int");
		
		return key_exists($key, $this->map);
	}
	
	/**
	 * @param iterable $traversable
	 * @return array
	 */
	private function iterableToArray($traversable): array
	{
		if (is_array($traversable))
			return $traversable;
		
		if ($traversable instanceof ICollection)
			return $traversable->toArray();
		
		$result = [];
		
		foreach ($traversable as $key => $value)
		{
			$result[$key] = $value;
		}
		
		return $result;
	}
	
	
	public function __construct(?iterable $traversable = null)
	{
		if ($traversable)
		{
			$this->merge($traversable);
		}
	}
	
	
	public function setTransform(?callable $transform = null): void
	{
		$this->transform = $transform;
	}
	
	public function getTransform(): ?callable
	{
		return $this->transform;
	}
	
	/**
	 * @param mixed $key
	 * @param mixed $value
	 */
	public function add($key, $value = null)
	{
		if ($this->transform)
			$key = $this->transformKey($key);
		
		if ($key instanceof IIdentified) 
		{
			$value = $key;
			$key = $value->id();
		} 
		else if (!$this->isValid($key))
			throw new StructuraException("Key of map must be string or int");
		
		$this->map[$key] = $value;
	}
	
	/**
	 * @param mixed $key
	 */
	public function remove($key)
	{
		if ($this->transform)
			$key = $this->transformKey($key);
		
		if (!$this->isValid($key))
			throw new StructuraException("Key of map must be string or int");
		
		unset($this->map[$key]);
	}
	
	/**
	 * @param mixed $key
	 * @return mixed
	 */
	public function get($key)
	{
		if ($this->transform)
			$key = $this->transformKey($key);
		
		if (!$this->hasKey($key))
			throw new StructuraException("Value with key $key was not found in map");
		
		return $this->map[$key];
	}
	
	public function getIfExists($key, $default = null)
	{
		if ($this->transform)
			$key = $this->transformKey($key);
		
		if (!$this->hasKey($key))
			return $default;
		
		return $this->map[$key];
	}
	
	public function tryGet($key, &$value): bool 
	{
		if ($this->transform)
			$key = $this->transformKey($key);
		
		if (!$this->isValid($key))
			throw new StructuraException("Key of map must be string or int");
		
		$value = $this->map[$key] ?? null;
		
		return $this->hasKey($key) ? true : false;
	}
	
	/**
	 * @param string|int $key
	 * @return bool
	 */
	public function has($key): bool 
	{
		if ($this->transform)
			$key = $this->transformKey($key);
		
		if (!$this->isValid($key))
			throw new StructuraException("Key of map must be string or int");
		
		return key_exists($key, $this->map);
	}
	
	public function hasAny(array $keys): bool 
	{
		foreach ($keys as $key) 
		{
			if ($this->has($key))
				return true;
		}
		
		return false;
	}
	
	public function hasAll(array $keys): bool 
	{
		foreach ($keys as $key)
		{
			if (!$this->has($key))
				return false;
		}
	
		return true;
	}
	
	public function count(): int 
	{
		return count($this->map);
	}
	
	public function isEmpty(): bool
	{
		return !(bool)$this->map;
	}
	
	public function hasElements(): bool
	{
		return (bool)$this->map;
	}
	
	public function clear()
	{
		$this->map = [];
	}
	
	public function keys(): array
	{
		return array_keys($this->map);
	}
	
	public function values(): array
	{
		return array_values($this->map);
	}
	
	public function keysSet(): Set
	{
		return new Set($this->keys());
	}
	
	/**
	 * @param iterable[] ...$map
	 * @return Map
	 */
	public function merge(...$map): Map
	{
		foreach ($map as $singleItem) 
		{
			foreach ($singleItem as $key => $value) 
			{
				$this->add($key, $value);
			}
		}
		
		return $this;
	}
	
	/**
	 * @param iterable[] ...$map
	 * @return Map
	 */
	public function intersect(...$map): Map
	{
		foreach ($map as $traversable)
		{
			$this->map = array_intersect_key($this->map, $this->iterableToArray($traversable));
		}
		
		return $this;
	}
	
	/**
	 * @param iterable[] ...$map
	 * @return Map
	 */
	public function diff(...$map): Map
	{
		foreach ($map as $traversable)
		{
			$this->map = array_diff_key($this->map, $this->iterableToArray($traversable));
		}
		
		return $this;
	}
	
	/**
	 * @param iterable[] ...$map
	 * @return Map
	 */
	public function symmetricDiff(...$map): Map
	{
		$result = $this->map;
		
		foreach ($map as $traversable)
		{
			$traversableArray = $this->iterableToArray($traversable);
			$result = array_diff_key($result, $traversableArray) + array_diff_key($traversableArray, $result);
		}
		
		$this->map = $result;
		
		return $this;
	}
	
	public function toArray(): array
	{
		return $this->map;
	}
	
	/**
	 * Retrieve an external iterator
	 * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
	 * @return \Traversable An instance of an object implementing <b>Iterator</b> or
	 * <b>Traversable</b>
	 * @since 5.0.0
	 */
	public function getIterator()
	{
		return new \ArrayIterator($this->map);
	}
	
	/**
	 * Whether a offset exists
	 * @link http://php.net/manual/en/arrayaccess.offsetexists.php
	 * @param mixed $offset <p>
	 * An offset to check for.
	 * </p>
	 * @return boolean true on success or false on failure.
	 * </p>
	 * <p>
	 * The return value will be casted to boolean if non-boolean was returned.
	 * @since 5.0.0
	 */
	public function offsetExists($offset)
	{
		return $this->has($offset);
	}
	
	/**
	 * Offset to retrieve
	 * @link http://php.net/manual/en/arrayaccess.offsetget.php
	 * @param mixed $offset <p>
	 * The offset to retrieve.
	 * </p>
	 * @return mixed Can return all value types.
	 * @since 5.0.0
	 */
	public function offsetGet($offset)
	{
		return $this->get($offset);
	}
	
	/**
	 * Offset to set
	 * @link http://php.net/manual/en/arrayaccess.offsetset.php
	 * @param mixed $offset <p>
	 * The offset to assign the value to.
	 * </p>
	 * @param mixed $value <p>
	 * The value to set.
	 * </p>
	 * @return void
	 * @since 5.0.0
	 */
	public function offsetSet($offset, $value)
	{
		$this->add($offset, $value);
	}
	
	/**
	 * Offset to unset
	 * @link http://php.net/manual/en/arrayaccess.offsetunset.php
	 * @param mixed $offset <p>
	 * The offset to unset.
	 * </p>
	 * @return void
	 * @since 5.0.0
	 */
	public function offsetUnset($offset)
	{
		$this->remove($offset);
	}
	
	
	/**
	 * @param iterable[] ...$map
	 * @return Map
	 */
	public static function mergeMap(...$map): Map
	{
		if (!$map)
			return new Map();
		
		$result = new Map(array_shift($map));
		$result->merge(...$map);
		
		return $result;
	}
	
	/**
	 * @param iterable[] ...$map
	 * @return Map
	 */
	public static function intersectMap(...$map): Map
	{
		if (!$map)
			return new Map();
		
		$result = new Map(array_shift($map));
		$result->intersect(...$map);
		
		return $result;
	}
	
	/**
	 * @param iterable[] ...$map
	 * @return Map
	 */
	public static function diffMap(...$map): Map
	{
		if (!$map)
			return new Map();
		
		$result = new Map(array_shift($map));
		$result->diff(...$map);
		
		return $result;
	}
	
	/**
	 * @param iterable[] ...$map
	 * @return Map
	 */
	public static function symmetricDiffMap(...$map): Map
	{
		if (!$map)
			return new Map();
		
		$result = new Map(array_shift($map));
		$result->symmetricDiff(...$map);
		
		return $result;
	}
}