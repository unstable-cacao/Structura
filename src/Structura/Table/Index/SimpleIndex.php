<?php
namespace Structura\Table\Index;


use Structura\Table\IIndex;


class SimpleIndex implements IIndex
{
	/** @var array */
	private $map = [];
	
	
	public function has($value): bool
	{
		return key_exists($value, $this->map);
	}
	
	public function hasAny(array $value): bool
	{
		foreach ($value as $item) 
		{
			if (key_exists($item, $this->map))
				return true;
		}
		
		return false;
	}
	
	public function hasAll(array $value): bool
	{
		foreach ($value as $item)
		{
			if (!key_exists($item, $this->map))
				return false;
		}
		
		return true;
	}
	
	
	public function add(int $rowID, $value): IIndex
	{
		foreach ($this->map as $valueKey => $rowIDs) 
		{
			if (key_exists($rowID, $rowIDs))
				$this->remRowIDs([$rowID => $valueKey]);
		}
		
		if (!key_exists($value, $this->map))
		{
			$this->map[$value] = [];
		}
		
		$this->map[$value][$rowID] = $rowID;
		
		return $this;
	}
	
	public function addBulk(array $valueByRowID): IIndex
	{
		foreach ($valueByRowID as $rowID => $value) 
		{
			$this->add($rowID, $value);
		}
		
		return $this;
	}
	
	
	/**
	 * @param mixed[] $valueByRowID
	 * @return IIndex
	 */
	public function remRowIDs(array $valueByRowID): IIndex
	{
		foreach ($valueByRowID as $rowID => $value) 
		{
			unset($this->map[$value][$rowID]);
			
			if (key_exists($value, $this->map) && !$this->map[$value])
				unset($this->map[$value]);
		}
		
		return $this;
	}
	
	/**
	 * @param mixed $value
	 * @return int[] Removed row IDs
	 */
	public function remValue($value): array
	{
		$result = $this->map[$value] ?? [];
		unset($this->map[$value]);
		
		return $result;
	}
	
	/**
	 * @param array $value
	 * @return int[] Removed row IDs
	 */
	public function remValues(array $value): array
	{
		$result = [];
		
		foreach ($value as $valueToRemove) 
		{
			$result += $this->remValue($valueToRemove);
		}
		
		return $result;
	}
	
	
	/**
	 * @param mixed $value
	 * @return int[]
	 */
	public function findValue($value): array
	{
		return $this->map[$value] ?? [];
	}
	
	/**
	 * @param mixed[] $values
	 * @return int[][] Values matching the same index as value index.
	 */
	public function findValues(array $values): array
	{
		$result = [];
		
		foreach ($values as $i => $value) 
		{
			$result[$i] = $this->map[$value] ?? [];
		}
		
		return $result;
	}
	
	
	public function clear(): void
	{
		$this->map = [];
	}
}