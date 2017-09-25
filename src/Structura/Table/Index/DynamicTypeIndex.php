<?php
namespace Structura\Table\Index;


use Structura\Table\IIndex;


class DynamicTypeIndex implements IIndex
{
	public function has($value): bool
	{
		// TODO: Implement has() method.
	}
	
	public function hasAny(array $value): bool
	{
		// TODO: Implement hasAny() method.
	}
	
	public function hasAll(array $value): bool
	{
		// TODO: Implement hasAll() method.
	}
	
	public function add(int $rowID, $value): IIndex
	{
		// TODO: Implement add() method.
	}
	
	public function addBulk(array $valueByRowID): IIndex
	{
		// TODO: Implement addBulk() method.
	}
	
	/**
	 * @param mixed[] $valueByRowID
	 * @return IIndex
	 */
	public function remRowIDs(array $valueByRowID): IIndex
	{
		// TODO: Implement remRowIDs() method.
	}
	
	/**
	 * @param mixed $value
	 * @return int[] Removed row IDs
	 */
	public function remValue($value): array
	{
		// TODO: Implement remValue() method.
	}
	
	/**
	 * @param array $value
	 * @return int[] Removed row IDs
	 */
	public function remValues(array $value): array
	{
		// TODO: Implement remValues() method.
	}
	
	/**
	 * @param mixed $value
	 * @return int[]
	 */
	public function findValue($value): array
	{
		// TODO: Implement findValue() method.
	}
	
	/**
	 * @param mixed[] $values
	 * @return int[][] Values matching the same index as value index.
	 */
	public function findValues(array $values): array
	{
		// TODO: Implement findValues() method.
	}
	
	public function clear(): void
	{
		// TODO: Implement clear() method.
	}
}