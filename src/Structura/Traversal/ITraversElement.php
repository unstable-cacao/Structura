<?php
namespace Structura\Traversal;


interface ITraversElement
{
	public function id(): string;
	public function shouldOverrideBy(ITraversElement $with): bool;
	public function preTravers(): void;
	
	public static function merge(ITraversElement $a, ITraversElement $b): ITraversElement;
	public static function parse(...$args): ITraversElement;
}