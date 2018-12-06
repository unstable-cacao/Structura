<?php
namespace Structura\Graph;


use Structura\IIdentifiable;


class Node
{
	public function __construct(IIdentifiable $item)
	{
	}
	
	public function __clone()
	{
		
	}
	
	
	public function get(): IIdentifiable
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
	 * @param Node|IIdentifiable|string $to
	 * @return bool
	 */
	public function isConnectedTo($to): bool
	{
		
	}
	
	/**
	 * @param Node|IIdentifiable|string $with
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
	 * @param Node|IIdentifiable|string $with
	 * @return null|Vertex
	 */
	public function getVertex($with): ?Vertex
	{
		
	}
	
	/**
	 * @param Node[]|IIdentifiable[]|string[] $with
	 * @return array
	 */
	public function getVertexes(array $with): array
	{
		
	}
	
	/**
	 * @param Node|IIdentifiable|string|[]|IIdentifiable[]|string[] $from
	 */
	public function disconnect($from): void
	{
		
	}
	
	public function connectionsCount(): int
	{
		
	}
}