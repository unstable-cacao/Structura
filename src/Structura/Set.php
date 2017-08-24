<?php
namespace Structura;


use Structura\Exceptions\InvalidValueException;


class Set implements \IteratorAggregate, \ArrayAccess
{
	private const OBJECT = 'object';
	
	private const SCALAR = [
		'integer',
		'boolean',
		'double',
		'string'
	];
	
	
	private $set = [];
	
	
	private function isScalar($value): bool 
	{
		return in_array(gettype($value), self::SCALAR);
	}
	
	private function isIdentified($value): bool 
	{
		return (gettype($value) == self::OBJECT && get_class($value) instanceof IIdentified);
	}
	
	private function isTraversable($value): bool 
	{
		return (is_array($value) || (gettype($value) == self::OBJECT && get_class($value) instanceof IIdentified));
	}
	
	
	/**
	 * @param Set|\Traversable|array|null $source
	 */
	public function __construct($source = null)
	{
		if ($source)
		{
			$this->add($source);
		}
	}

	public function __clone()
	{
		
	}
	
	
	public function deepClone(): Set
	{
		
	}
	
	public function isEmpty(): bool
	{
		return ($this->set) ? false : true;
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
		if ($this->isScalar($value))
		{
			return key_exists($value, $this->set);
		}
		else if ($this->isIdentified($value))
		{
			return key_exists($value->getHashCode(), $this->set);
		}
		else
		{
			throw new InvalidValueException();
		}
	}
	
	/**
	 * @param string|int|IIdentified|array|Set|\Traversable $value
	 * @return bool True if at least one item from the list exists in the set.
	 */
	public function hasAny(...$value): bool 
	{
		$res = false;
		
		foreach ($value as $item) 
		{
			if ($this->isTraversable($item))
			{
				foreach ($item as $data) 
				{
					$res = $this->hasAny($data) || $res;
				}
			}
			else
			{
				$res = $this->has($item) || $res;
			}
			
			if ($res)
				break;
		}
		
		return $res;
	}
	
	/**
	 * @param string|int|IIdentified|array|Set|\Traversable $value
	 * @return bool True if all items from the list exists in the set.
	 */
	public function hasAll(...$value): bool 
	{
		$res = true;
		
		foreach ($value as $item)
		{
			if ($this->isTraversable($item))
			{
				foreach ($item as $data)
				{
					$res = $this->hasAll($data) && $res;
				}
			}
			else
			{
				$res = $this->has($item) && $res;
			}
			
			if (!$res)
				break;
		}
		
		return $res;
	}

	/**
	 * @param string|int|IIdentified|array|Set|\Traversable $value
	 */
	public function add(...$value): void
	{
		foreach ($value as $item)
		{
			if ($this->isScalar($item))
			{
				$this->set[$item] = $item;
			}
			else if ($this->isIdentified($item))
			{
				$this->set[$item->getHashCode()] = $item;
			}
			else if ($this->isTraversable($item))
			{
				foreach ($item as $data)
				{
					$this->add($data);
				}
			}
			else 
			{
				throw new InvalidValueException();
			}
		}
	}

	/**
	 * @param string|int|IIdentified|array|Set|\Traversable $value
	 */
	public function rem(...$value): void
	{
		foreach ($value as $item)
		{
			if ($this->isScalar($item))
			{
				unset($this->set[$item]);
			}
			else if ($this->isIdentified($item))
			{
				unset($this->set[$item->getHashCode()]);
			}
			else if ($this->isTraversable($item))
			{
				foreach ($item as $data)
				{
					$this->rem($data);
				}
			}
			else
			{
				throw new InvalidValueException();
			}
		}
	}

	/**
	 * @return array 
	 */
	public function toArray(): array
	{
		return array_values($this->set);
	}
	
	/**
	 * @param array|Set|\Traversable ...$set
	 */
	public function merge(...$set): void
	{
		$this->add($set);
	}
	
	/**
	 * @param array|Set|\Traversable ...$set
	 */
	public function intersect(...$set): void
	{
		
	}
	
	/**
	 * @param array|Set|\Traversable ...$set
	 */
	public function diff(...$set): void
	{
		
	}
	
	/**
	 * @param array|Set|\Traversable ...$set
	 */
	public function symmetricDiff(...$set): void
	{
		
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
		return (function() {
			foreach ($this->set as $key => $value) {
				yield $key => $value;
			}
		})();
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
		// TODO: Implement offsetExists() method.
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
		// TODO: Implement offsetGet() method.
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
		// TODO: Implement offsetSet() method.
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
		// TODO: Implement offsetUnset() method.
	}
}