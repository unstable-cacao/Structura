<?php
namespace Structura\Cache;


interface IMonoCache
{
	/**
	 * @return mixed|null
	 */
	public function get();
	
	public function put($value, ?float $ttl = null): void;
	public function has(): bool;
	public function clear(): void;
}