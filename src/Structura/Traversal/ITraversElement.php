<?php
namespace Structura\Traversal;


interface ITraversElement
{
	public function id(): string;
	public function compare(ITraversElement $with): int;
	
	public static function merge(ITraversElement $a, ITraversElement $b): ITraversElement;
	public static function parse(...$args): ITraversElement;
}