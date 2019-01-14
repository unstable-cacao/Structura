<?php
namespace Structura\Graph;


use Structura\IIdentified;


class Node
{
	public function __construct(IIdentified $item)
	{
	}
	
	public function __clone()
	{
		
	}
	
	
	public function get(): IIdentified
	{
		
	}
	
	/**
	 * @param Node|Node[] $with
	 * @param mixed|null $data
	 */
	public function connect($with, $data = null): void
	{
		
	}
	
	/**
	 * @param Node|IIdentified|string $to
	 * @return bool
	 */
	public function isConnectedTo($to): bool
	{
		
	}
	
	/**
	 * @param Node|IIdentified|string $with
	 * @return bool
	 */
	public function getVertexData($with): bool
	{
		
	}
	
	/**
	 * @return Node[]
	 */
	public function getConnected(): array
	{
		
	}
	
	/**
	 * @param Node|IIdentified|string $with
	 * @return null|Vertex
	 */
	public function getVertex($with): ?Vertex
	{
		
	}
	
	/**
	 * @param Node[]|IIdentified[]|string[] $with
	 * @return array
	 */
	public function getVertexes(array $with): array
	{
		
	}
	
	/**
	 * @param Node|IIdentified|string|[]|IIdentifiable[]|string[] $from
	 */
	public function disconnect($from): void
	{
		
	}
	
	public function connectionsCount(): int
	{
		
	}
}