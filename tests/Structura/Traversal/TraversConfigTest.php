<?php
namespace Structura\Traversal;


use PHPUnit\Framework\TestCase;


class TraversConfigTest extends TestCase
{
	public function test_sanity(): void
	{
		$c = new TraversConfig();
		
		self::assertSame($c, $c->setMaxElements(10));
		self::assertSame($c, $c->setMaxIterations(11));
		self::assertSame($c, $c->setMaxPageSize(12));
		
		self::assertEquals(10, $c->getMaxElements());
		self::assertEquals(11, $c->getMaxIterations());
		self::assertEquals(12, $c->getMaxPageSize());
	}
	
	public function test_updateElements(): void
	{
		$c = new TraversConfig();
		
		$c->setMaxElements(12);
		$c->updateElements(5);
		
		self::assertEquals(7, $c->getMaxElements());
	}
	
	public function test_updateElements_ReturnValue(): void
	{
		$c = new TraversConfig();
		
		$c->setMaxElements(12);
		self::assertTrue($c->updateElements(5));
		
		$c->setMaxElements(12);
		self::assertFalse($c->updateElements(12));
		
		$c->setMaxElements(12);
		self::assertFalse($c->updateElements(13));
	}
	
	public function test_updateIterations(): void
	{
		$c = new TraversConfig();
		
		$c->setMaxIterations(12);
		$c->updateIterations();
		
		self::assertEquals(11, $c->getMaxIterations());
	}
	
	public function test_updateIterations_ReturnValue(): void
	{
		$c = new TraversConfig();
		
		$c->setMaxIterations(2);
		
		self::assertTrue($c->updateIterations());
		self::assertFalse($c->updateIterations());
		self::assertFalse($c->updateIterations());
	}
}