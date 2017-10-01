<?php
namespace Structura\Table\Index;


use Structura\Table\IIndex;


class DynamicTypeIndex implements IIndex
{
	private const INT 		= 'integer';
	private const FLOAT 	= 'double';
	private const STRING 	= 'string';
	private const BOOL 		= 'boolean';
	private const NULL 		= 'NULL';
	
	
	private $objectMap = [];
	
	private $objectRowIDsMap = [];
	
	private $lastIndex = 0;
	
	private $nullIndexes = [];
	
	private $boolMap = [];
	
	private $intMap = [];
	
	private $stringMap = [];
	
	private $floatMap = [];
	
	
	private function intRemRowIDs(int $rowID, int $value)
	{
		unset($this->intMap[$value][$rowID]);
		
		if (key_exists($value, $this->intMap) && !$this->intMap[$value])
			unset($this->intMap[$value]);
	}
	
	private function boolRemRowIDs(int $rowID, int $value)
	{
		unset($this->boolMap[$value][$rowID]);
		
		if (key_exists($value, $this->boolMap) && !$this->boolMap[$value])
			unset($this->boolMap[$value]);
	}
	
	private function stringRemRowIDs(int $rowID, string $value)
	{
		unset($this->stringMap[$value][$rowID]);
		
		if (key_exists($value, $this->stringMap) && !$this->stringMap[$value])
			unset($this->stringMap[$value]);
	}
	
	private function floatRemRowIDs(int $rowID, string $value)
	{
		unset($this->floatMap[$value][$rowID]);
		
		if (key_exists($value, $this->floatMap) && !$this->floatMap[$value])
			unset($this->floatMap[$value]);
	}
	
