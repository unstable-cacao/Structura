<?php
namespace Structura;


interface ICollection extends \Countable
{
	public function isEmpty(): bool;
	public function hasElements(): bool;
	public function clear();
	public function toArray(): array;
}