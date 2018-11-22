<?php
namespace Structura\Traversal;


class TraversConfig 
{
	private $maxPageSize	= 100;
	private $maxElements	= 100000;
	private $maxIterations	= 100;
	
	
	public function getMaxPageSize(): int
	{
		return $this->maxPageSize;
	}
	
	public function getMaxElements(): int
	{
		return $this->maxElements;
	}
	
	public function getMaxIterations(): int
	{
		return $this->maxIterations;
	}
	
	
	public function setMaxPageSize(int $max): TraversConfig
	{
		$this->maxPageSize = $max;
		return $this;
	}
	
	public function setMaxElements(int $max): TraversConfig
	{
		$this->maxElements = $max;
		return $this;
	}
	
	public function setMaxIterations(int $max): TraversConfig
	{
		$this->maxIterations = $max;
		return $this;
	}
	
	
	public function updateElements(int $queried): bool
	{
		$this->maxElements -= $queried;
		return $this->maxElements > 0;
	}
	
	public function updateIterations(): bool
	{
		$this->maxIterations--;
		return $this->maxIterations > 0;
	}
}