	private function objectRemRowIDs(int $rowID, int $index)
	{
		unset($this->objectRowIDsMap[$index][$rowID]);
		
		if (!$this->objectRowIDsMap[$index])
		{
			unset($this->objectRowIDsMap[$index]);
			unset($this->objectMap[$index]);
		}
	}
	
	
	public function has($value): bool
	{
		switch (gettype($value))
		{
			case self::INT:
				return key_exists($value, $this->intMap);
			case self::FLOAT:
				if ($value == (int)$value)
					return key_exists((int)$value, $this->intMap);
				else
					return key_exists((string)$value, $this->floatMap);
			case self::STRING:
				return key_exists($value, $this->stringMap);
			case self::BOOL:
				return key_exists((int)$value, $this->boolMap);
			case self::NULL:
				return $this->nullIndexes ? true : false;
			default:
				return array_search($value, $this->objectMap) === false ? false : true;
		}
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
		foreach ($this->intMap as $valueKey => $rowIDs)
		{
			if (key_exists($rowID, $rowIDs))
				$this->intRemRowIDs($rowID, $valueKey);
		}
		
		foreach ($this->floatMap as $valueKey => $rowIDs)
		{
			if (key_exists($rowID, $rowIDs))
				$this->floatRemRowIDs($rowID, $valueKey);
		}
		
		foreach ($this->stringMap as $valueKey => $rowIDs)
		{
			if (key_exists($rowID, $rowIDs))
				$this->stringRemRowIDs($rowID, $valueKey);
		}
		
		foreach ($this->boolMap as $valueKey => $rowIDs)
		{
			if (key_exists($rowID, $rowIDs))
				$this->boolRemRowIDs($rowID, $valueKey);
		}
		
		if (key_exists($rowID, $this->nullIndexes))
			unset($this->nullIndexes[$rowID]);
		
		foreach ($this->objectRowIDsMap as $index => $rowIDs) 
		{
			if (key_exists($rowID, $rowIDs))
				$this->objectRemRowIDs($rowID, $index);
		}
		
		switch (gettype($value))
		{
			case self::INT:
				$this->intMap[$value][$rowID] = $rowID;
				break;
			case self::FLOAT:
				if ($value == (int)$value)
				{
					$this->intMap[(int)$value][$rowID] = $rowID;
				}
				else
				{
					$this->floatMap[(string)$value][$rowID] = $rowID;
				}
				
				break;
			case self::STRING:
				$this->stringMap[$value][$rowID] = $rowID;
				break;
			case self::BOOL:
				$this->boolMap[$value][$rowID] = $rowID;
				break;
			case self::NULL:
				$this->nullIndexes[$rowID] = $rowID;
				break;
			default:
				$i = array_search($value, $this->objectMap);
				
				if ($i === false)
				{
					$i = $this->lastIndex;
					$this->lastIndex++;
					$this->objectMap[$i] = $value;
				}
				
				$this->objectRowIDsMap[$i][$rowID] = $rowID;
				
				break;
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
		foreach ($valueByRowID as $rowID => $value)
		{
			switch (gettype($value))
			{
				case self::INT:
					$this->intRemRowIDs($rowID, $value);
					break;
				case self::FLOAT:
					if ($value == (int)$value)
					{
						$this->intRemRowIDs($rowID, $value);
					}
					else
					{
						$this->floatRemRowIDs($rowID, $value);
					}
					
					break;
				case self::STRING:
					$this->stringRemRowIDs($rowID, $value);
					break;
				case self::BOOL:
					$this->boolRemRowIDs($rowID, $value);
					break;
				case self::NULL:
					unset($this->nullIndexes[$rowID]);
					break;
				default:
					$i = array_search($value, $this->objectMap);
					
					if ($i !== false)
					{
						$this->objectRemRowIDs($rowID, $i);
					}
					break;
			}
		}
		
		return $this;
	}
	
	/**
	 * @param mixed $value
	 * @return int[] Removed row IDs
	 */
	public function remValue($value): array
	{
		$result = [];
		
		switch (gettype($value))
		{
			case self::INT:
				$result = $this->intMap[$value] ?? [];
				unset($this->intMap[$value]);
				break;
			case self::FLOAT:
				if ($value == (int)$value)
				{
					$value = (int)$value;
					$result = $this->intMap[$value] ?? [];
					unset($this->intMap[$value]);
				}
				else
				{
					$value = (string)$value;
					$result = $this->floatMap[$value] ?? [];
					unset($this->floatMap[$value]);
				}
				
				break;
			case self::STRING:
				$result = $this->stringMap[$value] ?? [];
				unset($this->stringMap[$value]);
				break;
			case self::BOOL:
				$result = $this->boolMap[$value] ?? [];
				unset($this->boolMap[$value]);
				break;
			case self::NULL:
				$result = $this->nullIndexes;
				$this->nullIndexes = [];
				break;
			default:
				$i = array_search($value, $this->objectMap);
				
				if ($i !== false)
				{
					$result = $this->objectRowIDsMap[$i];
					unset($this->objectMap[$i]);
					unset($this->objectRowIDsMap[$i]);
				}
				break;
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
		switch (gettype($value))
		{
			case self::INT:
				return $this->intMap[$value] ?? [];
			case self::FLOAT:
				if ($value == (int)$value)
				{
					return $this->intMap[(int)$value] ?? [];
				}
				else
				{
					return $this->floatMap[(string)$value] ?? [];
				}
				
				break;
			case self::STRING:
				return $this->stringMap[$value] ?? [];
			case self::BOOL:
				return $this->boolMap[$value] ?? [];
			case self::NULL:
				return $this->nullIndexes;
			default:
				$i = array_search($value, $this->objectMap);
				
				if ($i !== false)
				{
					return $this->objectRowIDsMap[$i];
				}
				else
				{
					return [];
				}
		}
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
		$this->objectMap = [];
		$this->objectRowIDsMap = [];
		$this->nullIndexes = [];
		$this->boolMap = [];
		$this->intMap = [];
		$this->stringMap = [];
		$this->floatMap = [];
		$this->boolMap = [];
	}
}