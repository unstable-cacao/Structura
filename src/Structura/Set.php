<?php
namespace Structura;


class Set implements \IteratorAggregate, \ArrayAccess
{
	/**
	 * @param Set|\Traversable|array|null $source
	 */
	public function __construct($source = null)
	{
		
	}

	public function __clone()
	{
		
	}
	
	
	public function deepClone(): Set
	{
		
	}
	
	public function isEmpty(): bool
	{
		
	}
	
	public function count(): int
	{
		
	}
	
	/**
	 * @param string|int|IIdentified $value
	 * @return bool True if the item is in this set.
	 */
	public function has($value): bool 
	{
		
	}
	
	/**
	 * @param string|int|IIdentified|array|Set|\Traversable $value
	 * @return bool True if at least one item from the list exists in the set.
	 */
	public function hasAny(...$value): bool 
	{
		
	}
	
	/**
	 * @param string|int|IIdentified|array|Set|\Traversable $value
	 * @return bool True if all items from the list exists in the set.
	 */
	public function hasAll(...$value): bool 
	{
		
	}

	/**
	 * @param string|int|IIdentified|array|Set|\Traversable $value
	 */
	public function add(...$value): void
	{
		
	}

	/**
	 * @param string|int|IIdentified|array|Set|\Traversable $value
	 */
	public function rem(...$value): void
	{
		
	}

	/**
	 * @return array 
	 */
	public function toArray(): array
	{
		
	}
	
	/**
	 * @param array|Set|\Traversable ...$set
	 */
	public function merge(...$set): void
	{
		
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
	 * Retrieve an external iterator
	 * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
	 * @return \Traversable An instance of an object implementing <b>Iterator</b> or
	 * <b>Traversable</b>
	 * @since 5.0.0
	 */
	public function getIterator()
	{
		// TODO: Implement getIterator() method.
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