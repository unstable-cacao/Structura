<?php
namespace Structura\Table;


interface IIndex
{
	public function add(int $index, $value): IIndex;
	public function addBulk(array $valueByIndex): IIndex;

	/**
	 * @param mixed[] $valueByIndex
	 * @return IIndex
	 */
	public function remIndexes(array $valueByIndex): IIndex;

	/**
	 * @param mixed $value
	 * @return int[] Removed indexes
	 */
	public function remValue($value): array;

	/**
	 * @param array $value
	 * @return int[] Removed indexes
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
}