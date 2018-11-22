<?php
namespace Structura\Traversal;


use Structura\Exceptions\StructuraException;


class GenericTraversersSet implements ITraversersSet
{
	/** @var ITraverser[] */
	private $traversers = [];
	
	
	/**
	 * @param string|string[]|ITraverser|ITraverser[]|ITraversersSet $item
	 */
	public function add($item)
	{
		if (is_string($item))
		{
			$this->traversers[] = new $item;
		}
		else if (is_array($item))
		{
			foreach ($item as $i)
			{
				$this->add($i);
			}
		}
		else if ($item instanceof ITraverser)
		{
			$this->traversers[] = $item;
		}
		else if ($item instanceof ITraversersSet)
		{
			$this->add($item->getTraversers());
		}
		else
		{
			throw new StructuraException(
				'Unexpected parameter type. Expecting string, array or ' . ITraverser::class);
		}
	}
	
	/**
	 * @return ITraverser[]
	 */
	public function getTraversers(): array
	{
		return $this->traversers;
	}
}