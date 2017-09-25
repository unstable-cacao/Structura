<?php
namespace Structura\Table\Index;


use Structura\Table\IIndex;


class BooleanIndex implements IIndex
{
	/** @var array */
	private $trueMap = [];
	
	/** @var array */
	private $falseMap = [];
	
	
	private function fixKeys(array $array): array 
	{
		$result = [];
		
		foreach ($array as $item) 
		{
			$result[$item] = $item;
		}
		
		return $result;
	}
	
	
	public function has($value): bool
	{
		$value = (bool)$value;
		
		if ($value)
			return $this->trueMap ? true : false;
		else
			return $this->falseMap ? true : false;
	}
	
	public function hasAny(array $value): bool
	{
		foreach ($value as $item)
		{
			if ($this->has($item))
				return true;
		}
		
		return false;
	}
	
	public function hasAll(array $value): bool
	{
		foreach ($value as $item)
		{
			if (!$this->has($item))
				return false;
		}
		
		return true;
	}
	
	
	public function add(int $rowID, $value): IIndex
	{
		$value = (bool)$value;
		
		if ($value)
		{
			if (key_exists($rowID, $this->falseMap))
				unset($this->falseMap[$rowID]);
			
			$this->trueMap[$rowID] = $rowID;
		}
		else
		{
			if (key_exists($rowID, $this->trueMap))
				unset($this->trueMap[$rowID]);
			
			$this->falseMap[$rowID] = $rowID;
		}
		
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
		$trueIDs = [];
		$falseIDs = [];
		
		foreach ($valueByRowID as $rowID => $value) 
		{
			$value = (bool)$value;
			
			if ($value)
				$trueIDs[$rowID] = $rowID;
			else
				$falseIDs[$rowID] = $rowID;
		}
		
		$this->trueMap = array_diff_key($this->trueMap, $trueIDs);
		$this->falseMap = array_diff_key($this->falseMap, $falseIDs);
		
		return $this;
	}
	
	/**
	 * @param mixed $value
	 * @return int[] Removed row IDs
	 */
	public function remValue($value): array
	{
		$value = (bool)$value;
		
		if ($value)
		{
			$result = $this->trueMap;
			$this->trueMap = [];
		}
		else 
		{
			$result = $this->falseMap;
			$this->falseMap = [];
		}
		
		return $result;
	}
	
	/**
	 * @param array $value
	 * @return int[] Removed row IDs
	 */
	public function remValues(array $value): array
	{
		$result = [];
		
		foreach ($value as $item) 
		{
			if (!$this->has($item))
				continue;
			
			$result = array_merge($result, $this->remValue($item));
		}
		
		$result = $this->fixKeys($result);
		
		return $result;
	}
	
	
	/**
	 * @param mixed $value
	 * @return int[]
	 */
	public function findValue($value): array
	{
		$value = (bool)$value;
		
		if ($value)
			return $this->trueMap;
		else
			return $this->falseMap;
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
			$result[$i] = $this->findValue($value);
		}
		
		return $result;
	}
	
	
	public function clear(): void
	{
		$this->trueMap = [];
		$this->falseMap = [];
	}
}