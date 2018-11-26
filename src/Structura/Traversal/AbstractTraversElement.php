<?php
namespace Structura\Traversal;


abstract class AbstractTraversElement implements ITraversElement
{
	public function shouldOverrideBy(ITraversElement $with): bool
	{
		return true;
	}
	
	public function preTravers(): void
	{
		
	}
	
	
	public static function parse(...$args): ITraversElement
	{
		return new static(...$args);
	}
}