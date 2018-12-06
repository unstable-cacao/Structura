<?php
namespace Structura;


use Structura\Graph\Node;


class Graph
{
	/**
	 * @param IIdentified|IIdentified[] $items
	 */
	public function __construct($items)
	{
	}
	
	public function __clone()
	{
		
	}
	
	
	/**
	 * @param IIdentified|IIdentified[] $item
	 * @return Graph
	 */
	public function addNode($item): self 
	{
		
	}
	
	/**
	 * @param string|IIdentified $a
	 * @param string|IIdentified|string[]|IIdentified[] $b
	 * @return Graph
	 */
	public function connect($a, $b): self
	{
		
	}
	
	/**
	 * @param string[]|IIdentified[] $data
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
	 * @param IIdentified|string $key
	 * @return ?Node
	 */
	public function getNode($key): ?Node
	{
		
	}
	
	/**
	 * @param IIdentified[]|string[] $key
	 * @return Node[]
	 */
	public function getAllNodes($key): array
	{
		
	}
	
	/**
	 * @param string $key
	 * @return ?IIdentifiable
	 */
	public function get(string $key): ?IIdentified
	{
		
	}
	
	/**
	 * @param string[] $key
	 * @return IIdentified[]
	 */
	public function getAll(array $key): array
	{
		
	}
	
	/**
	 * @param IIdentified|string $key
	 * @return bool
	 */
	public function exists($key): bool
	{
		
	}
}