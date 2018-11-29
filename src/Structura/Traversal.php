<?php
namespace Structura;


use Structura\Exceptions\StructuraException;
use Structura\Traversal\ElementsContainer;
use Structura\Traversal\ITraversElement;
use Structura\Traversal\ITraverser;
use Structura\Traversal\TraversConfig;
use Structura\Traversal\ITraversersSet;
use Structura\Traversal\GenericTraversersSet;


class Traversal
{
	/** @var TraversConfig */
	private $config;
	
	/** @var GenericTraversersSet */
	private $set;
	
	/** @var ElementsContainer[] */
	private $elements = [];
	
	
	private function getContainer($for): ElementsContainer
	{
		if (!is_string($for))
			$for = get_class($for);
		
		if (!isset($this->elements[$for]))
		{
			$this->elements[$for] = new ElementsContainer();
		}
		
		return $this->elements[$for];
	}
	
	
	public function __construct()
	{
		$this->set = new GenericTraversersSet();
		$this->config = new TraversConfig();
	}
	
	
	public function config(): TraversConfig
	{
		return $this->config;
	}
	
	
	/**
	 * @param string|string[]|ITraverser|ITraverser[]|ITraversersSet $item
	 * @return Traversal
	 */
	public function addTraverser($item): self
	{
		$this->set->add($item);
		return $this;
	}
	
	/**
	 * @param ITraversElement|string $element
	 * @param mixed[] ...$extra
	 * @return Traversal
	 */
	public function addElement($element, ...$extra): self
	{
		$c = $this->getContainer($element);
		
		if (is_string($element))
		{
			/** @var ITraversElement $element */
			$element = $element::parse(...$extra);
		}
		
		$c->addElements($element);
		
		return $this;
	}
	
	/**
	 * @param ITraversElement|ITraversElement[]|string|string[] $elements
	 * @param mixed[] ...$extra
	 * @return Traversal
	 */
	public function addElements($elements, ...$extra): self
	{
		if ($extra && !is_string($elements))
				throw new StructuraException('Extra params can be passed only with a class name of the element');
		
		if (is_array($elements))
		{
			foreach ($elements as $element)
			{
				$this->addElement($element);
			}
		}
		else
		{
			$this->addElement($elements, ...$extra);
		}
		
		return $this;
	}
	
	
	public function execute(): void
	{
		$config			= clone $this->config;
		$maxPageSize	= $config->getMaxPageSize();
		$traversers		= $this->set->getTraversers();
		
		if (!$traversers)
			return;
		
		while ($config->getMaxIterations() > 0 && $config->getMaxElements() > 0)
		{
			$found = false;
			
			foreach ($traversers as $traverser)
			{
				$container = $this->getContainer($traverser->getElementType());
				
				$data = $container->getTargetElementsForQuery();
				$data = array_splice($data, 0, $config->getMaxElements());
				
				if ($data) 
					$found = true;
				else 
					continue;
				
				foreach (array_chunk($data, $maxPageSize) as $chunk)
				{
					if (!$traverser->travers($chunk))
					{
						return;
					}
					
					if (!$config->updateElements(count($chunk)))
					{
						break;
					}
				}
				
				if (!$config->updateIterations() || $config->getMaxElements() <= 0)
				{
					break;
				}
			}
			
			if (!$found)
				break;
		}
	}
}