<?php
namespace Structura\Traversal;


use Structura\Arrays;


class ElementsContainer
{
	/** @var ITraversElement[] */
	private $queried = [];
	
	/** @var ITraversElement[] */
	private $target = [];
	
	
	/**
	 * @param ITraversElement|ITraversElement[] $elements
	 * @return ElementsContainer
	 */
	public function addElements($elements): self
	{
		$elements = Arrays::toArray($elements);
		
		/** @var ITraversElement $element */
		foreach ($elements as $element)
		{
			$id			= $element->id();
			$queried	= $this->queried[$id] ?? null;
			$target		= $this->target[$id] ?? null;
			
			if ($queried)
			{
				if ($queried->shouldOverrideBy($element))
				{
					unset($this->queried[$id]);
					$this->target[$id] = $element::merge($element, $queried);
				}
			}
			else if ($target)
			{
				$this->target[$id] = $element::merge($element, $target);
			}
			else
			{
				$this->target[$id] = $element;
			}
		}
		
		return $this;
	}
	
	/**
	 * @return ITraversElement[]
	 */
	public function getTargetElementsForQuery(): array
	{
		$result = $this->target;
		
		$this->queried = array_merge($this->queried, $this->target);
		$this->target = [];
		
		return array_values($result);
	}
}