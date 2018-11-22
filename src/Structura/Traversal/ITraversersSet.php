<?php
namespace Structura\Traversal;


interface ITraversersSet
{
	/**
	 * @return ITraverser[]
	 */
	public function getTraversers(): array;
}