<?php
namespace Structura\Traversal;


interface ITraverser
{
	public function getElementType(): string;
	
	/**
	 * @param ITraversElement[] $elements
	 * @return bool
	 */
	public function travers(array $elements): bool;
}