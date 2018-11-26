<?php
namespace Structura\Traversal;


use PHPUnit\Framework\TestCase;


class AbstractTraversElementTest extends TestCase
{
	public function test_sanity()
	{
		/** @var AbstractTraversElement $a */
		$a = new class extends AbstractTraversElement
		{	
			public $args;
			
			
			public function __construct(...$args)
			{
				$this->args = $args;
			}
			
			
			public function id(): string
			{
				return '';
			}
			
			public static function merge(ITraversElement $a, ITraversElement $b): ITraversElement
			{
				return $a;
			}
		};
		
		
		/** @var AbstractTraversElement $class */
		$class = get_class($a);
		$b = $class::parse('a', 123);
		
	
		/** @noinspection PhpUndefinedFieldInspection */
		self::assertEquals(['a', 123], $b->args);
		self::assertTrue($b->shouldOverrideBy($a));
	}
}