<?php
namespace Structura;


use Structura\Graph\Node;


class Graph
{
	/**
	 * @param IIdentifiable|IIdentifiable[] $items
	 */
	public function __construct($items)
	{
	}
	
	public function __clone()
	{
		
	}
	
	
	/**
	 * @param IIdentifiable|IIdentifiable[] $item
	 * @return Graph
	 */
	public function addNode($item): self 
	{
		
	}
	
	/**
	 * @param string|IIdentifiable $a
	 * @param string|IIdentifiable|string[]|IIdentifiable[] $b
	 * @return Graph
	 */
	public function connect($a, $b): self
	{
		
	}
	
	/**
	 * @param string[]|IIdentifiable[] $data
	 * @return Graph
	 */
	public function connectByKey(array $data): self
	{
		
	}
	
	/**
	 * @param [[string|IIdentifiable,string|IIdentifiable]] $data
	 * @return Graph
	 */
	public function connectPairs(array $data): self
	{
		
	}
	
	/**
	 * @param IIdentifiable|string $key
	 * @return ?Node
	 */
	public function getNode($key): ?Node
	{
		
	}
	
	/**
	 * @param IIdentifiable[]|string[] $key
	 * @return Node[]
	 */
	public function getAllNodes($key): array
	{
		
	}
	
	/**
	 * @param string $key
	 * @return ?IIdentifiable
	 */
	public function get(string $key): ?IIdentifiable
	{
		
	}
	
	/**
	 * @param string[] $key
	 * @return IIdentifiable[]
	 */
	public function getAll(array $key): array
	{
		
	}
	
	/**
	 * @param IIdentifiable|string $key
	 * @return bool
	 */
	public function exists($key): bool
	{
		
	}
}