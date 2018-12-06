<?php
namespace Structura;


use Structura\Exceptions\InvalidValueException;


class Set implements \IteratorAggregate, \ArrayAccess, \Countable, ICollection
{
	private $set = [];
	
	
	/**
	 * @param int|string|bool|float|IIdentified $value
	 * @return string|int
	 */
	private function getKey($value)
	{
		if (is_scalar($value))
			return $value;
		else if ($value instanceof IIdentified)
			return $value->id();
		else
			throw new InvalidValueException();
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
	
	
	public function __construct(?iterable $source = null)
	{
		if ($source)
		{
			$this->add($source);
		}
	}
	
	
	public function deepClone(): Set
	{
		$newSet = [];
		
		foreach ($this->set as $item) 
		{
			if ($item instanceof IIdentified)
			{
				$newSet[] = clone $item;
			}
			else
			{
				$newSet[] = $item;
			}
		}
		
		return new Set($newSet);
	}
	
	public function isEmpty(): bool
	{
		return !(bool)$this->set;
	}
	
	public function hasElements(): bool
	{
		return (bool)$this->set;
	}
	
	public function count(): int
	{
		return count($this->set);
	}
	
	/**
	 * @param string|int|IIdentified $value
	 * @return bool True if the item is in this set.
	 */
	public function has($value): bool 
	{
		return key_exists($this->getKey($value), $this->set);
	}
	
	/**
	 * @param string|int|IIdentified|iterable $value
	 * @return bool True if at least one item from the list exists in the set.
	 */
	public function hasAny(...$value): bool 
	{
		foreach ($value as $item) 
		{
			if (is_iterable($item))
			{
				foreach ($item as $data) 
				{
					if ($this->hasAny($data))
						return true;
				}
			}
			else
			{
				if ($this->has($item))
					return true;
			}
		}
		
		return false;
	}
	
	/**
	 * @param string|int|IIdentified|iterable $value
	 * @return bool True if all items from the list exists in the set.
	 */
	public function hasAll(...$value): bool 
	{
		foreach ($value as $item)
		{
			if (is_iterable($item))
			{
				foreach ($item as $data)
				{
					if (!$this->hasAll($data))
						return false;
				}
			}
			else
			{
				if (!$this->has($item))
					return false;
			}
		}
		
		return true;
	}

	/**
	 * @param string|int|IIdentified|iterable $value
	 */
	public function add(...$value): void
	{
		foreach ($value as $item)
		{
			if (is_iterable($item))
			{
				foreach ($item as $data)
				{
					$this->add($data);
				}
			}
			else
			{
				$this->set[$this->getKey($item)] = $item;
			}
		}
	}
	
	public function addIfMissing($value): bool
	{
		if ($this->has($value))
		{
			return false;
		}
		else
		{
			$this->add($value);
			return true;
		}
	}

	/**
	 * @param string|int|IIdentified|iterable $value
	 */
	public function rem(...$value): void
	{
		foreach ($value as $item)
		{
			if (is_iterable($item))
			{
				foreach ($item as $data)
				{
					$this->rem($data);
				}
			}
			else
			{
				unset($this->set[$this->getKey($item)]);
			}
		}
	}
	
	public function clear(): void
	{
		$this->set = [];
	}

	/**
	 * @return array 
	 */
	public function toArray(): array
	{
		return array_values($this->set);
	}
	
	/**
	 * @param iterable ...$set
	 */
	public function merge(...$set): void
	{
		$this->add($set);
	}
	
	/**
	 * @param iterable ...$set
	 */
	public function intersect(...$set): void
	{
		foreach ($set as $iterable) 
		{
			$this->set = array_intersect($this->set, $this->iterableToArray($iterable));
		}
	}
	
	/**
	 * @param iterable ...$set
	 */
	public function diff(...$set): void
	{
		foreach ($set as $iterable)
		{
			$this->set = array_diff($this->set, $this->iterableToArray($iterable));
		}
	}
	
	/**
	 * @param iterable ...$set
	 */
	public function symmetricDiff(...$set): void
	{
		$result = $this->set;
		
		foreach ($set as $iterable)
		{
			$array = $this->iterableToArray($iterable);
			$result = array_diff($result, $array) + array_diff($array, $result);
		}
		
		$this->clear();
		$this->add($result);
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
		return new \ArrayIterator($this->set);
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
		return key_exists($offset, $this->set);
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
		return $this->offsetExists($offset);
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
		if ($value)
		{
			$this->add($offset);
		}
		else
		{
			$this->rem($offset);
		}
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
		unset($this->set[$this->getKey($offset)]);
	}
}