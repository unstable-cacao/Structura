<?php
namespace Structura\Table;


interface IIndex
{
	public function has($value): bool;
	
	public function hasAny(array $value): bool;
	public function hasAll(array $value): bool;
	
	
	public function add(int $rowID, $value): IIndex;
	public function addBulk(array $valueByRowID): IIndex;

	/**
	 * @param mixed[] $valueByRowID
	 * @return IIndex
	 */
	public function remRowIDs(array $valueByRowID): IIndex;

	/**
	 * @param mixed $value
	 * @return int[] Removed row IDs
	 */
	public function remValue($value): array;

	/**
	 * @param array $value
	 * @return int[] Removed row IDs
	 */
	public function remValues(array $value): array;

	/**
	 * @param mixed $value
	 * @return int[]
	 */
	public function findValue($value): array;

	/**
	 * @param mixed[] $values
	 * @return int[][] Values matching the same index as value index.
	 */
	public function findValues(array $values): array;

	public function clear(): void;
}